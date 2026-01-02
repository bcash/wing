Below is a **complete, implementation-ready technical specification** you can hand directly to your PHP developer.

It is written as a **systems spec**, not a tutorial, and assumes professional familiarity with PHP, Composer, OSC, UDP, and long-running CLI processes.

---

# Behringer WING – Complete CLI Management System

**Technical Specification (PHP)**

## 1. Purpose & Scope

This system is a **comprehensive CLI package** for managing Behringer WING digital mixing consoles via OSC. It provides complete console control, configuration management, and automation capabilities.

### 1.1 Core Capabilities

The system provides:

* **Complete OSC tree export/import** - Full console state management
* **Snippet management** - Save, restore, and organize console snapshots
* **Custom Control management** - Configure CC buttons and knobs with advanced behaviors
* **Multi-device OSC control** - Simultaneous communication with up to 8 OSC devices
* **Menu system** - Nested menu organization for unlimited command access
* **AI-powered management** - Intelligent automation and optimization
* **Auto-discovery** - Automatic console detection on local network
* **MIDI integration** - Full MIDI support for external control

### 1.2 Competitive Positioning

This system competes with and extends beyond tools like `wcc` by providing:

* **Filesystem-based storage** - No databases, fully version-controllable
* **AI management** - Intelligent automation and optimization
* **Complete state management** - Full export/import, not just snippets
* **Open source** - Fully open and extensible
* **Cross-platform** - Windows, macOS, Linux, Raspberry Pi

The system **must safely handle**:

* UDP packet limits
* Node overflow
* Partial failures
* Resume/restart
* Firmware changes
* Multiple concurrent OSC connections

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

### 3.1 System Components

| Component | Description |
| --------- | ----------- |
| **OSC Client Library** | Two-way OSC communication (send/receive) |
| **Discovery Engine** | OSC tree enumeration and structure mapping |
| **Snippet Manager** | Save/restore console state snapshots |
| **CC Manager** | Custom Control button/knob configuration |
| **Multi-Device Router** | Simultaneous OSC communication (up to 8 devices) |
| **Menu System** | Nested menu organization for commands |
| **AI Engine** | Intelligent automation and optimization |
| **Auto-Discovery** | Network scanning and console detection |
| **MIDI Bridge** | MIDI input/output handling |
| **Version Control** | Git-based versioning, branching, diff, blame, history |

### 3.2 Dump/Export Phases

| Phase | Name           | Description                              |
| ----- | -------------- | ---------------------------------------- |
| 1     | Discovery      | Enumerate full OSC tree structure        |
| 2     | Classification | Group paths into logical domains         |
| 3     | Extraction     | Dump values using safest method per node |
| 4     | Persistence    | Write JSON shards incrementally          |
| 5     | Verification   | Track failures, retries, completeness    |

---

## 4. Filesystem Layout (Complete Structure)

```
wing/
├── .git/                     # Git repository (auto-initialized)
├── .gitignore               # Git exclusions
├── .wing/                   # WING-specific metadata
│   ├── config.json         # VCS configuration
│   ├── authors.json        # Author mapping
│   └── annotations/        # Path annotations
│
├── dumps/                    # Console state exports (version-controlled)
│   └── wing_dump/
│       ├── meta.json
│       ├── index.json
│       ├── coverage.json
│       ├── errors.json
│       ├── domains/
│       └── raw/
│
├── snippets/                # Saved snippets (version-controlled)
│   ├── vocal_mix.json
│   ├── drum_bus.json
│   ├── live_preset_01.json
│   └── ...
│
├── cc/                       # Custom Control configurations (version-controlled)
│   ├── buttons/
│   │   ├── button_01.json
│   │   ├── button_02.json
│   │   └── ...
│   ├── knobs/
│   │   ├── knob_01.json
│   │   └── ...
│   └── menus/
│       ├── main_menu.json
│       ├── fx_menu.json
│       └── ...
│
├── devices/                  # Multi-device OSC configurations (version-controlled)
│   ├── device_01.json       # WING #2
│   ├── device_02.json       # X32
│   ├── device_03.json       # OBS
│   └── ...
│
├── definitions/              # Text-editable definition files (version-controlled)
│   ├── button_definitions.json
│   ├── knob_definitions.json
│   ├── menu_definitions.json
│   └── osc_routes.json
│
├── patches/                  # Fast patch files (version-controlled)
│   ├── vocal_adjustments.patch
│   ├── live_changes.patch
│   └── ...
│
└── ai/                       # AI management data (version-controlled)
    ├── profiles/
    ├── optimizations/
    └── learning/
```
<｜tool▁calls▁begin｜><｜tool▁call▁begin｜>
read_file

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

## 11.5 Version Control (Git Integration)

### 11.5.1 Overview

All WING configuration data is stored as JSON files in the filesystem, making it ideal for **Git-based version control**. The system automatically initializes and manages a Git repository to provide:

* **Branching** - Create configuration variants (live, studio, backup)
* **Merging** - Combine changes from different sources
* **Diff** - See what changed between versions
* **Blame** - Track who changed what and when
* **History** - Complete audit trail
* **Comments** - Commit messages and path annotations
* **Tags** - Mark important snapshots (releases, shows, etc.)

### 11.5.2 Git Repository Structure

The Git repository is initialized automatically in the `wing/` directory:

```
wing/
├── .git/                     # Git repository (auto-initialized)
├── .gitignore               # Git exclusions
├── .wing/                   # WING-specific metadata
│   ├── config.json         # VCS configuration
│   ├── authors.json        # Author mapping
│   └── annotations/         # Path annotations
```

### 11.5.3 Auto-Commit Behavior

**Operations that auto-commit:**
* `wing:dump` → Auto-commit dump
* `wing:snippet:save` → Auto-commit snippet
* `wing:cc:*` → Auto-commit CC changes
* `wing:device:*` → Auto-commit device changes

**Commit Message Format:**
```
[WING] <type>: <description>

<optional body>

Affected:
- snippets/vocal_mix.json
- cc/buttons/button_01.json

Tags: live, vocals
```

**Disable auto-commit:**
```bash
php artisan wing:snippet:save vocal_mix --no-commit
```

### 11.5.4 Branching Model

**Default Branches:**
* `main` - Production/stable configuration
* `live` - Live performance setup
* `studio` - Studio recording setup
* `backup` - Backup snapshots

**Branch Operations:**
```bash
# Create branch for show
php artisan wing:git:branch:create show_2024_01_15

# Switch branch
php artisan wing:git:branch:switch live

# List branches
php artisan wing:git:branch:list

# Merge branches
php artisan wing:git:branch:merge studio into main
```

### 11.5.5 Diff & Comparison

**Diff Output Format:**
```json
{
  "summary": {
    "files_changed": 5,
    "insertions": 23,
    "deletions": 8
  },
  "changes": [
    {
      "file": "snippets/vocal_mix.json",
      "type": "modified",
      "changes": [
        {
          "path": "/ch/01/preamp/gain",
          "old": -12.0,
          "new": -10.0,
          "delta": 2.0
        }
      ]
    }
  ]
}
```

### 11.5.6 Blame & History

**Blame Output:**
```json
{
  "file": "snippets/vocal_mix.json",
  "paths": [
    {
      "path": "/ch/01/preamp/gain",
      "value": -10.0,
      "commit": "abc123",
      "author": "user@example.com",
      "date": "2024-01-15T10:30:00Z",
      "message": "Increased vocal gain for live mix"
    }
  ]
}
```

### 11.5.7 Annotations

**Annotation Storage:**
```json
{
  "file": "snippets/vocal_mix.json",
  "path": "/ch/01/preamp/gain",
  "comment": "Adjusted for live venue acoustics",
  "author": "user@example.com",
  "date": "2024-01-15T10:30:00Z",
  "commit": "abc123"
}
```

### 11.5.8 Tags & Snapshots

Tags mark important versions for easy restoration:

```bash
# Create tag
php artisan wing:git:tag:create show_2024_01_15 \
  --message="Pre-show configuration"

# Restore from tag
php artisan wing:git:tag:restore show_2024_01_15 --ip=192.168.8.200
```

### 11.5.9 .gitignore Configuration

```gitignore
# Temporary files
*.tmp
*.log
*.cache

# OS files
.DS_Store
Thumbs.db

# IDE files
.idea/
.vscode/

# Large dumps (optional - user configurable)
# dumps/*/

# AI learning data (optional)
# ai/learning/*.bin
```

### 11.5.10 Fast Patch System

**Patch Format:**
```json
{
  "version": "1.0",
  "created_at": "2024-01-15T10:30:00Z",
  "from": "abc123",
  "to": "def456",
  "description": "Vocal mix adjustments for live venue",
  "changes": [
    {
      "file": "snippets/vocal_mix.json",
      "path": "/ch/01/preamp/gain",
      "operation": "update",
      "old_value": -12.0,
      "new_value": -10.0,
      "osc_path": "/ch/01/preamp/gain",
      "osc_types": "f",
      "osc_args": [-10.0]
    }
  ],
  "metadata": {
    "affected_domains": ["ch"],
    "affected_files": ["snippets/vocal_mix.json"],
    "total_changes": 1
  }
}
```

**Performance Characteristics:**
* **Very Fast** - Only sends OSC messages for changed paths (no full dump/restore)
* **Selective** - Filter by domain, path, file, or custom patterns
* **Efficient** - Batches OSC messages, uses bulk operations where possible
* **Safe** - Dry-run preview before applying
* **Reversible** - Can create and apply reverse patches

**Implementation:**
* `App\Services\VersionControl\PatchManager` - Patch creation and application
* `App\Services\VersionControl\Patch` - Patch data structure
* Direct OSC sends (no dump/restore cycle)
* Filtering and selective application
* Batch operations for performance

### 11.5.11 Implementation

**Git Wrapper Service:**
* `App\Services\VersionControl\GitManager` - Core Git operations
* `App\Services\VersionControl\CommitMessageGenerator` - Auto-commit messages
* `App\Services\VersionControl\PatchManager` - Fast patch system
* Integration with all save/restore operations

**Technical Details:**
* Uses Git as underlying VCS (not custom implementation)
* Git repository initialized automatically on first operation
* All configuration files are version-controlled
* Supports standard Git workflow (users can use Git directly if desired)
* Conflict detection and resolution for merge operations
* Fast patch system for selective, targeted updates

---

## 12. CLI Commands & Requirements

### 12.1 Core Commands

#### Export/Dump
```bash
php artisan wing:dump \
  --ip=192.168.8.200 \
  --out=wing_dump \
  --rate=15 \
  --resume \
  --domains=ch,bus
```

#### Import/Restore
```bash
php artisan wing:restore \
  --from=wing_dump \
  --ip=192.168.8.200 \
  --dry-run
```

#### Snippet Management
```bash
# Save current state as snippet
php artisan wing:snippet:save vocal_mix --ip=192.168.8.200

# Restore snippet
php artisan wing:snippet:load vocal_mix --ip=192.168.8.200

# List snippets
php artisan wing:snippet:list

# Delete snippet
php artisan wing:snippet:delete vocal_mix
```

#### Custom Control Management
```bash
# Configure CC button
php artisan wing:cc:button:set 1 \
  --on-snippet=vocal_on \
  --off-snippet=vocal_off \
  --mode=toggle \
  --menu=fx_menu

# Configure CC knob
php artisan wing:cc:knob:set 1 \
  --target=/ch/01/preamp/gain \
  --formula="linear:0:1:-60:0" \
  --multi-target=/ch/02/preamp/gain

# Load button definitions from file
php artisan wing:cc:load --file=definitions/buttons.json

# Direct inline loading
php artisan wing:cc:load \
  --button=1 \
  --on-snippet=vocal_on \
  --off-snippet=vocal_off
```

#### Multi-Device OSC
```bash
# Add OSC device
php artisan wing:device:add obs \
  --ip=192.168.8.100 \
  --port=9000 \
  --route=button_01:/obs/scene/switch

# List devices
php artisan wing:device:list

# Remove device
php artisan wing:device:remove obs
```

#### Auto-Discovery
```bash
# Discover WING consoles on local network
php artisan wing:discover

# Auto-connect to first discovered console
php artisan wing:discover --auto-connect
```

#### Version Control (Git-Based)
```bash
# Initialize Git repository
php artisan wing:git:init

# Status
php artisan wing:git:status

# Commit changes (auto-commits after operations by default)
php artisan wing:git:commit --message="Updated vocal mix"

# Branch operations
php artisan wing:git:branch:create show_2024_01_15
php artisan wing:git:branch:switch live
php artisan wing:git:branch:list
php artisan wing:git:branch:merge studio into main

# Diff operations
php artisan wing:git:diff                    # Current vs last commit
php artisan wing:git:diff commit1 commit2    # Between commits
php artisan wing:git:diff --branch=live      # Between branches
php artisan wing:git:diff --file=snippets/vocal_mix.json
php artisan wing:git:diff --domain=ch         # Domain-specific diff

# Blame (who changed what)
php artisan wing:git:blame snippets/vocal_mix.json
php artisan wing:git:blame snippets/vocal_mix.json --path=/ch/01/preamp/gain

# History
php artisan wing:git:history
php artisan wing:git:history --file=snippets/vocal_mix.json
php artisan wing:git:history --author=user --since=2024-01-01

# Tags (snapshots)
php artisan wing:git:tag:create show_2024_01_15 --message="Pre-show config"
php artisan wing:git:tag:list
php artisan wing:git:tag:restore show_2024_01_15 --ip=192.168.8.200

# Annotations (comments on specific paths)
php artisan wing:git:annotate \
  --file=snippets/vocal_mix.json \
  --path=/ch/01/preamp/gain \
  --comment="Adjusted for live venue acoustics"
```

**Auto-Commit Behavior:**
- Operations automatically commit by default (can be disabled with `--no-commit`)
- Commit messages are auto-generated with operation context
- All configuration files are version-controlled
- Git repository initialized automatically on first operation

#### Fast Patch System (Selective Updates)
```bash
# Create patch from diff (very fast - only changes)
php artisan wing:patch:create \
  --from=commit1 \
  --to=commit2 \
  --out=patches/vocal_adjustments.patch

# Create patch from branch diff
php artisan wing:patch:create \
  --from=main \
  --to=live \
  --out=patches/live_changes.patch

# Apply patch to console (very fast - direct OSC, no dump/restore)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200

# Apply with selective filters
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --domain=ch                    # Only channel domain
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --paths=/ch/01/preamp/gain     # Only specific paths
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --files=snippets/vocal_mix.json  # Only specific files
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --exclude-paths=/ch/01/eq/*    # Exclude paths

# Preview before applying (dry-run)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --dry-run

# Reverse patch (undo changes)
php artisan wing:patch:reverse patches/vocal_adjustments.patch \
  --ip=192.168.8.200

# Apply patch to files (not console)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --to-files

# Patch management
php artisan wing:patch:list
php artisan wing:patch:view patches/vocal_adjustments.patch
```

**Patch Performance:**
- **Very Fast** - Only sends OSC messages for changed paths (no full dump/restore)
- **Selective** - Filter by domain, path, file, or custom patterns
- **Efficient** - Batches OSC messages, uses bulk operations where possible
- **Safe** - Dry-run preview before applying
- **Reversible** - Can create and apply reverse patches

#### Menu Management
```bash
# Create menu
php artisan wing:menu:create fx_menu

# Add command to menu
php artisan wing:menu:add fx_menu \
  --label="Reverb" \
  --snippet=reverb_preset \
  --submenu=reverb_menu

# Load menu file
php artisan wing:menu:load --file=definitions/menus.json
```

#### AI Management
```bash
# Optimize mix
php artisan wing:ai:optimize \
  --profile=live \
  --target=loudness

# Learn from usage
php artisan wing:ai:learn --session=recording_01

# Apply AI suggestions
php artisan wing:ai:apply --suggestions=ai/optimizations/mix_01.json
```

### 12.2 Command Options

| Command | Option | Description |
| ------- | ------ | ----------- |
| `wing:dump` | `--ip` | Console IP (or use auto-discovery) |
| `wing:dump` | `--out` | Output directory |
| `wing:dump` | `--rate` | Requests per second |
| `wing:dump` | `--resume` | Skip completed files |
| `wing:dump` | `--domains` | Domain filter (comma-separated) |
| `wing:snippet:*` | `--ip` | Console IP |
| `wing:cc:*` | `--file` | Load from definition file |
| `wing:cc:*` | `--mode` | Button mode: toggle, push, momentary |
| `wing:device:*` | `--max` | Maximum devices (default: 8) |
| `wing:discover` | `--network` | Network CIDR (default: /24) |
| `wing:discover` | `--timeout` | Discovery timeout (seconds) |
| `wing:*` | `--no-commit` | Disable auto-commit for this operation |
| `wing:*` | `--commit-msg` | Custom commit message |
| `wing:git:diff` | `--file` | Diff specific file |
| `wing:git:diff` | `--domain` | Diff specific domain |
| `wing:git:diff` | `--branch` | Diff against branch |
| `wing:git:history` | `--file` | History for specific file |
| `wing:git:history` | `--author` | Filter by author |
| `wing:git:history` | `--since` | Filter by date |

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

## 15. Advanced Features

### 15.1 Snippet System

Snippets are **partial console state snapshots** stored as JSON files.

**Format:**
```json
{
  "name": "vocal_mix",
  "description": "Vocal channel mix settings",
  "created_at": "ISO-8601",
  "paths": {
    "/ch/01/preamp/gain": -12.0,
    "/ch/01/eq/band1/freq": 250,
    "/bus/01/ch/01/level": 0.75
  },
  "metadata": {
    "tags": ["vocals", "live"],
    "author": "user"
  }
}
```

**Features:**
* Save current state of selected paths
* Restore to console
* Associate with CC buttons (ON/OFF)
* Organize in directories
* Version control friendly

### 15.2 Custom Control (CC) Management

**Button Configuration:**
```json
{
  "button_id": 1,
  "mode": "toggle",
  "on_snippet": "vocal_on",
  "off_snippet": "vocal_off",
  "menu": "fx_menu",
  "osc_routes": [
    {
      "device": "obs",
      "path": "/obs/scene/switch",
      "args": ["vocal_scene"]
    }
  ],
  "midi_cc": 64
}
```

**Knob Configuration:**
```json
{
  "knob_id": 1,
  "targets": [
    {
      "path": "/ch/01/preamp/gain",
      "formula": "linear:0:1:-60:0",
      "behavior": "direct"
    },
    {
      "path": "/ch/02/preamp/gain",
      "formula": "linear:0:1:-60:0",
      "behavior": "offset"
    }
  ],
  "tap_tempo": {
    "enabled": true,
    "targets": ["/fx/1/tempo", "/fx/2/tempo"]
  }
}
```

**Button Modes:**
* `toggle` - Stable ON/OFF state
* `push` - Momentary (press and release)
* `momentary` - Hold to activate

### 15.3 Multi-Device OSC Routing

Support for **up to 8 simultaneous OSC devices**:

```json
{
  "devices": [
    {
      "id": "wing_2",
      "ip": "192.168.8.201",
      "port": 2223,
      "enabled": true
    },
    {
      "id": "obs",
      "ip": "192.168.8.100",
      "port": 9000,
      "enabled": true
    },
    {
      "id": "x32",
      "ip": "192.168.8.202",
      "port": 10023,
      "enabled": true
    }
  ],
  "routes": [
    {
      "trigger": "cc_button_01",
      "devices": ["wing_2", "obs"],
      "commands": [
        {"device": "wing_2", "path": "/ch/01/mix/on", "args": [1]},
        {"device": "obs", "path": "/obs/scene/switch", "args": ["vocal"]}
      ]
    }
  ]
}
```

### 15.4 Menu System

**Nested Menu Structure:**
```json
{
  "menu_id": "main_menu",
  "items": [
    {
      "label": "FX",
      "type": "submenu",
      "menu": "fx_menu"
    },
    {
      "label": "Vocal Mix",
      "type": "snippet",
      "snippet": "vocal_mix"
    },
    {
      "label": "Scene 1",
      "type": "command",
      "command": "wing:snippet:load scene_01"
    }
  ]
}
```

Menus can:
* Call other menus (infinite nesting)
* Load snippets
* Execute commands
* Trigger OSC routes
* Reference definition files

### 15.5 Auto-Discovery

**Network Scanning:**
* Scan local network (/24 subnet)
* Send `/` queries to discover WING consoles
* Parse console identification responses
* Build console inventory
* Auto-connect to first available console

**Discovery Output:**
```json
{
  "discovered_consoles": [
    {
      "ip": "192.168.8.200",
      "model": "WING Rack",
      "name": "StarryNight",
      "firmware": "3.1.0",
      "response_time_ms": 3.68
    }
  ],
  "scan_network": "192.168.8.0/24",
  "scan_time": "ISO-8601"
}
```

### 15.6 AI Management Features

**Intelligent Automation:**
* Mix optimization based on profiles
* Automatic gain staging
* Frequency analysis and EQ suggestions
* Usage pattern learning
* Predictive parameter adjustment

**AI Data Storage:**
* Learning data in `ai/learning/`
* Optimization profiles in `ai/profiles/`
* Suggestions in `ai/optimizations/`

### 15.7 MIDI Integration

**MIDI Support:**
* MIDI CC mapping to OSC parameters
* MIDI note triggers for snippets
* MIDI clock sync
* External MIDI device control

**MIDI Configuration:**
```json
{
  "midi_input": "device_name",
  "midi_output": "device_name",
  "mappings": [
    {
      "midi_cc": 64,
      "osc_path": "/ch/01/preamp/gain",
      "formula": "linear:0:127:-60:0"
    }
  ]
}
```

## 16. Future Compatibility (Explicit)

This design **must support**:

* JSON → OSC restore tool
* Diff between two dumps
* Firmware drift detection
* Selective subtree restore
* Snippet versioning
* CC configuration migration
* Multi-console synchronization

---

## 17. Definition Files (Text-Editable)

All configurations use **human-readable JSON files** for easy editing:

### 17.1 Button Definitions
```json
{
  "buttons": [
    {
      "id": 1,
      "label": "Vocal FX",
      "mode": "toggle",
      "on_snippet": "vocal_fx_on",
      "off_snippet": "vocal_fx_off",
      "menu": "fx_menu"
    }
  ]
}
```

### 17.2 Knob Definitions
```json
{
  "knobs": [
    {
      "id": 1,
      "label": "Master Gain",
      "targets": [
        {
          "path": "/main/st/level",
          "formula": "linear:0:1:-60:0"
        }
      ]
    }
  ]
}
```

### 17.3 Menu Definitions
```json
{
  "menus": {
    "main": {
      "items": [
        {"label": "FX", "type": "submenu", "menu": "fx"},
        {"label": "Scenes", "type": "submenu", "menu": "scenes"}
      ]
    }
  }
}
```

### 17.4 OSC Route Definitions
```json
{
  "routes": [
    {
      "trigger": "cc_button_01",
      "devices": ["obs", "wing_2"],
      "commands": [
        {"device": "obs", "path": "/scene/switch", "args": ["vocal"]}
      ]
    }
  ]
}
```

## 18. Advanced Button/Knob Behaviors

### 18.1 Multi-Parameter Control

Single button/knob can control multiple parameters with different formulas:

```json
{
  "knob_id": 1,
  "targets": [
    {
      "path": "/ch/01/preamp/gain",
      "formula": "linear:0:1:-60:0"
    },
    {
      "path": "/ch/01/eq/band1/gain",
      "formula": "exponential:0:1:0:12"
    },
    {
      "path": "/bus/01/ch/01/level",
      "formula": "inverse:0:1:1:0"
    }
  ]
}
```

### 18.2 Time-Based Features

**Tap Tempo:**
* Single button press calculates tempo
* Applies to multiple FX devices
* Time data passed between presses

**Fugitive Actions:**
* Push-button mode with ON/OFF snippets
* Temporary state that auto-reverts
* Useful for preview/listen functions

### 18.3 Formula Types

* `linear` - Linear mapping
* `exponential` - Exponential curve
* `logarithmic` - Logarithmic curve
* `inverse` - Inverse mapping
* `custom` - User-defined function

## 19. Explicit Non-Goals

* No `.scn` parsing (use OSC directly)
* No GUI (CLI-only for automation)
* No assumptions about channel counts
* No reliance on undocumented OSC behavior
* No database dependencies (filesystem-only)

---

## 20. Acceptance Criteria

### 20.1 Core Dump/Export

* ✔ All reachable OSC paths are represented
* ✔ No UDP overflows crash the process
* ✔ Output is deterministic
* ✔ Partial failures do not abort execution
* ✔ A second run with `--resume` skips completed nodes

### 20.2 Snippet Management

* ✔ Save current console state as snippet
* ✔ Restore snippet to console
* ✔ List and manage snippets
* ✔ Associate snippets with CC buttons

### 20.3 Custom Control

* ✔ Configure CC buttons (toggle/push modes)
* ✔ Configure CC knobs with formulas
* ✔ Multi-parameter control
* ✔ Menu organization
* ✔ Text-editable definition files

### 20.4 Multi-Device OSC

* ✔ Simultaneous communication with up to 8 devices
* ✔ Route CC actions to multiple devices
* ✔ Device configuration management

### 20.5 Auto-Discovery

* ✔ Automatic console detection on /24 network
* ✔ Console identification and inventory
* ✔ Auto-connect capability

### 20.6 AI Management

* ✔ Mix optimization profiles
* ✔ Usage pattern learning
* ✔ Intelligent parameter suggestions

### 20.7 MIDI Support

* ✔ MIDI CC to OSC mapping
* ✔ MIDI note triggers
* ✔ External device control

### 20.8 Version Control

* ✔ Git repository auto-initialization
* ✔ Automatic commits after operations
* ✔ Branch management (create, switch, merge)
* ✔ Diff between commits/branches/files
* ✔ Blame functionality (who changed what)
* ✔ Commit history with filtering
* ✔ Tag management for snapshots
* ✔ Path annotations/comments
* ✔ Conflict detection and resolution
* ✔ Fast patch system (selective updates)
* ✔ Patch creation from diffs
* ✔ Selective patch application (domain, path, file filters)
* ✔ Patch preview (dry-run)
* ✔ Patch reversal (undo)
* ✔ Direct OSC application (no dump/restore)

---

## 21. Competitive Advantages vs wcc

| Feature | wcc | This System |
| ------- | --- | ----------- |
| **Storage** | Unknown | Filesystem-based (version control friendly) |
| **Snippets** | ✅ | ✅ Enhanced with metadata and versioning |
| **CC Management** | ✅ | ✅ Enhanced with formulas and multi-target |
| **Multi-Device** | ✅ (8 devices) | ✅ (8 devices) |
| **Menus** | ✅ | ✅ Enhanced with command execution |
| **Auto-Discovery** | ✅ | ✅ |
| **MIDI** | ✅ | ✅ |
| **AI Management** | ❌ | ✅ **Unique feature** |
| **Full State Export** | ❌ | ✅ **Unique feature** |
| **Diff/Version Control** | ❌ | ✅ **Unique feature** |
| **Fast Patch System** | ❌ | ✅ **Unique feature** (selective updates) |
| **Open Source** | ❌ (€10) | ✅ **Free and open** |
| **Text Definitions** | ✅ | ✅ Enhanced JSON format |

## 22. Developer Notes (Important)

This is **not just a crawler** — it is a **complete console management system**.

**Design Principles:**
* Correctness > speed
* Completeness > elegance
* Determinism > convenience
* Filesystem > database
* Open > proprietary

**Architecture Philosophy:**
* Everything is a file (JSON)
* Everything is version-controllable
* Everything is human-readable
* Everything is automatable

---

## 23. Implementation Roadmap

### Phase 1: Core (Current)
- ✅ Two-way OSC library
- ✅ Dump/export functionality
- ✅ Basic CLI commands
- ✅ Filesystem storage

### Phase 2: Version Control (Git Integration)
- [ ] Git repository initialization
- [ ] Auto-commit after operations
- [ ] Basic commit/history commands
- [ ] Branch management
- [ ] Diff functionality
- [ ] Blame functionality
- [ ] Tag management
- [ ] Conflict resolution
- [ ] Fast patch system (selective updates)
- [ ] Patch creation from diffs
- [ ] Selective patch application
- [ ] Patch preview and reversal

### Phase 3: Snippets
- [ ] Snippet save/restore
- [ ] Snippet management commands
- [ ] Snippet metadata
- [ ] Integration with version control

### Phase 4: Custom Control
- [ ] CC button configuration
- [ ] CC knob configuration
- [ ] Menu system
- [ ] Definition file format
- [ ] Integration with version control

### Phase 5: Multi-Device
- [ ] Multi-device OSC router
- [ ] Device configuration
- [ ] Route definitions
- [ ] Integration with version control

### Phase 6: Auto-Discovery
- [ ] Network scanning
- [ ] Console detection
- [ ] Auto-connect

### Phase 7: AI Management
- [ ] Mix optimization
- [ ] Usage learning
- [ ] Intelligent suggestions

### Phase 8: MIDI
- [ ] MIDI input/output
- [ ] CC mapping
- [ ] Clock sync

### Phase 9: Polish
- [ ] Documentation
- [ ] Open source packaging
- [ ] Composer package
