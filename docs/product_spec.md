Below is a **complete, implementation-ready technical specification** you can hand directly to your PHP developer.

It is written as a **systems spec**, not a tutorial, and assumes professional familiarity with PHP, Composer, OSC, UDP, and long-running CLI processes.

---

# Behringer WING – Full OSC Tree Dump System

**Technical Specification (PHP)**

## 1. Purpose & Scope

This system shall **export the entire Behringer WING OSC tree** into a structured, replayable, and diff-friendly JSON dataset.

The output will serve as:

* A **complete inventory of console configuration**
* A **foundation for restore / replay tools**
* A **basis for diffing, auditing, and documentation**
* A long-term alternative to `.scn` files

The system **must safely handle**:

* UDP packet limits
* Node overflow
* Partial failures
* Resume/restart
* Firmware changes

---

## 2. Constraints & Realities (Non-Negotiable)

### 2.1 OSC Transport

* Protocol: **OSC over UDP**
* Port: **2223**
* Transport is **connectionless**
* Max practical payload: **~32 KB**
* Some nodes *cannot* be returned in one packet

### 2.2 WING OSC Behavior

* Querying a path (`/ch/01`) returns either:

  * A **node listing** (strings)
  * A **leaf value** (typed args)
* Bulk dump is supported via:

  ```
  /path ,s *
  ```
* Errors are returned as:

  ```
  /* ,s "error message"
  ```

### 2.3 Full Tree Cannot Be Safely Stored in One File

* Output **must be sharded**
* Files must be:

  * Independently readable
  * Deterministic
  * Idempotent

---

## 3. High-Level Architecture

### 3.1 Phases

| Phase | Name           | Description                              |
| ----- | -------------- | ---------------------------------------- |
| 1     | Discovery      | Enumerate full OSC tree structure        |
| 2     | Classification | Group paths into logical domains         |
| 3     | Extraction     | Dump values using safest method per node |
| 4     | Persistence    | Write JSON shards incrementally          |
| 5     | Verification   | Track failures, retries, completeness    |

---

## 4. Output Layout (Filesystem Contract)

```
wing_dump/
├── meta.json
├── index.json
├── coverage.json
├── errors.json
├── domains/
│   ├── ch/
│   │   ├── ch_01.json
│   │   ├── ch_02.json
│   │   └── ...
│   ├── bus/
│   ├── aux/
│   ├── fx/
│   ├── dca/
│   ├── main/
│   ├── cfg/
│   ├── $ctl/
│   └── misc/
└── raw/
    ├── root.json
    └── unclassified.json
```

### 4.1 File Rules

* **One logical object per file**
* Files must be **≤ 32 KB**
* JSON must be:

  * UTF-8
  * Pretty-printed
  * Stable key ordering

---

## 5. `meta.json` (Global Metadata)

```json
{
  "console": "Behringer WING",
  "firmware": "x.y.z",
  "ip": "192.168.8.200",
  "osc_port": 2223,
  "generated_at": "ISO-8601",
  "tool_version": "1.0.0"
}
```

---

## 6. `index.json` (Tree Discovery Output)

This file represents **structure only**, no values.

```json
{
  "/": {
    "ch": {
      "01": {},
      "02": {}
    },
    "bus": {
      "01": {}
    },
    "cfg": {}
  }
}
```

Rules:

* Keys are **OSC path segments**
* Values are either:

  * `{}` (leaf or undiscovered)
  * Nested object (node)

---

## 7. Domain Classification Rules

During extraction, paths shall be classified by prefix:

| Prefix  | Domain   |
| ------- | -------- |
| `/ch`   | channels |
| `/bus`  | buses    |
| `/aux`  | aux      |
| `/fx`   | fx       |
| `/dca`  | dca      |
| `/main` | main     |
| `/cfg`  | config   |
| `/$ctl` | control  |
| unknown | misc     |

---

## 8. Domain Dump File Format

Example: `domains/ch/ch_01.json`

```json
{
  "path": "/ch/01",
  "method": "bulk",
  "data": {
    "preamp.gain": -12.0,
    "eq.band1.freq": 250,
    "comp.threshold": -18
  },
  "raw": {
    "preamp.gain": {
      "types": "sff",
      "args": ["-12.0 dB", -12.0, -12.0]
    }
  }
}
```

### 8.1 `method`

* `"bulk"` → retrieved via `,s *`
* `"leaf"` → individual OSC queries
* `"partial"` → fallback mode used

---

## 9. Extraction Logic (Critical)

### 9.1 Preferred Method

```text
/path ,s *
```

If:

* response received
* response < UDP limit
* no `/*` error

→ parse key/value pairs

### 9.2 Fallback

If bulk fails:

* enumerate children
* request each leaf individually

### 9.3 Value Normalization

* Preserve **raw OSC args**
* Expose a single normalized `value`

  * last numeric arg preferred
  * strings preserved if no numeric exists

---

## 10. Error Handling (`errors.json`)

```json
[
  {
    "path": "/cfg/network",
    "error": "timeout",
    "attempts": 3
  }
]
```

Rules:

* Errors must **not abort the run**
* Retried up to configurable limit
* All failures recorded

---

## 11. Coverage Report (`coverage.json`)

```json
{
  "discovered_paths": 1432,
  "dumped_objects": 1389,
  "failed": 43,
  "coverage_percent": 96.99
}
```

---

## 12. CLI Requirements

### Command

```bash
php wing-dump dump \
  --ip=192.168.8.200 \
  --out=wing_dump \
  --rate=15 \
  --resume
```

### Options

| Option      | Description            |
| ----------- | ---------------------- |
| `--ip`      | Console IP             |
| `--out`     | Output directory       |
| `--rate`    | Requests per second    |
| `--resume`  | Skip completed files   |
| `--domains` | Optional domain filter |

---

## 13. Composer & Libraries

Approved:

* `clue/osc`
* `react/datagram`
* `symfony/console`

Disallowed:

* GUI dependencies
* Blocking infinite loops without timeout
* Anything requiring root privileges

---

## 14. Performance & Safety Rules

* Must throttle requests
* Must flush JSON files immediately
* Must survive SIGINT
* Must resume safely
* No in-memory full-tree storage

---

## 15. Future Compatibility (Explicit)

This design **must support**:

* JSON → OSC restore tool
* Diff between two dumps
* Firmware drift detection
* Selective subtree restore

---

## 16. Explicit Non-Goals

* No `.scn` parsing
* No UI
* No assumptions about channel counts
* No reliance on undocumented OSC behavior

---

## 17. Acceptance Criteria

The system is complete when:

* ✔ All reachable OSC paths are represented
* ✔ No UDP overflows crash the process
* ✔ Output is deterministic
* ✔ Partial failures do not abort execution
* ✔ A second run with `--resume` skips completed nodes

---

## 18. Developer Notes (Important)

This is **not a crawler** — it is an **inventory system**.

Correctness > speed
Completeness > elegance
Determinism > convenience

---

If you want, next I can:

* Write a **matching restore spec**
* Produce a **JSON diff schema**
* Define a **`.scn` regeneration pipeline**
* Or review your developer’s implementation against this spec

Just tell me.
