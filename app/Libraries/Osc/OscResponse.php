<?php

namespace App\Libraries\Osc;

use Exception;

/**
 * OSC Response Object
 * 
 * Represents a decoded OSC response from the console.
 */
class OscResponse
{
    public string $path;
    public string $types;
    public array $args;
    public string $rawBinary;

    private function __construct(string $path, string $types, array $args, string $rawBinary)
    {
        $this->path = $path;
        $this->types = $types;
        $this->args = $args;
        $this->rawBinary = $rawBinary;
    }

    /**
     * Create OscResponse from binary OSC data
     * 
     * @param string $binary Binary OSC message
     * @return OscResponse
     * @throws Exception If decoding fails
     */
    public static function fromBinary(string $binary): OscResponse
    {
        $decoded = OscEncoder::decode($binary);
        
        if ($decoded === null) {
            // Debug: show what we're trying to decode
            $hex = bin2hex(substr($binary, 0, 64));
            throw new Exception("Failed to decode OSC response. First 64 bytes (hex): {$hex}");
        }

        return new self(
            $decoded['path'],
            $decoded['types'],
            $decoded['args'],
            $binary
        );
    }

    /**
     * Check if this is an error response
     * 
     * WING returns errors as /* with a string argument
     * 
     * @return bool True if error response
     */
    public function isError(): bool
    {
        return $this->path === '/*';
    }

    /**
     * Get error message if this is an error response
     * 
     * @return string|null Error message or null if not an error
     */
    public function getErrorMessage(): ?string
    {
        if (!$this->isError()) {
            return null;
        }

        // Error message is typically the first string argument
        foreach ($this->args as $arg) {
            if (is_string($arg)) {
                return $arg;
            }
        }

        return 'Unknown error';
    }

    /**
     * Get first argument as string
     * 
     * @return string|null First string argument or null
     */
    public function getFirstString(): ?string
    {
        foreach ($this->args as $arg) {
            if (is_string($arg)) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * Get all string arguments
     * 
     * @return array Array of string arguments
     */
    public function getStrings(): array
    {
        $strings = [];
        foreach ($this->args as $arg) {
            if (is_string($arg)) {
                $strings[] = $arg;
            }
        }
        return $strings;
    }

    /**
     * Convert to array representation
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'types' => $this->types,
            'args' => $this->args,
            'is_error' => $this->isError(),
            'error_message' => $this->getErrorMessage(),
        ];
    }
}

