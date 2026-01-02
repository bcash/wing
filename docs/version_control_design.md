# Git-Based Version Control for WING Configuration

## 1. Overview

Since all WING configuration data is stored as JSON files in the filesystem, we can leverage **Git** as the underlying version control system. This provides:

* **Branching** - Create configuration variants (live, studio, backup)
* **Merging** - Combine changes from different sources
* **Diff** - See what changed between versions
* **Blame** - Track who changed what and when
* **History** - Complete audit trail
* **Comments** - Commit messages and annotations
* **Tags** - Mark important snapshots (releases, shows, etc.)

## 2. Architecture

### 2.1 Git Repository Structure

```
wing/
├── .git/                    # Git repository (initialized automatically)
├── .gitignore              # Exclude temp files, logs, etc.
├── .wing/                  # WING-specific metadata
│   ├── config.json        # VCS configuration
│   ├── authors.json       # Author mapping
│   └── annotations/       # Additional annotations
│
├── dumps/                  # Version-controlled
├── snippets/              # Version-controlled
├── cc/                    # Version-controlled
├── devices/               # Version-controlled
├── definitions/           # Version-controlled
├── patches/               # Fast patch files (version-controlled)
├── automations/           # Timeline-based automation (version-controlled)
└── ai/                    # Version-controlled (optional)
```

### 2.2 Git Integration Strategy

**Option A: Transparent Git (Recommended)**
- Git repository initialized automatically
- All operations use Git under the hood
- Users can use standard Git commands if desired
- Our CLI wraps Git with WING-specific commands

**Option B: Git-like System**
- Custom implementation
- More control but more maintenance
- Not recommended - Git is battle-tested

## 3. Core Features

### 3.1 Automatic Git Initialization

When first command is run:
```bash
php artisan wing:init
```

This:
1. Initializes Git repository in `wing/` directory
2. Creates `.gitignore` with appropriate exclusions
3. Creates initial commit
4. Sets up `.wing/config.json`

### 3.2 Commit Strategy

**Automatic Commits:**
- After dump operations
- After snippet save
- After CC configuration changes
- After device configuration changes

**Manual Commits:**
- User can commit explicitly
- Batch multiple changes

**Commit Message Format:**
```
[WING] <type>: <description>

<optional body>

Affected:
- snippets/vocal_mix.json
- cc/buttons/button_01.json

Tags: live, vocals
```

### 3.3 Branching Model

**Default Branches:**
- `main` - Production/stable configuration
- `live` - Live performance setup
- `studio` - Studio recording setup
- `backup` - Backup snapshots

**Branch Operations:**
```bash
# Create branch for show
php artisan wing:branch:create show_2024_01_15

# Switch branch
php artisan wing:branch:switch live

# List branches
php artisan wing:branch:list

# Merge branches
php artisan wing:branch:merge studio into main
```

### 3.4 Diff & Comparison

**Diff Commands:**
```bash
# Diff current vs last commit
php artisan wing:diff

# Diff between commits
php artisan wing:diff commit1 commit2

# Diff between branches
php artisan wing:diff main live

# Diff specific file
php artisan wing:diff --file=snippets/vocal_mix.json

# Diff specific domain
php artisan wing:diff --domain=ch
```

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

### 3.5 Blame & History

**Blame Command:**
```bash
# See who changed what in a file
php artisan wing:blame snippets/vocal_mix.json

# Blame specific path
php artisan wing:blame snippets/vocal_mix.json --path=/ch/01/preamp/gain
```

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

**History Command:**
```bash
# Show commit history
php artisan wing:history

# History for specific file
php artisan wing:history --file=snippets/vocal_mix.json

# History with filters
php artisan wing:history --author=user --since=2024-01-01
```

### 3.6 Comments & Annotations

**Commit Messages:**
- Standard Git commit messages
- Enhanced with WING-specific metadata

**Annotations:**
```bash
# Add annotation to a path
php artisan wing:annotate \
  --file=snippets/vocal_mix.json \
  --path=/ch/01/preamp/gain \
  --comment="Adjusted for live venue acoustics"

# View annotations
php artisan wing:annotate:view snippets/vocal_mix.json
```

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

### 3.7 Tags & Snapshots

**Tag Important Versions:**
```bash
# Create tag
php artisan wing:tag:create show_2024_01_15 \
  --message="Pre-show configuration"

# List tags
php artisan wing:tag:list

# Restore from tag
php artisan wing:tag:restore show_2024_01_15 --ip=192.168.8.200
```

### 3.8 Fast Patch System (Selective Updates)

**Patch Creation:**
```bash
# Create patch from diff
php artisan wing:patch:create \
  --from=commit1 \
  --to=commit2 \
  --out=patches/vocal_adjustments.patch

# Create patch from branch diff
php artisan wing:patch:create \
  --from=main \
  --to=live \
  --out=patches/live_changes.patch

# Create patch from file diff
php artisan wing:patch:create \
  --file=snippets/vocal_mix.json \
  --out=patches/vocal_mix_update.patch
```

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
    },
    {
      "file": "snippets/vocal_mix.json",
      "path": "/ch/01/eq/band1/freq",
      "operation": "update",
      "old_value": 250,
      "new_value": 300,
      "osc_path": "/ch/01/eq/band1/freq",
      "osc_types": "f",
      "osc_args": [300.0]
    }
  ],
  "metadata": {
    "affected_domains": ["ch"],
    "affected_files": ["snippets/vocal_mix.json"],
    "total_changes": 2
  }
}
```

**Selective Patch Application:**
```bash
# Apply entire patch to console
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200

# Apply only specific paths
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --paths=/ch/01/preamp/gain

# Apply only specific domain
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --domain=ch

# Apply only specific files
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --files=snippets/vocal_mix.json

# Preview before applying (dry-run)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --dry-run

# Apply with filters (multiple)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --domain=ch \
  --exclude-paths=/ch/01/eq/*
```

**Patch Management:**
```bash
# List patches
php artisan wing:patch:list

# View patch details
php artisan wing:patch:view patches/vocal_adjustments.patch

# Reverse patch (undo changes)
php artisan wing:patch:reverse patches/vocal_adjustments.patch \
  --ip=192.168.8.200

# Apply patch to files (not console)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --to-files

# Create patch from current console state
php artisan wing:patch:create \
  --from-console=192.168.8.200 \
  --to=snippets/vocal_mix.json \
  --out=patches/console_to_file.patch
```

**Performance Characteristics:**
* **Very Fast** - Only sends OSC messages for changed paths
* **Selective** - Can filter by path, domain, file, or custom filters
* **Efficient** - No full dump/restore required
* **Safe** - Dry-run preview before applying
* **Reversible** - Can create reverse patch to undo changes

## 4. Implementation Design

### 4.1 Git Wrapper Service

Create `App\Services\VersionControl\GitManager`:

```php
class GitManager
{
    public function init(): void
    public function commit(string $message, array $files = []): string
    public function branch(string $name): void
    public function switch(string $branch): void
    public function merge(string $source, string $target): void
    public function diff(string $from, ?string $to = null): array
    public function blame(string $file, ?string $path = null): array
    public function history(string $file = null, array $options = []): array
    public function tag(string $name, string $message): void
}
```

### 4.2 Automatic Commit Hooks

**After Operations:**
- `wing:dump` → Auto-commit dump
- `wing:snippet:save` → Auto-commit snippet
- `wing:cc:*` → Auto-commit CC changes
- `wing:device:*` → Auto-commit device changes

**Commit Message Generation:**
```php
class CommitMessageGenerator
{
    public function forDump(array $stats): string
    public function forSnippet(string $name): string
    public function forCC(string $type, int $id): string
    public function forDevice(string $deviceId): string
}
```

### 4.3 Enhanced Metadata

**Commit Metadata:**
```json
{
  "commit": "abc123",
  "message": "[WING] snippet:save vocal_mix",
  "author": "user@example.com",
  "date": "2024-01-15T10:30:00Z",
  "wing_metadata": {
    "operation": "snippet:save",
    "console_ip": "192.168.8.200",
    "console_name": "StarryNight",
    "firmware": "3.1.0",
    "affected_files": ["snippets/vocal_mix.json"],
    "tags": ["vocals", "live"]
  }
}
```

### 4.4 Patch System Implementation

**Patch Manager Service:**
```php
class PatchManager
{
    /**
     * Create patch from diff
     */
    public function create(
        string $from,
        ?string $to = null,
        ?string $outputFile = null,
        array $options = []
    ): Patch;

    /**
     * Apply patch to console (very fast - direct OSC)
     */
    public function applyToConsole(
        Patch $patch,
        string $ip,
        array $filters = [],
        bool $dryRun = false
    ): PatchResult;

    /**
     * Apply patch to files
     */
    public function applyToFiles(
        Patch $patch,
        array $filters = []
    ): PatchResult;

    /**
     * Create reverse patch (undo)
     */
    public function reverse(Patch $patch): Patch;

    /**
     * Filter patch by criteria
     */
    public function filter(
        Patch $patch,
        array $filters
    ): Patch;
}
```

**Patch Class:**
```php
class Patch
{
    private string $version;
    private string $createdAt;
    private ?string $from;
    private ?string $to;
    private string $description;
    private array $changes;
    private array $metadata;

    /**
     * Get changes filtered by criteria
     */
    public function getFilteredChanges(array $filters): array;

    /**
     * Get changes by domain
     */
    public function getChangesByDomain(string $domain): array;

    /**
     * Get changes by file
     */
    public function getChangesByFile(string $file): array;

    /**
     * Get changes by path pattern
     */
    public function getChangesByPath(string $pathPattern): array;

    /**
     * Create reverse patch
     */
    public function reverse(): Patch;
}
```

**Patch Change Format:**
```php
class PatchChange
{
    public string $file;
    public string $path;
    public string $operation; // 'update', 'add', 'delete'
    public mixed $oldValue;
    public mixed $newValue;
    public string $oscPath;
    public string $oscTypes;
    public array $oscArgs;
}
```

**Fast Application Strategy:**
1. Parse patch file (JSON)
2. Apply filters (domain, path, file, etc.)
3. Group changes by OSC path
4. Send OSC messages directly (no dump/restore)
5. Use bulk operations where possible
6. Track success/failure per change
7. Return detailed results

**Performance Optimizations:**
* Batch OSC messages (group by domain/path)
* Use bulk dump where applicable
* Parallel OSC sends (if multiple paths)
* Cache OSC client connections
* Skip unchanged values (compare before sending)

### 4.5 Timeline-Based Automation (CSS Animation-Style)

**Automation Format:**
```json
{
  "version": "1.0",
  "name": "vocal_fade_in",
  "description": "Smooth vocal channel fade-in",
  "duration": 5000,
  "unit": "ms",
  "loop": false,
  "iterations": 1,
  "timeline": [
    {
      "timestamp": 0,
      "easing": "ease-in",
      "changes": [
        {
          "osc_path": "/ch/01/mix/level",
          "value": 0.0,
          "osc_types": "f"
        }
      ]
    },
    {
      "timestamp": 5000,
      "easing": "ease-out",
      "changes": [
        {
          "osc_path": "/ch/01/mix/level",
          "value": 1.0,
          "osc_types": "f"
        }
      ]
    }
  ],
  "keyframes": {
    "0%": {
      "/ch/01/mix/level": 0.0,
      "/ch/01/preamp/gain": -60.0
    },
    "50%": {
      "/ch/01/mix/level": 0.5,
      "/ch/01/preamp/gain": -30.0
    },
    "100%": {
      "/ch/01/mix/level": 1.0,
      "/ch/01/preamp/gain": -12.0
    }
  },
  "easing": "ease-in-out",
  "metadata": {
    "created_at": "2024-01-15T10:30:00Z",
    "author": "user@example.com",
    "tags": ["vocals", "fade", "live"]
  }
}
```

**Keyframe Format (CSS-style):**
```json
{
  "keyframes": {
    "0%": {
      "/ch/01/mix/level": 0.0,
      "/ch/01/preamp/gain": -60.0
    },
    "25%": {
      "/ch/01/mix/level": 0.25
    },
    "50%": {
      "/ch/01/mix/level": 0.5,
      "/ch/01/preamp/gain": -30.0
    },
    "75%": {
      "/ch/01/mix/level": 0.75
    },
    "100%": {
      "/ch/01/mix/level": 1.0,
      "/ch/01/preamp/gain": -12.0
    }
  },
  "duration": 10000,
  "easing": "ease-in-out"
}
```

**Easing Functions (CSS-compatible):**
* `linear` - Constant speed
* `ease` - Slow start, fast middle, slow end
* `ease-in` - Slow start
* `ease-out` - Slow end
* `ease-in-out` - Slow start and end
* `cubic-bezier(x1, y1, x2, y2)` - Custom curve
* `steps(n)` - Step function
* `steps(n, start|end)` - Step with direction

**Automation Manager Service:**
```php
class AutomationManager
{
    /**
     * Create automation from keyframes
     */
    public function create(
        string $name,
        array $keyframes,
        int $duration,
        string $easing = 'linear'
    ): Automation;

    /**
     * Execute automation on console (real-time)
     */
    public function execute(
        Automation $automation,
        string $ip,
        bool $loop = false,
        int $iterations = 1
    ): AutomationResult;

    /**
     * Convert automation to patch (snapshot at end)
     */
    public function toPatch(Automation $automation): Patch;

    /**
     * Create automation from patch (interpolate between states)
     */
    public function fromPatch(
        Patch $patch,
        int $duration,
        string $easing = 'ease-in-out'
    ): Automation;

    /**
     * Preview automation (dry-run, show timeline)
     */
    public function preview(Automation $automation): array;
}
```

**Automation Execution:**
1. Parse keyframes and calculate intermediate values
2. Apply easing function to interpolate between keyframes
3. Send OSC messages at calculated timestamps
4. Support real-time execution with precise timing
5. Support loop and iteration control
6. Track progress and allow cancellation

**Integration with Patches:**
* Convert patch to automation (smooth transition)
* Convert automation to patch (end state snapshot)
* Combine multiple automations in sequence
* Parallel automations for different parameters

### 4.6 .gitignore Configuration

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

## 5. CLI Commands

### 5.1 Patch Commands

```bash
# Create patch from diff
php artisan wing:patch:create \
  --from=commit1 \
  --to=commit2 \
  --out=patches/vocal_adjustments.patch

# Apply patch to console (very fast)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200

# Apply with selective filters
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --domain=ch \
  --paths=/ch/01/preamp/gain

# Preview patch (dry-run)
php artisan wing:patch:apply patches/vocal_adjustments.patch \
  --ip=192.168.8.200 \
  --dry-run

# Reverse patch (undo)
php artisan wing:patch:reverse patches/vocal_adjustments.patch \
  --ip=192.168.8.200

# List patches
php artisan wing:patch:list

# View patch details
php artisan wing:patch:view patches/vocal_adjustments.patch
```

### 5.2 Automation Commands (Timeline-Based)

```bash
# Create automation from keyframes
php artisan wing:automation:create vocal_fade_in \
  --keyframes=automations/vocal_fade.json \
  --duration=5000 \
  --easing=ease-in-out

# Create automation from patch (smooth transition)
php artisan wing:automation:from-patch patches/vocal_adjustments.patch \
  --duration=10000 \
  --easing=ease-in-out \
  --out=automations/vocal_transition.json

# Execute automation on console (real-time)
php artisan wing:automation:play vocal_fade_in \
  --ip=192.168.8.200

# Execute with options
php artisan wing:automation:play vocal_fade_in \
  --ip=192.168.8.200 \
  --loop \
  --iterations=3

# Preview automation (show timeline)
php artisan wing:automation:preview vocal_fade_in

# Convert automation to patch (end state)
php artisan wing:automation:to-patch vocal_fade_in \
  --out=patches/vocal_fade_end.patch

# List automations
php artisan wing:automation:list

# View automation details
php artisan wing:automation:view vocal_fade_in

# Stop running automation
php artisan wing:automation:stop --ip=192.168.8.200
```

**Keyframe File Format:**
```json
{
  "keyframes": {
    "0%": {
      "/ch/01/mix/level": 0.0,
      "/ch/01/preamp/gain": -60.0
    },
    "50%": {
      "/ch/01/mix/level": 0.5,
      "/ch/01/preamp/gain": -30.0
    },
    "100%": {
      "/ch/01/mix/level": 1.0,
      "/ch/01/preamp/gain": -12.0
    }
  },
  "duration": 10000,
  "easing": "ease-in-out"
}
```

### 5.3 Version Control Commands

```bash
# Initialize Git repository
php artisan wing:git:init

# Status
php artisan wing:git:status

# Commit changes
php artisan wing:git:commit --message="Updated vocal mix"

# Branch operations
php artisan wing:git:branch:create <name>
php artisan wing:git:branch:switch <name>
php artisan wing:git:branch:list
php artisan wing:git:branch:merge <source> <target>

# Diff operations
php artisan wing:git:diff [commit1] [commit2]
php artisan wing:git:diff --branch=<branch>
php artisan wing:git:diff --file=<file>

# Blame
php artisan wing:git:blame <file> [--path=<path>]

# History
php artisan wing:git:history [--file=<file>] [--author=<author>]

# Tags
php artisan wing:git:tag:create <name> [--message=<msg>]
php artisan wing:git:tag:list
php artisan wing:git:tag:restore <name>
```

### 5.2 Integration with Existing Commands

**Auto-commit flags:**
```bash
# Disable auto-commit
php artisan wing:snippet:save vocal_mix --no-commit

# Custom commit message
php artisan wing:snippet:save vocal_mix --commit-msg="Live vocal preset"
```

## 6. Advanced Features

### 6.1 Conflict Resolution

**Merge Conflicts:**
- Detect conflicts in JSON files
- Provide 3-way merge interface
- Manual resolution with CLI prompts
- Automatic resolution for simple cases

### 6.2 Selective Restore

**Restore Specific Paths:**
```bash
# Restore only specific paths from a commit
php artisan wing:git:restore commit123 \
  --paths=/ch/01,/ch/02 \
  --ip=192.168.8.200
```

### 6.3 Configuration Templates

**Template System:**
```bash
# Create template from current state
php artisan wing:template:create live_venue

# Apply template
php artisan wing:template:apply live_venue --ip=192.168.8.200
```

Templates stored as Git branches or tags.

### 6.4 Collaboration Features

**Remote Repositories:**
```bash
# Add remote
php artisan wing:git:remote:add origin <url>

# Push changes
php artisan wing:git:push

# Pull changes
php artisan wing:git:pull
```

**Multi-user Workflow:**
- Standard Git workflow
- Branch per user/feature
- Merge requests via Git
- Conflict resolution

## 7. Benefits

### 7.1 For Users

* **Safety** - Never lose configuration
* **Experimentation** - Try changes, revert easily
* **Collaboration** - Multiple users can work together
* **Audit Trail** - Know who changed what and when
* **Rollback** - Restore previous working state
* **Branching** - Maintain multiple configurations

### 7.2 For Development

* **Testing** - Test changes in branches
* **Documentation** - Commit messages document changes
* **Debugging** - See what changed when issues occur
* **Backup** - Git provides built-in backup
* **Distribution** - Share configs via Git remotes

## 8. Implementation Phases

### Phase 1: Basic Git Integration
- [ ] Git repository initialization
- [ ] Auto-commit after operations
- [ ] Basic commit/history commands
- [ ] .gitignore setup

### Phase 2: Branching & Merging
- [ ] Branch management commands
- [ ] Merge operations
- [ ] Conflict detection

### Phase 3: Diff & Blame
- [ ] Diff commands
- [ ] Blame functionality
- [ ] Enhanced output formatting

### Phase 4: Fast Patch System
- [ ] Patch creation from diffs
- [ ] Patch file format (JSON)
- [ ] Patch application to console (direct OSC)
- [ ] Selective filtering (domain, path, file)
- [ ] Patch preview (dry-run)
- [ ] Patch reversal
- [ ] Performance optimizations (batching, bulk ops)

### Phase 5: Timeline-Based Automation
- [ ] Keyframe system (CSS-style)
- [ ] Easing function support (linear, ease-in, ease-out, etc.)
- [ ] Real-time automation execution
- [ ] Loop and iteration control
- [ ] Patch-to-automation conversion
- [ ] Automation-to-patch conversion
- [ ] Multi-parameter simultaneous animation
- [ ] Precise timing control

### Phase 6: Advanced Features
- [ ] Tags and snapshots
- [ ] Annotations
- [ ] Template system
- [ ] Remote repository support

## 9. Example Workflows

### 9.1 Show Preparation

```bash
# Create branch for show
php artisan wing:git:branch:create show_2024_01_15

# Make changes
php artisan wing:snippet:save show_preset_01
php artisan wing:cc:button:set 1 --on-snippet=show_preset_01

# Commit
php artisan wing:git:commit --message="Show configuration"

# Tag for easy restore
php artisan wing:git:tag:create show_2024_01_15
```

### 9.2 Experimentation

```bash
# Create experimental branch
php artisan wing:git:branch:create experiment_vocal_eq

# Try changes
php artisan wing:snippet:save experimental_vocal

# Compare with main
php artisan wing:git:diff main experiment_vocal_eq

# If good, merge
php artisan wing:git:branch:merge experiment_vocal_eq main

# If bad, discard
php artisan wing:git:branch:switch main
php artisan wing:git:branch:delete experiment_vocal_eq
```

### 9.3 Collaboration

```bash
# User 1: Make changes
php artisan wing:snippet:save user1_mix
php artisan wing:git:commit --message="User 1 mix"
php artisan wing:git:push

# User 2: Pull and merge
php artisan wing:git:pull
php artisan wing:git:branch:merge user1_branch main
```

## 10. Technical Considerations

### 10.1 Git Repository Location

**Option A: Root `wing/` directory (Recommended)**
- Single repository for all configs
- Simple structure
- Easy to manage

**Option B: Separate repos per type**
- `wing/snippets/.git`
- `wing/cc/.git`
- More complex but more granular

**Recommendation:** Option A - single repository

### 10.2 Commit Frequency

**Strategy:**
- Auto-commit after each operation (default)
- Batch commits with `--no-commit` flag
- Manual commits always available

### 10.3 Large File Handling

**Considerations:**
- Dumps can be large
- Git LFS for large files (optional)
- Or exclude dumps from Git (user choice)

### 10.4 Performance

**Optimizations:**
- Lazy Git initialization
- Batch Git operations
- Cache Git status
- Async commits for non-critical operations

## 11. Security & Privacy

### 11.1 Sensitive Data

**Considerations:**
- Some configs may contain sensitive info
- Git history is permanent
- Provide option to exclude sensitive paths
- Support for encrypted storage

### 11.2 Access Control

**Features:**
- Git hooks for validation
- Pre-commit checks
- Author authentication
- Audit logging

