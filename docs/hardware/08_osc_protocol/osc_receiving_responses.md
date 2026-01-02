# Receiving OSC Responses from Behringer WING

---
source:
  - WING Remote Protocols v3.0.5
  - Empirical behavior (WING / WING Rack firmware 3.x)
---

## 1. Purpose

This document explains **how OSC responses are delivered by the Behringer WING console** and how a client **must be implemented** in order to reliably receive them.

This is the most common failure point when integrating with WING OSC.

---

## 2. Core Rule (Read This First)

> **WING always replies to the source IP address and source UDP port of the incoming OSC packet.**

There is:
- No fixed reply port
- No server-to-client connection
- No subscription channel

If your client does not remain listening on the **same UDP socket** it used to send the request, **you will not receive responses**.

---

## 3. OSC Is Not Client/Server

Although OSC may appear client/server-like, WING OSC behaves as:

- Stateless
- Connectionless
- Datagram-based

Each OSC message is independent.

---

## 4. Required Client Socket Lifecycle

A compliant OSC client **must**:

1. Create a UDP socket
2. Bind the socket to a local port
3. Send OSC packets from that socket
4. Keep the socket open
5. Receive replies on that same socket

### 4.1 Correct Lifecycle

```

socket_create()
socket_bind()
socket_sendto()
socket_recvfrom()
socket_close()

```

### 4.2 Incorrect Lifecycle (Common Failure)

```

socket_sendto()   ❌ no bind
socket_close()    ❌ closes before reply

```

or

```

send socket A
receive socket B ❌ replies go to socket A

````

---

## 5. Why Binding Is Mandatory

If a socket is not explicitly bound:

- The OS may assign an ephemeral port
- The port may not remain open
- Replies may be sent to a port your client is not listening on

Explicit binding guarantees:
- Predictable reply behavior
- Reliable reception

---

## 6. Minimum Working Example (PHP)

```php
$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

// REQUIRED: bind to local port
socket_bind($sock, '0.0.0.0', 9000);

// Build minimal OSC message "/?"
$addr = "/?\0";
$addr .= str_repeat("\0", (4 - (strlen($addr) % 4)) % 4);
$types = ",\0\0\0";
$packet = $addr . $types;

// Send to WING
socket_sendto($sock, $packet, strlen($packet), 0, '192.168.8.200', 2223);

// Set receive timeout
socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, [
    'sec' => 1,
    'usec' => 0
]);

// Receive reply
$buf = '';
$from = '';
$port = 0;

if (socket_recvfrom($sock, $buf, 2048, 0, $from, $port)) {
    // OSC reply received
} else {
    // No reply (timeout)
}
````

---

## 7. Timing Considerations

* WING replies quickly (typically <10 ms)
* Clients must:

  * Remain listening after sending
  * Avoid immediate socket closure
* Timeouts should be:

  * At least 500 ms
  * Preferably 1000 ms

---

## 8. Packet Size & Response Loss

Responses exceeding ~32 KB may:

* Be dropped silently
* Return an error
* Never arrive

Clients must treat **no response** as a valid outcome.

---

## 9. Error Responses

Errors are returned as:

```
/*
```

With a string argument describing the error.

Clients must:

* Parse wildcard addresses
* Not assume silence means success

---

## 10. macOS-Specific Notes

### 10.1 Firewall Behavior

macOS firewall may:

* Allow outgoing UDP
* Block incoming replies

Ensure PHP is allowed to receive UDP traffic.

### 10.2 IPv4 vs IPv6

Always create sockets using:

```php
AF_INET
```

Avoid IPv6 unless explicitly required.

---

## 11. Debug Checklist

If no response is received:

1. Confirm console IP is reachable (ping)
2. Confirm UDP port 2223 is reachable
3. Confirm socket is bound
4. Confirm receive happens on same socket
5. Confirm OSC packet is valid
6. Confirm firewall is not blocking replies

---

## 12. Key Takeaways

* OSC replies are **always unicast**
* Binding is mandatory
* Socket reuse is mandatory
* Silence does not imply failure
* Receiving responses is the client’s responsibility

---

## 13. Related Documentation

* `osc_overview.md`
* `osc_transport.md`
* `osc_message_format.md`
* `osc_error_handling.md`
* `udp_limits.md`

