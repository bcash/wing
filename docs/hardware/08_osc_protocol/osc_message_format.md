# OSC Message Format – Behringer WING

---
source:
  - WING Remote Protocols v3.0.5
---

## 1. Purpose

This document defines the **OSC message format** used by the Behringer WING console.

It covers:
- OSC address patterns
- Type tag strings
- Argument encoding
- Data types supported by WING

This document does **not** describe specific OSC paths or parameter meanings.

---

## 2. OSC Message Structure

An OSC message consists of:

1. Address pattern (string)
2. Type tag string (string, prefixed with `,`)
3. Zero or more arguments

All elements are:
- Null-terminated
- 4-byte aligned
- Big-endian encoded

---

## 3. Address Patterns

### 3.1 General Form

