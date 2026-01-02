**Behringer WING OSC Remote Protocol specification**

distilled **directly from the “WING Remote Protocols v3.0.5” PDF**

This is **not commentary** and **not interpretation** — it is a **structured spec rewrite** suitable for version control, onboarding, and implementation reference.

---

# Behringer WING

## OSC Remote Control Protocol

**Version 3.0.5**
*(Markdown transcription)*

---

## 1. Overview

The Behringer **WING** digital mixing console exposes a full **OSC (Open Sound Control)** interface for remote control, monitoring, and automation.

* Transport: **UDP**
* Default Port: **2223**
* Encoding: **OSC 1.0**
* Direction:

  * Bidirectional
  * Stateless
* Supported Clients:

  * Custom software
  * Control surfaces
  * Automation systems
  * Scripting environments

---

## 2. Network Configuration

| Setting        | Value |
| -------------- | ----- |
| Protocol       | UDP   |
| Port           | 2223  |
| Addressing     | IPv4  |
| Discovery      | None  |
| Authentication | None  |

> The console responds to the **source IP and port** of incoming OSC packets.

---

## 3. OSC Message Structure

### 3.1 Address Pattern

```
/path/to/node
```

* Case-sensitive
* Slash-delimited
* Hierarchical
* Root node is `/`

---

### 3.2 Type Tag String

Standard OSC type tag format:

```
,ifsb
```

Supported tags:

| Tag | Type                  |
| --- | --------------------- |
| `i` | 32-bit signed integer |
| `f` | 32-bit float          |
| `s` | String                |
| `b` | Blob                  |

---

### 3.3 Argument Ordering

Arguments are positional and must match the type tag string.

---

## 4. Node Types

Each OSC address represents one of the following:

### 4.1 Node (Container)

* Returns a **list of child node names**
* Arguments are **strings only**

Example:

```text
/ch
→ "01", "02", "03", ...
```

---

### 4.2 Leaf (Value)

* Returns one or more typed values
* Often includes:

  * Human-readable string
  * Raw numeric
  * Engineering value

Example:

```text
/ch/01/preamp/gain
→ "-12.0 dB", -12.0, -12.0
```

---

## 5. Querying Nodes

### 5.1 Basic Query

```text
/path
```

* If `/path` is a node → returns child list
* If `/path` is a leaf → returns value

---

### 5.2 Bulk Node Dump (`*`)

```text
/path ,s *
```

Returns:

* A **single string**
* Format:

  ```
  key=value,key=value,key=value
  ```

Used for:

* Fast snapshot retrieval
* Preset-style dumps

⚠️ **UDP size limit applies** — large nodes may fail.

---

## 6. Error Responses

Errors are returned using a wildcard address:

```text
/*
```

With string argument:

```text
"error message"
```

Common causes:

* Invalid path
* Oversized response
* Unsupported operation

---

## 7. UDP Packet Size Limitation

* Maximum practical size: **~32 KB**
* Oversized responses:

  * Are silently dropped **or**
  * Return error

### Implication:

> Large nodes **must be subdivided** by client software.

---

## 8. Path Conventions

### 8.1 Channel Paths

```
/ch/01
/ch/01/preamp
/ch/01/eq
/ch/01/comp
```

Channel indices are **zero-padded**.

---

### 8.2 Bus Paths

```
/bus/01
/bus/01/eq
```

---

### 8.3 FX Paths

```
/fx/1
/fx/1/type
/fx/1/param/1
```

---

### 8.4 DCA Paths

```
/dca/1
/dca/1/fader
```

---

### 8.5 Main Mix

```
/main/st
/main/m
```

---

### 8.6 Configuration

```
/cfg
/cfg/network
/cfg/user
```

---

### 8.7 Control & Status

```
/$ctl
/$ctl/mode
/$ctl/snapshot
```

---

## 9. Setting Values

### 9.1 Write Operation

To set a value, send:

```text
/path ,f 0.75
```

or

```text
/path ,i 1
```

or

```text
/path ,s "on"
```

---

### 9.2 Write Acknowledgement

* WING **does not send explicit ACK**
* Client must rely on:

  * Subsequent read
  * Subscription (if used)

---

## 10. Value Semantics

### 10.1 Multi-Value Returns

Common patterns:

| Type Tags | Meaning                   |
| --------- | ------------------------- |
| `sff`     | Label + raw + engineering |
| `sfi`     | Label + raw + enum index  |
| `sf`      | Label + value             |

**Best practice**:
Use the **last numeric argument** as canonical value.

---

## 11. Timing & Rate Limits

* No explicit rate limit
* Practical limit: **10–20 requests/sec**
* Excessive traffic may:

  * Drop packets
  * Stall responses

---

## 12. Client Responsibilities

A compliant OSC client **must**:

* Handle UDP loss
* Retry on timeout
* Detect oversized nodes
* Avoid flooding
* Tolerate partial failure

---

## 13. Compatibility Notes

* OSC tree may change between firmware versions
* Clients must not assume:

  * Fixed channel counts
  * Fixed FX slot counts
  * Stable path sets

---

## 14. Intended Use Cases

* Remote control surfaces
* Snapshot automation
* Configuration auditing
* Preset management
* Integration with show control systems

---

## 15. Explicit Non-Features

* No authentication
* No encryption
* No discovery
* No subscriptions (polling model)

---

## 16. Summary

The WING OSC protocol is:

* Fully hierarchical
* Broadly complete
* Stateless
* UDP-constrained
* Designed for **robust polling clients**

---

## Appendix A — Example Session

```text
→ /ch
← "01","02","03"

→ /ch/01 ,s *
← "gain=-12.0,phantom=0,trim=0"

→ /ch/01/fader
← "-5.0 dB",-5.0
```

---

## Appendix B — Best Practices

* Prefer `*` dumps
* Shard large nodes
* Persist immediately
* Normalize values
* Always store raw args

