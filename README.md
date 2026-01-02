# WING CLI - Behringer WING Console Management

A Laravel-based CLI package for managing Behringer WING digital mixing console via OSC (Open Sound Control). This system provides filesystem-based export, storage, modification, and import capabilities for complete console configuration management.

## Purpose

This system exports the entire Behringer WING OSC tree into structured, replayable, and diff-friendly JSON datasets. The output serves as:

- A **complete inventory of console configuration**
- A **foundation for restore / replay tools**
- A **basis for diffing, auditing, and documentation**
- A long-term alternative to `.scn` files

## Features

- **Filesystem-based storage** - No databases, all data stored as JSON files
- **Network communication** - Direct OSC over UDP communication with WING console
- **Sharded output** - Files are split into logical domains (channels, buses, FX, etc.)
- **Resume capability** - Can resume interrupted dumps
- **Error handling** - Tracks failures without aborting execution
- **Domain filtering** - Extract specific domains only
- **Rate limiting** - Throttles requests to avoid overwhelming console

## Architecture

The system operates in 5 phases:

1. **Discovery** - Enumerate full OSC tree structure
2. **Classification** - Group paths into logical domains
3. **Extraction** - Dump values using safest method per node
4. **Persistence** - Write JSON shards incrementally
5. **Verification** - Track failures, retries, completeness

## Installation

```bash
composer install
```

## Usage

### Basic Dump

Export the entire WING console configuration:

```bash
php artisan wing:dump --ip=192.168.8.200 --out=wing_dump
```

### With Options

```bash
php artisan wing:dump \
  --ip=192.168.8.200 \
  --out=wing_dump \
  --rate=15 \
  --resume \
  --domains=ch,bus
```

### Command Options

| Option      | Description                          | Default     |
| ----------- | ------------------------------------ | ----------- |
| `--ip`      | Console IP address (required)        | -           |
| `--out`     | Output directory                     | `wing_dump` |
| `--rate`    | Requests per second                  | `15`        |
| `--resume`  | Skip completed files                 | `false`     |
| `--domains` | Optional domain filter (comma-separated) | -      |

## Output Structure

```
wing_dump/
├── meta.json          # Global metadata
├── index.json         # Tree structure (no values)
├── coverage.json      # Extraction statistics
├── errors.json        # Error log
├── domains/
│   ├── ch/           # Channels
│   ├── bus/          # Buses
│   ├── aux/          # Aux sends
│   ├── fx/           # Effects
│   ├── dca/          # DCA groups
│   ├── main/         # Main outputs
│   ├── cfg/          # Configuration
│   ├── $ctl/         # Control paths
│   └── misc/         # Unclassified
└── raw/              # Raw dumps
```

## Domain Classification

Paths are automatically classified by prefix:

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

## Technical Details

- **Protocol**: OSC over UDP
- **Port**: 2223
- **Max payload**: ~32 KB per packet
- **File size limit**: 32 KB per JSON file
- **Encoding**: UTF-8, pretty-printed JSON

## Requirements

- PHP 8.2+
- Laravel 12+
- Network access to WING console
- OSC libraries (to be added - see TODO)

## TODO

- [ ] Add proper OSC encoding/decoding library
- [ ] Implement complete OSC message parsing
- [ ] Add restore/import functionality
- [ ] Add diff tool for comparing dumps
- [ ] Add firmware version detection
- [ ] Package as standalone CLI tool

## Documentation

See `docs/product_spec.md` for complete technical specification.

## License

MIT

