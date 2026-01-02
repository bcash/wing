Below is a **clear, structured extraction & documentation plan** your team can follow to convert **all provided Behringer WING PDFs** into a **series of Markdown (.md) files**, suitable for direct inclusion in a code repository and incremental export.

This is a **planning + information architecture spec**, not the content itself yet.

---

# Behringer WING Documentation → Markdown Export Plan

## 1. Source Documents (Authoritative Inputs)

The following PDFs are in scope and will be fully consumed:

1. **WING Remote Protocols v3.0.5**

   * OSC protocol
   * Message formats
   * Network behavior
   * Constraints

2. **WING / WING Rack / WING Compact Manual**

   * Console architecture
   * Signal flow
   * Channel structure
   * Buses, FX, routing
   * Snapshots & scenes
   * User interface concepts

3. **WING Effects Guide**

   * FX models
   * Parameters
   * Signal placement
   * Model lineage (where stated)

4. **Wing Docs (RTF)**

   * Supplemental notes
   * Clarifications
   * Possibly internal or derived documentation

Each document will be treated as **source-of-truth**, with **no inferred behavior added** unless explicitly labeled.

---

## 2. Guiding Principles for the Markdown Export

### 2.1 Goals

* Developer-readable
* Git-friendly
* Diffable
* Cross-referenceable
* Implementation-oriented

### 2.2 Non-Goals

* No UI screenshots
* No marketing language
* No paraphrased guesswork
* No firmware-specific assumptions unless stated

---

## 3. Output Structure (Markdown File Taxonomy)

All documentation will live under a single root, for example:

```
docs/
├── 00_overview/
├── 01_console_architecture/
├── 02_signal_flow/
├── 03_channels/
├── 04_buses_and_mains/
├── 05_fx_and_processing/
├── 06_snapshots_and_scenes/
├── 07_remote_control/
├── 08_osc_protocol/
├── 09_constraints_and_limits/
└── 10_appendices/
```

Each folder contains **small, atomic `.md` files**.

---

## 4. Phase-Based Export Strategy (Critical)

> We will **not** export everything at once.
> Each `.md` file is self-contained and safe to consume independently.

---

## 5. Planned Markdown Files (Detailed)

### 5.1 `00_overview/`

| File                       | Description                       |
| -------------------------- | --------------------------------- |
| `wing_overview.md`         | What WING is, product family      |
| `wing_models.md`           | WING vs Rack vs Compact           |
| `firmware_and_versions.md` | Firmware concepts & compatibility |

---

### 5.2 `01_console_architecture/`

| File                        | Description                  |
| --------------------------- | ---------------------------- |
| `console_block_diagram.md`  | High-level functional blocks |
| `internal_audio_engine.md`  | DSP concepts                 |
| `latency_and_processing.md` | Zero-latency notes           |

---

### 5.3 `02_signal_flow/`

| File                    | Description                 |
| ----------------------- | --------------------------- |
| `global_signal_flow.md` | End-to-end audio path       |
| `insert_points.md`      | Insert locations            |
| `tap_points.md`         | Where signals can be tapped |
| `routing_matrix.md`     | Routing philosophy          |

---

### 5.4 `03_channels/`

| File                           | Description                |
| ------------------------------ | -------------------------- |
| `channel_types.md`             | Input channel types        |
| `channel_signal_chain.md`      | Preamp → EQ → Comp → Fader |
| `channel_processing_models.md` | EQ, Gate, Comp models      |
| `channel_parameters.md`        | Parameter semantics        |

---

### 5.5 `04_buses_and_mains/`

| File                  | Description        |
| --------------------- | ------------------ |
| `bus_types.md`        | Mix, group, matrix |
| `bus_signal_chain.md` | Processing order   |
| `main_outputs.md`     | LR, Mono, etc      |

---

### 5.6 `05_fx_and_processing/`

| File                     | Description          |
| ------------------------ | -------------------- |
| `fx_overview.md`         | FX rack architecture |
| `fx_models.md`           | List of all FX       |
| `fx_parameters.md`       | Per-model parameters |
| `fx_signal_placement.md` | Insert vs send       |

---

### 5.7 `06_snapshots_and_scenes/`

| File                  | Description       |
| --------------------- | ----------------- |
| `scenes_overview.md`  | Scene concept     |
| `scope_and_recall.md` | Recall scope      |
| `limitations.md`      | Known constraints |

---

### 5.8 `07_remote_control/`

| File                         | Description      |
| ---------------------------- | ---------------- |
| `remote_control_overview.md` | Remote paradigms |
| `supported_protocols.md`     | OSC, MIDI, etc   |
| `network_requirements.md`    | Networking notes |

---

### 5.9 `08_osc_protocol/` **(High Priority)**

| File                      | Description      |
| ------------------------- | ---------------- |
| `osc_overview.md`         | Protocol summary |
| `osc_transport.md`        | UDP behavior     |
| `osc_message_format.md`   | Address, types   |
| `osc_node_types.md`       | Node vs leaf     |
| `osc_bulk_dump.md`        | `*` behavior     |
| `osc_error_handling.md`   | Error semantics  |
| `osc_path_conventions.md` | Naming rules     |
| `osc_rate_limits.md`      | Practical limits |
| `osc_best_practices.md`   | Client guidance  |

---

### 5.10 `09_constraints_and_limits/`

| File                     | Description    |
| ------------------------ | -------------- |
| `udp_limits.md`          | Packet size    |
| `scaling_limits.md`      | Channel counts |
| `known_failure_modes.md` | What breaks    |

---

### 5.11 `10_appendices/`

| File            | Description             |
| --------------- | ----------------------- |
| `glossary.md`   | Terms                   |
| `examples.md`   | OSC examples            |
| `references.md` | Source document mapping |

---

## 6. Markdown Style Rules (Strict)

* Use `#`–`###` only
* No inline HTML
* Tables preferred over prose
* Code blocks for:

  * OSC messages
  * Signal chains
* One concept per file
* Stable headings (no renaming later)

---

## 7. Traceability Requirement

Each `.md` file must include:

```md
---
source:
  - WING Remote Protocols v3.0.5
  - Page X–Y
---
```

This allows:

* Auditing
* Verification
* Future updates

---

## 8. Export Order (Recommended)

1. OSC protocol files
2. Constraints & limits
3. Channel architecture
4. FX models
5. Scenes & recall
6. Remaining system docs

This aligns with your **OSC dump tooling and JSON restore work**.

---

## 9. Next Step (What I’ll Do Next)

If you confirm, I will:

1. Start with **`08_osc_protocol/osc_overview.md`**
2. Export **one `.md` file per message**
3. Maintain consistent anchors for code references
4. Pause after each file for confirmation or edits

👉 **Reply with**:

* “Start with OSC”
* or “Start with Architecture”
* or “Start with FX”
* or “Proceed in recommended order”

Once confirmed, we’ll move file-by-file.
