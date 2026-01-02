# OSC Overview – Behringer WING

---
source:
  - WING Remote Protocols v3.0.5
---

## 1. Purpose

This document provides a high-level overview of the **Open Sound Control (OSC)** implementation used by the **Behringer WING** digital mixing console.

It is intended for:
- Software developers
- Control system integrators
- Automation and tooling authors
- Offline configuration and auditing systems

This file describes **what OSC is used for on WING**, not the full message syntax or path catalog (covered in subsequent documents).

---

## 2. What OSC Is on WING

OSC (Open Sound Control) on WING is a **stateless, hierarchical, UDP-based remote control protocol** that exposes nearly all internal console parameters.

Key characteristics:

| Property | Description |
|-------|------------|
| Protocol | OSC 1.0 |
| Transport | UDP |
| Direction | Bidirectional |
| State | Stateless |
| Authentication | None |
| Discovery | None |

The OSC interface allows **reading and writing** of console state in real time.

---

## 3. Scope of Control

The OSC tree provides access to:

- Input channels
- Buses and matrices
- Main outputs
- FX racks and parameters
- Routing configuration
- Snapshots and scenes
- Console configuration and control state

Nearly all parameters visible on the console UI are represented somewhere in the OSC tree.

---

## 4. Architectural Model

### 4.1 Hierarchical Tree

OSC addresses on WING form a **strict hierarchy**, similar to a filesystem:

```

/
├── ch
│   ├── 01
│   │   ├── preamp
│   │   ├── eq
│   │   └── comp
├── bus
├── fx
├── main
└── cfg

```

Each address resolves to either:
- A **node** (container of child paths)
- A **leaf** (a readable/writable value)

---

### 4.2 Node vs Leaf Semantics

| Type | Behavior |
|----|--------|
| Node | Returns a list of child node names |
| Leaf | Returns one or more typed values |

Clients must dynamically detect which type a path represents.

---

## 5. Transport Characteristics

### 5.1 UDP Transport

- OSC messages are sent via **UDP**
- Default port: **2223**
- The console replies to the **source IP and port** of the sender

Implications:
- No delivery guarantees
- No ordering guarantees
- Clients must tolerate packet loss

---

### 5.2 Packet Size Constraints

- Practical maximum UDP payload: **~32 KB**
- Oversized OSC replies may:
  - Fail silently
  - Return an error response

Clients must design around this limitation.

---

## 6. Polling Model

WING OSC uses a **polling-based model**:

- No subscriptions
- No event push
- No change notifications

Clients are responsible for:
- Issuing read requests
- Managing polling frequency
- Tracking state changes

---

## 7. Read and Write Semantics

### 7.1 Reading Values

To read:
- Send an OSC message with only the address
- The console responds with the current value or child list

### 7.2 Writing Values

To write:
- Send an OSC message with:
  - Address
  - Type tag
  - One or more arguments

There is **no explicit write acknowledgment**.

---

## 8. Bulk Read Capability

WING supports **bulk node dumps** using a wildcard argument:

```

/path ,s *

```

This returns multiple key/value pairs in a single response.

Use cases:
- Snapshots
- Configuration exports
- Offline analysis

Limitations:
- Subject to UDP size limits
- Not supported on all nodes

---

## 9. Error Handling Model

Errors are returned as OSC messages with a wildcard address:

```

/*

```

The error message is provided as a string argument.

Clients must:
- Detect error responses
- Log and recover gracefully
- Continue operation where possible

---

## 10. Firmware Variability

The OSC tree is **not guaranteed to be stable** across firmware versions.

Clients must:
- Discover paths dynamically
- Avoid hardcoding full tree assumptions
- Be resilient to missing or new nodes

---

## 11. Intended Usage Patterns

OSC on WING is designed for:

- Remote control surfaces
- Show automation
- Snapshot management
- External monitoring tools
- Configuration export/import systems

It is **not** designed for:
- High-frequency audio-rate control
- Guaranteed real-time synchronization
- Secure or authenticated environments

---

## 12. Relationship to Other Documentation

This document is intentionally high-level.

Detailed coverage is provided in:
- `osc_transport.md`
- `osc_message_format.md`
- `osc_node_types.md`
- `osc_bulk_dump.md`
- `osc_error_handling.md`
- `osc_best_practices.md`

---

## 13. Summary

The Behringer WING OSC interface provides:

- Broad access to console state
- A consistent hierarchical model
- Powerful bulk-read capabilities
- A flexible but UDP-constrained transport

Effective use requires:
- Careful rate limiting
- Robust error handling
- Dynamic discovery
- Incremental persistence

---
