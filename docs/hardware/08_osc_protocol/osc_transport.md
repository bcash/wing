# OSC Transport – Behringer WING

---
source:
  - WING Remote Protocols v3.0.5
---

## 1. Purpose

This document defines the **transport-layer behavior** of the OSC implementation on the Behringer WING console.

It focuses on:
- Network transport
- Port usage
- Reply mechanics
- Delivery characteristics
- Practical constraints imposed by UDP

---

## 2. Transport Protocol

### 2.1 Protocol Selection

The Behringer WING uses:

- **UDP (User Datagram Protocol)**
- No TCP support
- No fallback transport

All OSC communication occurs exclusively over UDP.

---

### 2.2 Default Port

| Setting | Value |
|------|------|
| OSC Port | **2223** |
| Protocol | UDP |
| Direction | Bidirectional |

The console listens continuously on UDP port **2223**.

---

## 3. Client Addressing & Replies

### 3.1 Reply Targeting

The WING console replies to:
- The **source IP address**
- The **source UDP port**

of the incoming OSC message.

There is:
- No session establishment
- No registration handshake
- No fixed reply port

---

### 3.2 Implications for Clients

Clients must:
- Bind to a local UDP port
- Remain listening on that port
- Handle replies asynchronously

Failure to keep the socket open will result in lost responses.

---

## 4. Stateless Communication Model

OSC on WING is **stateless**:

- Each message is independent
- No connection state is maintained
- No message correlation identifiers are used

Clients must infer state based on:
- Message address
- Timing
- Returned values

---

## 5. Packet Delivery Characteristics

### 5.1 UDP Guarantees (or Lack Thereof)

UDP provides **no guarantees** regarding:

- Delivery
- Ordering
- Duplication
- Latency

As a result:
- Messages may be lost
- Responses may arrive out of order
- Duplicate responses may occur

---

### 5.2 Client Responsibilities

Clients must implement:
- Timeouts
- Retries
- Idempotent write behavior
- Defensive parsing

---

## 6. Packet Size Constraints

### 6.1 Maximum Payload Size

The maximum practical UDP payload size for WING OSC replies is:

- Approximately **32 KB**

This limit includes:
- OSC address
- Type tags
- Arguments
- Padding

---

### 6.2 Oversized Responses

If a response exceeds the UDP size limit:

- The console may:
  - Drop the packet silently
  - Return an error response
- The client may receive:
  - No response
  - An error message

There is **no fragmentation or streaming** mechanism.

---

## 7. Consequences for Bulk Operations

Bulk operations (e.g. `,s *`) must be used carefully.

Large nodes (such as:
- Full channel banks
- FX racks
- Configuration trees)

may exceed the size limit and fail.

Clients must:
- Detect failure
- Subdivide requests
- Retry smaller subtrees

---

## 8. Rate Limiting Considerations

### 8.1 No Explicit Rate Limit

The WING console does not advertise a formal OSC rate limit.

However, practical experience indicates:

- **10–20 requests per second** is safe
- Sustained higher rates may cause:
  - Packet loss
  - Missed replies
  - Temporary unresponsiveness

---

### 8.2 Recommended Client Behavior

Clients should:
- Throttle requests
- Avoid burst traffic
- Insert small delays between queries
- Prioritize reads over writes during polling

---

## 9. Timeout Behavior

There is no explicit timeout message.

If:
- No response is received
- Within a client-defined timeout window

The client must assume:
- Packet loss
- Oversized response
- Invalid path
- Temporary overload

---

## 10. Broadcast & Multicast

- WING OSC does **not** support:
  - Broadcast queries
  - Multicast subscriptions
- All communication is **unicast**

Each client must explicitly address the console.

---

## 11. Security Considerations

Transport-level security features **do not exist**:

- No authentication
- No encryption
- No access control
- No client allow-listing

OSC traffic should be isolated to trusted networks.

---

## 12. Firmware Impact on Transport

Transport behavior is generally stable across firmware versions.

However:
- Tree size growth may increase packet size risks
- New nodes may introduce larger bulk dumps

Clients must remain conservative in transport usage.

---

## 13. Best Practices Summary

- Always bind a local UDP socket
- Expect packet loss
- Implement retries with backoff
- Avoid large bulk dumps
- Persist results incrementally
- Never assume a response will arrive

---

## 14. Related Documents

- `osc_overview.md`
- `osc_message_format.md`
- `osc_bulk_dump.md`
- `udp_limits.md`

---

_End of document_
