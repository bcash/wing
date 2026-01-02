<?php

namespace App\Libraries\Osc;

use Exception;

/**
 * Two-Way OSC Client for Behringer WING Console
 * 
 * Implements proper OSC over UDP with bidirectional communication.
 * Based on WING Remote Protocols v3.0.5 and empirical behavior.
 * 
 * Key requirements:
 * - Must bind to local port
 * - Must send and receive on same socket
 * - Must keep socket open until response received
 * - WING replies to source IP and port
 */
class OscClient
{
    private string $remoteIp;
    private int $remotePort;
    private int $localPort;
    /** @var resource|\Socket|null */
    private $socket = null;
    private int $timeoutSeconds = 2;
    private ?float $requestRate = null;
    private float $lastRequestTime = 0;

    /**
     * @param string $remoteIp Console IP address
     * @param int $remotePort Console OSC port (default: 2223)
     * @param int $localPort Local port to bind to (default: 9000)
     * @param int $timeoutSeconds Receive timeout in seconds (default: 2)
     * @param float|null $requestRate Requests per second (null = no throttling)
     */
    public function __construct(
        string $remoteIp,
        int $remotePort = 2223,
        int $localPort = 9000,
        int $timeoutSeconds = 2,
        ?float $requestRate = null
    ) {
        $this->remoteIp = $remoteIp;
        $this->remotePort = $remotePort;
        $this->localPort = $localPort;
        $this->timeoutSeconds = $timeoutSeconds;
        $this->requestRate = $requestRate;
    }

    /**
     * Create and bind UDP socket
     * 
     * This is REQUIRED - WING replies to the source IP and port.
     * Without binding, replies may go to a port we're not listening on.
     */
    public function connect(): void
    {
        // Force IPv4 (not IPv6) - critical on macOS
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if ($this->socket === false) {
            throw new Exception('Failed to create UDP socket: ' . socket_strerror(socket_last_error()));
        }

        // REQUIRED: Bind to local port so WING can reply
        // WING always replies to the source IP and source UDP port
        if (!socket_bind($this->socket, '0.0.0.0', $this->localPort)) {
            $error = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to bind UDP socket to port {$this->localPort}: {$error}");
        }
    }

    /**
     * Send OSC message and wait for response
     * 
     * @param string $path OSC address pattern (e.g., "/ch/01")
     * @param string $types Type tag string (e.g., ",s" for string, ",sff" for string+float+float)
     * @param array $args Arguments matching the type tag
     * @return OscResponse|null Response or null on timeout
     * @throws Exception On send failure
     */
    public function send(string $path, string $types = ',', array $args = []): ?OscResponse
    {
        if ($this->socket === null) {
            $this->connect();
        }

        // Throttle requests if rate limit is set
        $this->throttle();

        // Build OSC message
        $message = OscEncoder::encode($path, $types, $args);

        // Send to console
        $sent = socket_sendto(
            $this->socket,
            $message,
            strlen($message),
            0,
            $this->remoteIp,
            $this->remotePort
        );

        if ($sent === false) {
            $error = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to send OSC message: {$error}");
        }

        if ($sent !== strlen($message)) {
            throw new Exception(
                "Partial send: {$sent} of " . strlen($message) . " bytes sent"
            );
        }

        // Set receive timeout AFTER sending (matches working test script pattern)
        // WING replies quickly (typically <10 ms), but we allow up to timeoutSeconds
        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, [
            'sec' => $this->timeoutSeconds,
            'usec' => 0
        ]);

        // Receive reply on the SAME socket we sent from
        // WING replies to the source IP and port of the incoming packet
        $response = '';
        $from = '';
        $fromPort = 0;

        $received = @socket_recvfrom(
            $this->socket,
            $response,
            65536, // Max UDP size
            0,
            $from,
            $fromPort
        );

        if ($received === false || $received === 0) {
            // No response received (timeout or error)
            // This is a valid outcome - WING may not respond to all queries
            return null;
        }

        // Successfully received response
        return OscResponse::fromBinary($response);
    }

    /**
     * Send OSC message without waiting for response
     * 
     * @param string $path OSC address pattern
     * @param string $types Type tag string
     * @param array $args Arguments
     * @return int Bytes sent
     * @throws Exception On send failure
     */
    public function sendOnly(string $path, string $types = ',', array $args = []): int
    {
        if ($this->socket === null) {
            $this->connect();
        }

        $message = OscEncoder::encode($path, $types, $args);

        $sent = socket_sendto(
            $this->socket,
            $message,
            strlen($message),
            0,
            $this->remoteIp,
            $this->remotePort
        );

        if ($sent === false) {
            $error = socket_strerror(socket_last_error($this->socket));
            throw new Exception("Failed to send OSC message: {$error}");
        }

        return $sent;
    }

    /**
     * Throttle requests to respect rate limit
     */
    private function throttle(): void
    {
        if ($this->requestRate === null) {
            return; // No throttling
        }

        $minInterval = 1.0 / $this->requestRate;
        $elapsed = microtime(true) - $this->lastRequestTime;
        
        if ($elapsed < $minInterval) {
            usleep((int)(($minInterval - $elapsed) * 1000000));
        }
        
        $this->lastRequestTime = microtime(true);
    }

    /**
     * Get the local port this socket is bound to
     * 
     * @return int Local port number
     */
    public function getLocalPort(): int
    {
        if ($this->socket === null) {
            return $this->localPort;
        }

        $name = '';
        $port = 0;
        if (socket_getsockname($this->socket, $name, $port)) {
            return $port;
        }

        return $this->localPort;
    }

    /**
     * Query node children (list sub-paths)
     * 
     * @param string $path OSC path
     * @return array|null List of child path names, or null on timeout/error
     */
    public function listChildren(string $path): ?array
    {
        // Query node with no arguments - WING returns child names as strings
        $response = $this->send($path, ',', []);
        
        if ($response === null) {
            return null;
        }

        if ($response->isError()) {
            return null;
        }

        // WING returns string array of child paths in args
        // Extract string arguments as children
        $children = $response->getStrings();

        return empty($children) ? null : $children;
    }

    /**
     * Send bulk dump request
     * 
     * @param string $path OSC path
     * @return OscResponse|null Response data or null on timeout
     */
    public function bulkDump(string $path): ?OscResponse
    {
        // Bulk dump format: /path ,s *
        return $this->send($path, ',s', ['*']);
    }

    /**
     * Close socket connection
     */
    public function disconnect(): void
    {
        if ($this->socket !== null) {
            socket_close($this->socket);
            $this->socket = null;
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}

