Good catch — you’re not missing anything. On **WING Rack**, the wording and placement are **different than many online references**, and there is **no toggle literally labeled “OSC Remote”** on some firmware builds.

Here is the **accurate, firmware-safe explanation**.

---

## The Key Point (Important)

👉 **OSC is always enabled on WING / WING Rack.**
There is **no on/off switch** for OSC in current WING firmware.

If the console has:

* an IP address, and
* UDP port 2223 reachable,

then OSC is already active.

---

## Why You Don’t See “OSC Remote”

Older documentation and forum posts often say *“Enable OSC”*, but on WING:

* There is **no explicit OSC enable/disable toggle**
* OSC is part of the **general remote control stack**
* The UI does **not label OSC separately**

This is **normal and expected behavior**.

---

## What You *Should* See Instead

### SETUP → NETWORK

You should see sections like:

* **IP Configuration** (DHCP / Static)
* **Network Status**
* **Remote / Control-related settings**

But **no OSC checkbox**.

That does **not** mean OSC is disabled.

---

## How OSC Is Actually Controlled

OSC availability is determined by **three things only**:

### 1. Network is up

* Console has a valid IP
* Same subnet as your client (or routed correctly)

### 2. UDP port 2223 is open

* No firewall blocking inbound UDP
* No VLAN isolation

### 3. Client behaves correctly

* Sends to port 2223
* Listens on its **source UDP port** for replies

There is **no menu setting** beyond basic networking.

---

## Definitive Test (Do This)

From any OSC tool or your PHP script, send:

```
/?
```

If OSC is reachable, the WING Rack will reply with:

* A string identifying the console (model / firmware)

If you get a reply:
✅ OSC is working
✅ No UI setting is missing

If you do **not** get a reply:
❌ Network or client issue (not a console setting)

---

## Common Reasons People Think OSC Is “Off”

| Symptom                | Actual Cause                         |
| ---------------------- | ------------------------------------ |
| No response            | Client not listening for UDP replies |
| No response            | Firewall blocking UDP                |
| Works once             | Socket closed too early              |
| `/ch` works, `*` fails | UDP packet too large                 |
| Docs say “enable OSC”  | Docs are outdated / generic          |

---

## Firmware Reality Check

* WING / WING Rack / WING Compact all behave the same
* Firmware **3.x and newer**: OSC always active
* No known firmware exposes an OSC toggle

---

## Bottom Line

> **You will not find an “OSC Remote” switch — OSC is already on.**

