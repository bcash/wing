# Wing Wisdom

**Inventory / Equipment List**

Behringer Wing Rack. 

Behringer WING Live Card \- Dual SD-card multitrack recorder (32ch per card / 64ch linked)

Mac studio linked via Behringer USB Audio Interface (WING internal)  to do full 32 track USB recording and playback.

We run the wing at a clock rate of 48k.  Sync source is internal.  Firmware is 3.1-0.

2 Sennheiser G4 IEM system Wireless in-ear transmitters and receivers (used for Brian and Rachelle)

TASCAM 8 channel audio interface for tracks playback for live usage.

1 Behringer DL32  
2 Behringer SD8 AES50 stage boxes  
1 Behringer SD16 AES50  stage box  
1 Midas Stage Connect box DN4880

**Channels** 

1. Channel Input, Trim & Balance   
2. Filter (Hi cut, lo cut, tilt eq)   
3. Gate Model   
4. EQ model   
5. Dynamics/Compressor Model (with designatable key \- any bus, main, matrix, or aux, crossover & filter mode)  
6. Insert FX 1 one of 16 rack processors   
7. Fader   
8. Insert FX 2 (another of the 16 rack effects)   
9. Width  
10. Main Sends (M 1-4)

The bus tap may happen at ANY stage.  Default is 5, after Dynamics.

**Aux inputs**

Aux inputs have this channel stack

1. Aux input  
2. Dynamics/Compresser Model (no designatable key, crossover, or filter mode)  
3. EQ Model  
4. Insert FX (one of the 16 FX rack processors)  
5. Main Sends (M 1-4)

For aux channels, the bus tap always happens after 4, after the Insert.

Aux channels are typically used for: FX returns, Playback, External devices.

**Buses**

1. Input \- Buses may be fed from any Channel 1-40, Aux 1-8, or Bus 1-16.  Trim, Balance, Delay  
2. Dynamics/Compressor Model (with designatable key \- any bus, main, matrix, or aux, crossover & filter mode)  
3. Insert FX 1 one of 16 rack processors  
4. Fader   
5. EQ Model  
6. Insert FX 2 (another of the 16 rack effects)   
7. Width  
8. Main Sends (M 1-4)

A Bus Send FROM A Bus may only be tapped Pre-Fader, or Post-Fader

# **Behringer WING – Current Configuration Summary**

## **Console & Software**

* **Console model:** WING Rack

* **Console name:** `StarryNight`

* **Firmware (console):** 3.1.0

* **WING Edit version:** 3.2.1

* **IP (console):** 192.168.8.200

* **IP (this Mac):** 192.168.86.72

* **Connection state:** Connected & synchronized

* **Auto-connect:** ON

* **Auto-sync:** ON

* **Sync direction:** **Mixer → PC**

* **Active WING model:** wing-rack

---

## **SETUP → GENERAL**

### **Operation (WING Edit)**

* Confirm library load: **ON**

* Always show active scene: **ON**

### **UI / Workflow**

* CC tap tempo flash: **ON**

* SoF frame (Sends-on-Faders frame): **ON**

* Show bus sends button names: **ON**

* Enable mouse wheel: **ON**

* Touch and hold edit: **ON**

* Restore windows at startup: **ON**

---

## **Meter Settings**

### **Monitor / LR Meter**

* Source: **MAIN.1**

* Meter tap: **AUTO**

### **Fader Meter Tap Points**

* Channel fader meters: **PRE**

* Bus fader meters: **POST**

* Main fader meters: **POST**

* Matrix fader meters: **POST**

* DCA fader meters: **PRE**

### **Performance**

* Reduced meter update rate (50%): **OFF**

---

## **Preferences (General Tab)**

* USB host speed: **HS (High Speed)**

* Link mixer channel \+ screen: **ON**

* Only channel strip: **OFF**

* Fader mode fine: **ON**

* Disconnect warning: **ON**

* Grey colors gamma: **1.00**

---

## **SETUP → CONNECT**

### **Network**

* Console discovered automatically

* Manual IP address field unused

* Rescan available but not needed

---

## **SETUP → AUDIO**

### **Audio Clock**

* Sample rate: **48 kHz**

* Sync source: **Internal**

### **Input Select**

* Global input select: **MAIN**

* Channel range visible:

  * Channels 1–40

  * AUX channels 1–8

---

## **Audio Preferences**

* Main link: **OFF**

* DCA mutegroups: **ON**

* Mute group / SIP override: **ON**

* Startup main mute: **ON**

* Global input select override: **ON**

### **Solo Behavior (Edit Settings)**

* Exclusive solo: **ON**

* Solo follows select: **ON**

* Select follows solo: **ON**

* Bus SoF activates solo: **ON**

---

## **Solo System**

### **Solo Mode**

* **LIVE** (not Studio, not SIP)

### **Solo Tap Type**

* Channel solo: **AFL**

* Bus solo: **AFL**

* Main solo: **AFL**

* Matrix solo: **AFL**

### **Source Solo**

* OFF

* Assignable options shown:

  * CH39

  * AUX7

### **Talkback**

* OFF

* Assignable options shown:

  * CH40

  * AUX8

---

## **USB Audio**

* USB audio I/O count: **48 IN / 48 OUT**

---

## **Automix**

* X enable: **ON**

* Y enable: **ON**

---

## **AES50 Ports**

* AES50 A: 0 COR / 0 UNC

* AES50 B: 0 COR / 0 UNC

* AES50 C: 0 COR / 0 UNC

* No AES50 devices currently connected

---

## **High-Level Interpretation (What This Setup Indicates)**

* This WING Rack is configured as a **live-production console**, not studio.

* **AFL everywhere** suggests you want solos to reflect real mix balance.

* **PRE metering on channels** \= gain staging focus.

* **POST metering on buses/mains/matrices** \= output confidence.

* **MAIN input selected globally** → live sources active (ALT reserved for VSC).

* **USB 48×48 enabled** → full DAW or multitrack workflow ready.

* **Automix enabled** → likely speech / vocals / panel usage possible.

* **No AES50 active** → currently operating standalone (no stage box).

# **Behringer WING Rack – Interpreted Configuration Summary**

*Source: Snapshot.snap \+ attached screenshots*

---

## **Console Identity**

* **Model:** WING Rack

* **Console Name:** `StarryNight`

* **Firmware:** 3.1.0

* **WING Edit Version:** 3.2.1

* **Sync Direction:** Mixer → PC

* **Auto-Connect:** Enabled

* **Auto-Sync:** Enabled

---

## **Audio Clock & Sync**

* **Sample Rate:** **48 kHz**

* **Clock Source:** **Internal**

* **AES50:** No clock errors reported (all ports clean)

* **Main Link:** **OFF**

This confirms the WING is the **clock master** and no external digital clocking is in use.

---

## **USB Audio Interface**

* **USB Audio Mode:** **48 In / 48 Out**

* **USB Host Speed:** **High Speed (HS)**

This matches a full multitrack workflow (DAW \+ virtual soundcheck capable).

---

## **Input Selection / Virtual Soundcheck**

* **Global Input Select:** **MAIN**

* **ALT Inputs:** Configured but inactive globally

* **Global Input Select Override:** Enabled

* **Per-Channel Manual Override:** Available

This is a **live-show default**, with ALT ready for virtual soundcheck flipping.

---

## **Solo System**

* **Solo Mode:** **LIVE**

* **Channel Solo:** **AFL**

* **Bus Solo:** **AFL**

* **Main Solo:** **AFL**

* **Matrix Solo:** **AFL**

* **Exclusive Solo:** Enabled

* **Solo Follows Select:** Enabled

* **Select Follows Solo:** Enabled

* **Bus Sends-on-Faders activates Solo:** Enabled

* **Source Solo:** Assigned (CH39 / AUX7 available)

* **Talkback Source:** Configurable (CH40 / AUX8)

This is a **FOH-safe solo configuration** with consistent AFL behavior.

---

## **Metering Configuration**

### **Monitor / LR**

* **Monitor Source:** MAIN 1

* **Monitor Meter Tap:** AUTO

### **Channel & Bus Meters**

| Meter Type | Setting |
| ----- | ----- |
| Channel Fader-Meters | **PRE** |
| Bus Fader-Meters | **POST** |
| Main Fader-Meters | **POST** |
| Matrix Fader-Meters | **POST** |
| DCA Fader-Meters | **PRE** |

*   
  **Reduced Meter Update Rate:** OFF (full refresh)

This favors **gain-staging visibility on channels** and **post-processing visibility on outputs**.

---

## **Preferences & UI Behavior**

* **Confirm Library Load:** ON

* **Always Show Active Scene:** ON

* **SOF Frame:** ON

* **Show Bus Sends Button Names:** ON

* **Mouse Wheel Enabled:** ON

* **Touch & Hold Edit:** ON

* **Restore Windows at Startup:** ON

* **Link Mixer Channel \+ Screen:** ON

* **Fader Mode Fine:** ON

* **Disconnect Warning:** ON

* **Grey Colors Gamma:** 1.00

---

## **Mute / DCA Behavior**

* **DCA Mute Groups:** Enabled

* **Mute Group / SIP Override:** Enabled

* **Startup Main Mute:** Enabled

This is a **safe boot configuration** that prevents accidental PA output.

---

## **Automix**

* **Automix X:** OFF

* **Automix Y:** OFF

(Consistent with music / band use, not conference.)

---

## **Outputs & Routing (High-Level)**

* **Local Outputs:** Actively routed (no muting or polarity inversion)

* **Recording Outputs:** Configured but idle

* **AES / USB / Card Routing:** Present, unlocked, and clean

* **No forced user-signal routing active by default**

---

## **FX / Processing (Global State)**

* FX racks present but **not globally forced**

* Channel, bus, and main processing stored per channel

* No snapshot-level overrides of FX engines

---

## **Summary (What This Configuration Represents)**

This WING Rack is configured as:

* 🎚 **Professional live console default**

* 🎧 **FOH-safe solo behavior**

* 💻 **Full 48×48 USB multitrack \+ virtual soundcheck ready**

* 🔒 **Safe boot & mute logic**

* 🎛 **Gain-focused channel metering**

* 🧠 **Advanced but restrained automation (no automix)**

---

# **Quick WING Tips**

## **Channel Source & Routing Explained — Mono vs Stereo & Input Naming**

### **Overview**

This guide explains how **channels, sources, and routing** work on the Behringer WING console, highlighting how WING differs from consoles like the X32. On WING, a **channel strip can be mono or stereo**, and multiple physical inputs can feed a single channel.

Firmware reference: **v1.10**  
 (If routing behavior has changed in later firmware, this should be noted and updated.)

---

## **Key Concept: What Is a Channel on WING?**

* A **channel strip** on WING can process:

  * A **mono source** (e.g., a single microphone)

  * A **stereo source** (e.g., drum overheads, stereo guitar rigs, keyboards)

* A stereo channel uses **two physical inputs (sources)** but occupies **one channel strip**.

---

## **Routing Overview (CHANNELS Page)**

The **Channels** routing page is where you assign physical or digital inputs to channel strips.

### **Patching Safety**

* Routing changes are protected by a **lock/unlock system**.

* Unlocking is required before assigning or changing inputs, preventing accidental changes during operation.

---

## **Main Input vs Alternate Input**

* Each channel has:

  * **Main Input** (primary source feeding the channel)

  * **Alternate Input** (secondary source, covered separately)

* This guide focuses on **Main Input** assignment.

---

## **Source Selection**

For each of the **48 available channels**, you can choose from many source types:

* Local XLR inputs

* AES50 (A / B / C)

* USB returns

* WING-LIVE SD card playback

* Other internal or digital sources

In the example shown:

* Virtual Soundcheck is used via **WING-LIVE SD card**

* AES50 inputs are not active

---

## **Creating Stereo Sources (SOURCE Menu)**

Stereo sources are created **in the Source section**, not in the channel itself.

### **Stereo Pair Rules**

* Stereo sources must be created from **odd–even input pairs**

  * Example:

    * Input **7** automatically pairs with **8**

    * Input **11** pairs with **12**

    * Input **13** pairs with **14**

* Once paired, the source appears as a **single stereo source** instead of two mono sources.

### **Example Stereo Sources**

* Drum overheads: Inputs 7–8

* Acoustic guitar (stereo processor): Inputs 9–10

* Electric guitar (stereo rig): Inputs 11–12

* Stereo keyboard rig: Inputs 13–14

---

## **Input Naming (Source-Level Naming)**

* Inputs can be **renamed at the Source level**

* This is especially useful for:

  * Festivals

  * Multi-band shows

  * Scene changes

### **Why Source Naming Matters**

* Named sources appear consistently in channel assignment lists

* Example:

  * An AES50 input can always be labeled **“Kick”**

  * Across scenes, that name remains visible and identifiable

---

## **Assigning Sources to Channels**

Once sources are defined:

* Go back to the **Channels** page

* Assign mono or stereo sources to channel strips

* Stereo sources occupy **one channel strip**, not two

Examples shown:

* Bass: mono source

* Acoustic guitar: stereo source

* Electric guitar: stereo source

* Keyboards: stereo source

---

## **Locking the Patch**

* After assigning all sources:

  * **Lock the patch**

  * Begin mixing safely without risk of routing changes

---

## **Summary**

* WING separates **sources** from **channels**

* Stereo is defined at the **source level**, not the channel level

* One channel strip can process mono or stereo

* Input naming improves workflow, especially in complex shows

* Patch locking prevents accidental routing errors

# **Mixing with Subgroups on Behringer WING**

## **Setup, Routing, and Mix Bus Compression Strategy**

### **Purpose**

Subgroups on the Behringer WING provide **global control, consistency, and mix stability** by routing related channels into shared buses before feeding the Main L/R bus. This enables **group EQ, compression, and parallel processing**, and supports semi–auto-mix workflows for FOH, broadcast, and volunteer operators.

---

## **Core Subgroup Signal Flow**

`Input Channels → Subgroups (Mix Buses) → Main L/R`

**Important Rule:**  
 Channels must **NOT** send directly to Main L/R if they are routed through subgroups.  
 Otherwise, subgroup processing is bypassed.

---

## **Why Use Subgroups**

* Apply **global EQ** to instrument families (drums, guitars, keys, vocals)

* Apply **global compression** to control mix balance

* Enable **parallel compression** (drums, vocals)

* Improve consistency and clarity

* Reduce fader chaos and operator error

* Support easier handoff to volunteers

---

## **Available Resources on WING**

* **16 Mix Buses**, all **stereo by default**

* No linking required (unlike X32)

* Stereo buses can accept mono or stereo sources transparently

---

## **Example Subgroup Layout**

| Bus | Purpose |
| ----- | ----- |
| Bus 1 | Drums |
| Bus 2 | Drum Parallel |
| Bus 3 | Bass |
| Bus 4 | Guitars (Electric \+ Acoustic) |
| Bus 5 | Keys |
| Bus 6 | Tracks |
| Bus 7 | Vocals |
| Bus 8 | Vocal Parallel |

Additional buses may be added for orchestration, brass, etc.

---

## **Step 1: Configure Mix Buses as Subgroups**

For each selected Mix Bus:

1. Press **Bus Master**

2. Select the bus

3. Assign:

   * Name

   * Color

   * Icon

4. Set **Bus Mode \= Subgroup**

**Subgroup Mode Behavior**

* Preserves channel fader levels and pan

* Stereo imaging remains intact

* Acts as a summing point before Main L/R

---

## **Step 2: Assign Subgroups to Main L/R**

For each subgroup:

* Enable send to **Main L/R**

* Set send level to **0 dB**

Result:  
 All subgroup audio flows to Main L/R evenly and predictably.

---

## **Step 3: Assign Channels to Subgroups (Sends on Fader)**

1. Select a subgroup

2. Press **Sends on Fader**

3. Unmute channels that belong to that subgroup

### **Example Assignments**

* **Drums:** All drum channels

* **Drum Parallel:** All drums **minus cymbals/overheads**

* **Bass:** Bass guitar (and sub synths if present)

* **Guitars:** Electric \+ acoustic guitars

* **Keys:** All keyboard channels

* **Tracks:** All playback tracks

* **Vocals:** All vocal channels

* **Vocal Parallel:** All vocals

Exit Sends on Fader when finished.

---

## **Step 4: Remove Channels from Main L/R**

For every channel routed to a subgroup:

* Go to **Main Sends**

* Disable send to **Main L/R**

This ensures **only subgroup outputs** reach the Main bus.

---

## **Step 5: Gain Structure Check**

* Set all subgroup faders to **0 dB**

* Confirm meters show signal

* Audio will only pass once subgroup faders are raised

Parallel buses (Drum Parallel, Vocal Parallel) should remain **lower than 0 dB** and blended in later.

---

## **Global EQ via Subgroups**

* Select a subgroup

* Enable EQ

* Apply tonal shaping to **all channels in that group**

* Channel-level EQ remains intact underneath

Example use:

* Cut 200 Hz on all keys at once

* Shape guitars globally without touching individual channels

---

## **Mix Bus Compression Strategy**

### **Standard Bus Compression**

* Compressor: **SOUL BUS COMP**

* Default settings (recommended):

  * Ratio: **3:1**

  * Attack: **10 ms**

  * Release: **Auto**

  * Threshold: start at **−15 dB**

Apply the same compressor and settings to:

* Drums

* Bass

* Guitars

* Keys

* Tracks

---

### **Vocal Priority Trick (Auto-Mix Feel)**

* Set **Vocal Bus threshold 2 dB higher** than other buses  
   Example:

  * Band buses: −15 dB

  * Vocal bus: −13 dB

Result:

* Vocals stay **slightly louder than the band**

* Improves intelligibility and lyric clarity automatically

---

## **Latency Advantage on WING**

* Channel and bus compressors are **built-in**

* No additional latency from emulations (1176, dbx160, etc.)

* Safe to use different compressor models across buses

* No phase issues between parallel and main buses (when done correctly)

---

## **Parallel Drum Processing (Summary)**

* Heavy compression on Drum Parallel bus

* Fast attack, fast release

* EQ after compression:

  * \+3 dB @ \~150 Hz

  * \+3 dB @ \~10 kHz

  * − cut around 400 Hz

* Blend in **slowly** under main drum group

* Goal: sustain, weight, impact—not volume

---

## **Parallel Vocal Processing (Summary)**

* Compressor: **1176-style**

* All-buttons mode

* Heavy gain reduction (9–10 dB)

* Blend subtly under main vocal group

* Adds density and consistency

---

## **System Tradeoffs**

* Subgroups consume Mix Buses

* If WING is also handling monitors:

  * Fewer buses available for IEMs/wedges

* Recommended minimum subgroup setup:

  * Drums

  * Drum Parallel

  * Band

  * Vocals

Best use cases:

* Broadcast

* FOH with separate monitor desk

* FOH with P16 system

---

## **Final Takeaways**

* Subgroups provide control, clarity, and consistency

* Parallel buses enhance impact without destroying dynamics

* Uniform bus compression creates mix cohesion

* Slight vocal bias ensures intelligibility

* If compression becomes audible, **back off**

# **Behringer WING — Channel Effects Overview**

## **Input Channels vs Aux Channels**

### **Scope**

This document outlines the **effects and processing available on WING channels**, covering:

* **Input Channels 1–40**

* **Aux Channels 1–8** (functionally Channels 41–48)

The focus is on **what processing blocks exist**, **what models are available**, and **how input and aux channels differ**.

---

## **Channel Types on WING**

### **Input Channels (1–40)**

Full-featured processing channels with:

* Gate / Expander section

* EQ section

* Dynamics / Compressor section

* **Two insert points** (from the 16-slot FX rack)

* Pan / Width

* Full routing flexibility

### **Aux Channels (1–8)**

Reduced-function channels intended for:

* FX returns

* Playback devices

* External sources

Aux channels have **limited processing**, detailed later.

---

## **Input Channel Processing Blocks (Channels 1–40)**

### **1\. Gate Section (Selectable Models)**

Each input channel includes **one gate slot**, but you may choose from multiple models:

Available gate-related models include:

* WING Gate / Expander

* Additional gate / expander variants

* Ducker

* De-Esser (highly regarded, but replaces the gate)

* Limiters (gate-slot based)

* Auto Rider (acts like automatic level control)

* Warm Preamp model

**Important tradeoff:**  
 You must choose **one** model per channel—using a de-esser means you forgo a traditional gate.

---

### **2\. EQ Section**

#### **Default EQ**

* **6-band parametric EQ**

* Plus **low and high shelving bands**

#### **Filters**

* Dedicated **Low Cut (HPF)** and **High Cut (LPF)**

* Separate **Tilt EQ** function

#### **Additional EQ Models**

* Multiple **analog-modeled EQs** available as alternatives to the standard WING EQ

* These replace the default EQ when selected

---

### **3\. Dynamics / Compressor Section**

Each channel includes **one dynamics slot**, with many selectable models:

Available options include:

* WING Compressor (advanced, multi-feature)

  * Crossover mode

  * Key filter

  * Key source

* WING Expander

* dbx-style compressor

* Multiple analog-modeled compressors

* Limiters

* NO-STRESSOR

* Auto Rider (also available here)

All controls use **touch-sensitive encoders** for detailed feedback.

---

### **4\. Insert FX (Two Per Channel)**

Each input channel provides:

* **Insert FX 1**

* **Insert FX 2**

Both inserts can load **any processor from the 16-slot FX rack**, including:

* Reverbs

* Delays

* Modulation

* Pitch effects

* Specialty processors

These inserts give substantial flexibility for per-channel effects.

---

### **5\. Routing Order (Rearrangeable)**

Most channel processing blocks can be **reordered**:

* Gate

* EQ

* Compressor

* Insert FX 1

**Exception:**

* The **last insert (Insert FX 2\)** cannot be moved.

This allows custom signal-flow designs per channel.

---

## **Aux Channel Processing (Channels 41–48)**

Aux channels have **reduced functionality** compared to input channels.

### **Aux Channel Includes:**

* Input

* Dynamics / Compressor (limited selection)

* EQ

* **Single insert**

* Main routing

### **Aux Channel Limitations:**

* **No Gate**

* **Only one Insert FX**

* EQ is reduced:

  * 4-band total

  * 2 parametric \+ 2 shelving

* **No Low Cut or High Cut filters**

* No second insert

* Less routing flexibility

These limitations are intentional, reflecting the aux channel’s role as a utility input rather than a full production channel.

---

## **Key Takeaways**

* Input channels (1–40) are **fully featured**

* Aux channels (1–8) are **intentionally simplified**

* Each input channel has:

  * Selectable gate models

  * Multiple EQ and compressor models

  * Two FX inserts

  * Flexible processing order

* Aux channels sacrifice depth for efficiency

* Choosing certain processors (e.g., de-esser) replaces others (e.g., gate)

# **WING-LIVE SD Card Recording**

## **Basic Format & Routing — Quick WING Tips**

### **Purpose**

This guide explains how to **format an SD card** and **route signals to the WING-LIVE SD recorder**, including the two available recording methods: **direct preamp (dry)** and **User Signal (processed)** recording.

---

## **Accessing the SD Recorder**

* Press the **SD Card icon** at the top of the WING screen

* This opens the **SD Card Control** page

* Existing sessions can be deleted from this screen

---

## **SD Card Requirements (Critical)**

To ensure reliable operation, use:

* **Class 10 SD card**

* **Maximum size: 32 GB**

* **Formatted as FAT32**

Larger cards may work, but are **not recommended** if you want to avoid issues.

---

## **Formatting the SD Card**

* Formatting is available in the **Settings** section of the SD Card page

* Format the card **inside the WING** before recording

---

## **Track Count Configuration**

On the SD Card page, select how many tracks to record:

* Options include **8, 16, or 32 tracks**

* If you select **32 tracks**:

  * WING will always create a **32-track WAV file**

  * Unused tracks will be recorded as **blank**

  * This consumes more storage

Most users will record **32 tracks** for flexibility.

---

## **Recording Basics**

* Once formatted and configured, recording is as simple as pressing **Record**

* The critical step is deciding **what signal is sent to the SD card**

---

## **Routing Signals to the SD Card**

### **Step 1: Open Routing**

* Go to **Routing → Outputs**

* Unlock the patch

* Select **WING-LIVE Rack**

* WING supports **two SD cards**, allowing up to **64 channels** of recording

---

## **Two Recording Methods**

### **Option 1: Direct Preamp Recording (Dry / Non-Destructive)**

* Route **Direct Preamp** signals to the SD card

* Records:

  * Raw input signal

  * No EQ, compression, gate, or effects

* Ideal for:

  * Post-production flexibility

  * Safety and reliability

  * Virtual soundcheck

**Recommended approach for most users**

---

### **Option 2: User Signal Recording (Processed / Destructive)**

* Uses **User Signals** (limited to **24 channels**)

* Can record **post-processing** signals:

  * EQ

  * Gate

  * Compression

  * Full channel strip processing

* Requires an **additional routing step**

#### **Routing User Signals**

1. Assign **User Signal outputs** to the SD card

2. Go to **Source → User Signal**

3. Assign a source to each User Signal:

   * Channel

   * Aux

   * Bus

   * Main

   * Matrix

If a **channel** is assigned:

* Everything done on that channel strip affects the recording

---

## **Important Warning: Destructive Recording**

* User Signal recording is **destructive**

* Mistakes in EQ, dynamics, or gain **cannot be undone**

* What you hear on the channel is **exactly what is recorded**

This method can be useful:

* If you are confident in your processing

* To save time in post-production

* When you only need level balancing in a DAW

But it must be used **carefully**.

---

## **Best Practice Recommendation**

* **Record direct preamps whenever possible**

* Use dry recordings to:

  * Apply EQ, compression, and effects later

  * Avoid irreversible mistakes

  * Maintain maximum flexibility

---

## **Summary**

* SD recording on WING is simple and reliable when configured correctly

* Use:

  * Class 10, 32 GB, FAT32 SD cards

* Choose track count carefully

* Prefer **direct preamp recording** for safety

* Use **User Signals** only when confident and intentional

## **EXAMPLE Design & Setup for a Small (7–8 Piece) Band**

### **Overview**

This document explains a **custom WING Rack setup** designed for a **7–8 piece cover band (plus occasional guests)**. The system prioritizes:

* Fast setup and teardown

* Reliability

* Minimal stage cabling

* Wired in-ear monitoring

* Operation by **any band member**, not just the system designer

The setup replaces a previous **X32 Rack** system and reflects professional audio design principles.

---

## **Design Philosophy**

### **Core Goals**

* **Simplicity:** Any band member can set up and operate the system

* **Speed:** Entire rig can be deployed in \~15 minutes

* **Consistency:** Repeatable setup across rehearsals and shows

* **Low stage volume:** Full in-ear monitoring

* **Minimal dependencies:** One power outlet when possible

The system is intentionally overbuilt for a cover band, reflecting the designer’s background as a professional sound engineer.

---

## **Band & Input Overview**

Typical inputs include:

* Bass

* Three guitars

* Keyboard

* Drums (kick, snare, tom, floor, overheads)

* Lead vocal

* Guest inputs (e.g., saxophone, percussion)

* Two spare auxiliary inputs

---

## **EtherCON-Based Stage Connectivity**

### **Pedalboard Stations**

Each musician’s pedalboard connects via **EtherCON**, carrying:

* Instrument signal

* Vocal microphone

* Stereo in-ear return

Planned final state:

* **One EtherCON \+ one PowerCON** per station

* Cables taped together for fast deployment

* Entire stage powered from the rack

### **Current State**

* Bass station fully complete

* Guitar stations functional but still evolving

* Keyboard and guest stations planned

---

## **Wired In-Ear Monitoring Strategy**

### **Rationale**

* Wireless IEMs are expensive, complex, and unnecessary for stationary musicians

* Wired IEMs:

  * No batteries

  * No RF coordination

  * Lower cost

  * Higher reliability

### **Hardware Choice**

* **Behringer MA400** headphone amp at each pedalboard

* Custom combo cable:

  * Instrument line

  * Stereo headphone extension

* One cable replaces separate instrument \+ IEM lines

### **Signal Flow (Example: Bass)**

1. Instrument → HX Stomp

2. HX Stomp → EtherCON → Mixer

3. Mixer → Stereo IEM return → EtherCON → MA400

4. MA400 → Combo cable → Bassist

Setup time: \~90 seconds per musician

---

## **Drum Inputs**

* Drum microphones connect **directly** to the rack

* Mixer is physically located near the drum kit

* Reduces cable runs and setup complexity

---

## **Rack Networking & Control**

### **Internal Network**

* Internal **UniFi Express** 5-port switch

* Used for:

  * Mixer control

  * Phones/tablets for personal mixes

  * Computers for prep and configuration

### **Internet Access**

* Rack can be connected to:

  * Rehearsal space network

  * Home network

* Allows:

  * Mixer control

  * Internet access simultaneously

### **USB-C Expansion**

* USB-C extension to front panel

* Dock provides:

  * HDMI

  * Ethernet

  * USB

  * Power delivery

* Used for laptops, phones, and prep work

---

## **Outputs & Labeling**

### **Output Strategy**

* Outputs labeled by **function**, not channel number

* Avoids relabeling when setup changes

Example outputs:

* Main speakers (L/R)

* Subs

* Spare wedges

* Guest monitoring

* Individual IEM feeds (drummer, singer, keyboardist)

---

## **GPIO & Footswitch Integration**

### **GPIO Usage**

* GPIO ports extended to front panel

* Converted to XLR for durability and distance

### **Footswitch Design**

* Multiple footswitches can trigger the same action

* Used for:

  * Talkback

  * Other control functions

* Separate video planned for detailed explanation

---

## **Rack Power Design**

### **Power Philosophy**

* Entire rig powered from **a single PowerCON input**

* Certified electrician assesses when PA needs a separate outlet

### **Internal Power Distribution**

* 100W USB power supply inside rack powers:

  * UniFi access point

  * Network switch (via USB-C trigger)

  * LED lighting

  * USB-C expansion

  * Device charging (phones, laptops)

### **LED Lighting**

* Internal LED lights for visibility in dark venues

* Improves troubleshooting and setup accuracy

---

## **Internal Wiring**

* Uses inexpensive **8-channel multicore cables**

* Cables split internally to reduce connector count

* All internal connections remain plugged in

* Rack can be closed fully while wired

---

## **Guest & Expansion Handling**

* Guest station planned for:

  * Saxophone

  * Percussion

  * Additional musicians

* Dedicated EtherCON \+ PowerCON planned

* Spare buses and inputs reserved

---

## **Advantages of This Approach**

* Extremely fast setup

* Minimal cabling on stage

* Reliable wired IEMs

* No RF issues

* Easy operation by non-engineers

* Scales well for guests

* Clean, repeatable workflow

---

## **Limitations & Tradeoffs**

* Consumes many mixer inputs and buses

* Requires planning and labeling discipline

* Wired IEMs limit movement (acceptable for this band)

---

## **Summary**

This WING Rack system is a **purpose-built, professional-grade solution** for a small band that values:

* Speed

* Reliability

* Simplicity

* Clean stage aesthetics

* Consistent monitoring

It demonstrates how thoughtful system design can eliminate common live-sound pain points without unnecessary complexity or expense.

## **Using WING Rack as a Dedicated In-Ear Monitor (IEM) Mixer**

### **Setup, Routing, and Expansion Options**

---

## **Purpose**

This guide explains how to configure the **Behringer WING Rack** as a **dedicated in-ear monitor console**, including:

* Console initialization and core settings

* Monitor bus configuration

* Input and output routing

* Stereo vs mono monitor mixes

* Hardware rack build considerations

* Expansion using **Midas StageConnect** and **AES50**

The WING Rack is especially well suited for IEM rigs due to its **24 local preamps**, **8 local outputs**, and full WING feature set.

---

## **Platform Overview**

* WING Rack uses the **same GUI and routing concepts** as the full-size WING

* **WING Edit software** mirrors the console UI and workflow

* All steps apply equally to:

  * Touchscreen

  * WING Edit (computer)

---

## **Step 1: Initialize the Console**

Starting from a clean state avoids hidden issues.

1. Go to **Setup → General**

2. Select **Initialize**

3. Choose **All**

4. Confirm **Initialize**

This resets the console to a known baseline.

---

## **Step 2: Global Audio Settings**

In **Setup → Audio**:

* Set **Solo System \= Live**

* Disable **Auto Mixing** (conference-oriented feature)

These settings are more appropriate for live monitor use.

---

## **Step 3: Understanding Bus Architecture**

### **WING Bus Structure**

* **16 stereo buses**

* Any bus can be used as:

  * Stereo

  * Mono

* Unlike X32/M32, no bus linking is required

### **Default Bus Modes**

* 8 buses: **Tap Point**

* 2 buses: **Subgroup**

* 6 buses: **Post-Fader** (commonly FX)

For a **dedicated monitor console**, subgroups are typically unnecessary.

---

## **Step 4: Converting Subgroups to Monitor Buses**

To increase monitor mixes:

1. Select a subgroup bus

2. Change mode to **Tap Point**

3. Disable send to **Main L/R**

4. Rename and recolor as needed

This instantly creates additional monitor mixes.

---

## **Output Limitations (Local Only)**

Without expansion:

* **8 local outputs total**

* Supports:

  * 4 stereo IEM mixes

  * OR 8 mono IEM mixes

  * OR any combination totaling 8 outputs

This is sufficient for many bands:

* 4 musicians with stereo IEMs

* OR 8 musicians with mono IEMs

---

## **Step 5: Mono vs Stereo Monitor Buses**

* Buses default to **stereo**

* Any bus can be switched to **mono**

Example configuration:

* Mix 1–6: Mono

* Mix 7: Stereo

* Mix 8: Unused

---

## **Step 6: Physical Output Routing**

1. Go to **Routing → Outputs**

2. Unlock routing

3. Enable **\+1 (Auto-Advance)** for faster patching

4. Set **Source \= Buses**

### **Stereo Bus Assignment Example**

* Assign **Bus 7 Left → Output 7**

* Assign **Bus 7 Right → Output 8**

Main L/R outputs are not required for a monitor-only console.

---

## **Step 7: Input Routing Basics**

* 24 local inputs are routed sequentially to channels by default

* Works identically to full-size WING

---

## **Stereo Sources on a Single Channel**

WING channels can be **mono or stereo**.

Example: Stereo keyboard on Channel 11

1. Select Channel 11

2. Choose **Local Input 11**

3. Enable **Stereo**

4. Assign **Local Input 12** automatically

5. Reassign following channels to shift inputs forward

Result:

* One stereo fader

* No wasted channel strips

---

## **Step 8: Monitor Bus Levels**

* Set all monitor bus master faders to **Unity (0 dB)**

* Example:

  * Buses 1–6: Mono monitors

  * Bus 7: Stereo monitor

  * Bus 8: Unused

---

## **Step 9: Channel Sends & Tap Points**

### **Sends on Fader**

* Use **Sends on Fader** to adjust monitor mixes

* Works on:

  * Console

  * WING Edit software

### **Tap Point Selection**

* Tap points determine **where the signal is sourced** from the channel

* For a dedicated monitor console:

  * **Tap Point 5 (post-dynamics)** is a solid default

* FOH changes will not affect monitors if gains are handled correctly

---

## **Step 10: Hardware Requirements for Monitor Consoles**

### **The Need for a Splitter**

A monitor console requires a way to split inputs between:

* Monitor console

* Front-of-house console

---

## **Option A: Analog Splitter Snake**

### **Example Used**

* 24-channel analog splitter

* Two tails:

  * 5 ft tail → WING Rack

  * 30 ft tail → FOH snake

### **Best Practices**

* Bundle tails in groups of four

* Label tails by **source**, not channel number

* Label performers by **stage position**, not name

Advantages:

* Fully independent of console power

* FOH unaffected if monitor console fails

---

## **Option B: Midas StageConnect Boxes**

### **Capabilities**

* Provide:

  * Line-level inputs (no preamps)

  * Large numbers of outputs

* Two boxes (DN4880 \+ DN4888) can add:

  * **24 additional outputs**

  * **8 line-level inputs**

### **Connections**

* Single XLR (DMX-style) cable

* WING Rack can power **one** StageConnect box

* Additional boxes require external PSU

---

## **StageConnect as a Digital Splitter**

### **Configuration**

* Route **Local Inputs 1–24 → StageConnect Outputs 1–24**

* FOH receives signal from StageConnect

### **Important Considerations**

* StageConnect relies on WING Rack preamps

* Monitor gain changes affect FOH

* Mitigation strategy:

  * Set input **gain conservatively**

  * Use **trim** for monitor adjustments

⚠ If WING Rack loses power, FOH signal is lost  
 (Unlike analog splitters)

---

## **StageConnect for Output Expansion (Recommended Use)**

StageConnect excels at:

* Adding monitor outputs

* Enabling more stereo IEM mixes

One box can add:

* 8–16 additional outputs (model-dependent)

---

## **Routing StageConnect Outputs (Software)**

1. Go to **Routing → Outputs**

2. Select **StageConnect**

3. Choose **Bus** as source

4. Assign buses sequentially

   * Stereo mixes require two outputs (L/R)

5. Unassigned outputs remain available for other uses

---

## **StageConnect Switch Settings**

* All switches **left**

* WING Rack \= **Master**

* StageConnect \= **Slave**

* Individual mode (no shared outputs)

---

## **Additional Expansion**

* **AES50** supported

* Add Behringer or Midas stageboxes for:

  * More preamps

  * More outputs

---

## **Alternate Rack Configuration Example**

* Compact rack for dual FOH \+ monitor use

* Local outputs brought to front via XLR pass-through panel

* Allows:

  * Easy patching to IEM racks

  * Wedges

  * Amps

  * Wired belt packs

---

## **Key Takeaways**

* WING Rack is exceptionally capable as an IEM mixer

* Stereo buses simplify monitor workflows

* Analog splitters offer maximum safety

* StageConnect offers compact, flexible expansion

* Gain vs trim management is critical in digital splits

* Output expansion is where StageConnect shines most

---

# **WING Output Patching**

## **Creating a Direct Output Split (Analog-Style Pass-Through)**

### **Purpose**

This workflow demonstrates how to **patch console outputs directly from stagebox inputs**, effectively creating a **digital equivalent of an analog split**. This is useful when a band or external IEM system needs **raw microphone signals** directly from the stagebox, independent of channel processing.

---

## **Use Case**

* A band is on stage with:

  * Their own **in-ear monitor rig**

  * A **split** requirement

* They want:

  * **Unprocessed mic signals**

  * Directly from a **DL32 stagebox**

  * Without EQ, compression, or console processing

---

## **Concept**

Instead of routing:

`Input → Channel → Bus → Output`

We route:

`Stagebox Input → Output`

This mirrors the behavior of an **analog splitter**.

---

## **Step-by-Step: Direct Input-to-Output Patch**

### **1\. Open Output Routing**

* Navigate to **Routing → Outputs**

* Select the output you want to configure  
   (e.g., Outputs **1–4** on a DL32)

---

### **2\. Select the Source**

* Open the **source dropdown** for the selected output

* Choose:

  * **AES50 Input 1** (or the corresponding stagebox input)

---

### **3\. Result**

* **XLR Input 1** on the DL32 is now:

  * Routed **directly** to the selected output

  * Completely bypassing:

    * Channel strip

    * EQ

    * Dynamics

    * Buses

* The signal leaving the output is:

  * **Raw**

  * **Unprocessed**

  * **Low-latency**

Repeat this process for:

* AES50 Input 2 → Output 2

* AES50 Input 3 → Output 3

* AES50 Input 4 → Output 4

---

## **Practical Applications**

* Feeding an **external IEM rack**

* Providing a **clean split** to another console

* Redundant or backup signal paths

* Festival or guest-engineer workflows

---

## **Key Takeaways**

* WING can create **analog-style splits digitally**

* Direct patching avoids:

  * Gain staging conflicts

  * Processing coloration

* Outputs can source directly from:

  * Stagebox inputs

  * Without consuming channels or buses

# **Behringer WING Routing Deep Dive**

## **Channels, Sources, Outputs, Recording, Alternate Inputs & User Signals**

---

## **Purpose**

This document explains the **full routing philosophy of the Behringer WING**, including:

* Channels vs Sources vs Outputs

* Stagebox (AES50) routing

* Stereo channel handling

* Output patching

* USB, WING-LIVE, and DAW recording

* Alternate inputs & virtual soundcheck

* User Signals for advanced routing

* Digital “analog-style” splits

---

## **Core Mental Model (Critical)**

### **Three Concepts You Must Understand**

| Term | Meaning |
| ----- | ----- |
| **Channels** | Mix channels (faders) you process and mix |
| **Sources** | Where audio comes from (Local, AES50, USB, StageConnect, User Signal, Oscillator, etc.) |
| **Outputs** | Final destinations (XLRs, USB audio, SD card, StageConnect, etc.) |

Routing always means **assigning a Source to a Channel**, or **assigning a Source to an Output**.

---

## **Routing Page Orientation**

* Access via **Routing** button

* Think **right → left**:

  * Right \= Sources

  * Left \= Channels or Outputs

* Routing is protected by a **Lock / Unlock** safety system

* **Plus One Auto** automatically advances selections and speeds patching

---

## **Channels Overview**

* 48 total mix channels (40 input \+ 8 aux)

* Channels are **stereo-capable**

* Sources are **always mono per XLR**

* Stereo channels are created by pairing two mono sources

---

## **Source Categories**

Available source groups include:

* Local Inputs

* Aux Inputs

* AES (single-XLR digital)

* **AES50 (stageboxes)**

* StageConnect

* USB Audio

* WING-LIVE (SD)

* USB Player

* Oscillator (pink noise, white noise, sine)

* **User Signals** (advanced)

### **Source Page Features**

* Rename sources

* Color-code

* Assign icons

* Mono / Stereo pairing (odd-even)

* Mid/Side pairing

* Headamp remote control

---

## **Channel Patching (Primary Workflow)**

### **Best Practice**

Patch directly from the **Channels page**, not the Sources page.

### **Steps**

1. Unlock routing

2. Select a channel (left)

3. Select a source (right)

4. Choose:

   * Mono

   * Stereo

   * Mid/Side

5. Use **Plus One Auto** to patch sequentially

---

## **Stereo Channels (Key Advantage of WING)**

* One stereo channel \= two input sources

* Example:

  * Local In 1 \+ 2 → Channel 1 (Stereo)

* The **next channel** can be reassigned to Local In 3

* Channel numbers no longer equal input numbers

Scribble strips always show the **actual source**, so numbering mismatches are safe.

---

## **AES50 (Stagebox) Patching**

* Stagebox inputs appear under **AES50 A/B/C**

* Can be patched to **any channel**

* No block-of-8 restrictions (unlike X32/M32)

Example:

* AES50 A17 → Channel 24 (Talkback)

---

## **Oscillator & Noise**

* Available **only in the Sources page**

* Types:

  * Pink noise

  * White noise

  * Sine wave

* After configuring:

  * Patch oscillator to any channel

* Used for:

  * Testing signal flow

  * PA tuning

---

## **Output Routing (Same Logic as Channels)**

### **Concept**

* Left side \= Physical destination

* Right side \= What you send there

* Always think **right → left**

### **Default Behavior**

* Outputs 1–6: Monitor buses

* Outputs 7–8: Main L/R

---

## **Stereo Outputs**

* Stereo buses require:

  * Left → Output X

  * Right → Output X+1

Example:

* Main L → Out 1

* Main R → Out 2

Mono buses can use either left or right tap.

---

## **Recording Workflows**

### **USB Stick Recorder (4-track)**

* Destination: **USB Recorder**

* Patch:

  * Main L/R → USB 1–2

* Records a single stereo mix

---

### **WING-LIVE SD Card Recording**

* Destination: **WING-LIVE Record**

* **Nothing records unless patched**

* Common use: raw multitrack

#### **Recommended**

* Patch **Local or AES50 preamps directly**

* Non-destructive

* Ideal for:

  * Virtual soundcheck

  * Post mixing

---

### **USB / DAW Recording**

* Destination: **USB Audio**

* DAW inputs appear as USB 1, USB 2, etc.

⚠️ **Critical Warning**  
 If using a stagebox:

* You MUST patch **AES50 sources**

* Otherwise you will record **console local pres**

* Result: silent tracks in your DAW

---

## **Alternate Inputs (ALT) & Virtual Soundcheck**

### **ALT Input Concept**

Each channel has:

* **Main input**

* **Alternate input**

Can switch globally or per-channel.

---

### **Virtual Soundcheck Workflow**

1. Record show via USB or WING-LIVE

2. Patch playback sources to **ALT inputs**

3. Enable **Global Input Select**

4. Toggle **Main ↔ Alt**

Result:

* Channels replay recorded tracks

* Full processing intact

* No band required

---

### **ALT Inputs for Redundancy (Show-Saver)**

* Main: wireless mic

* Alt: wired backup mic

* Switch instantly on the **same channel**

* No extra fader

* No copying EQ or compression

Also useful for:

* Mic comparisons

* A/B testing

---

## **User Signals (Advanced Power Feature)**

### **What User Signals Do**

* Create **custom virtual sources**

* Break odd/even pairing rules

* Allow:

  * Post-fader recording

  * Post-processing recording

  * Bus & matrix recording

  * Stereo re-mapping from arbitrary inputs

---

### **User Signals – Bottom Section (Re-Mapping)**

Example:

* Keys L on AES50 18

* Keys R on AES50 19 (not odd/even)

Steps:

1. Create User Signal

2. Set stereo

3. Assign Left \= AES50 18

4. Assign Right \= AES50 19

5. Rename & color

6. Patch User Signal to channel

---

### **User Signals – Top Section (Post Processing Recording)**

Can source from:

* Channels

* Buses

* Mains

* Matrices

Includes options:

* Pre / Post fader

* Left / Right separation

Example:

* Kick → Post-fader → User 1

* Snare → Post-fader → User 2

* Keys L → User 9

* Keys R → User 10

Then:

* Patch User Signals → USB Audio or WING-LIVE

Result:

* Processed multitrack recordings

* Or bus stems (e.g., Drum Bus L/R)

---

## **Digital “Analog-Style” Split (Direct Passthrough)**

### **Purpose**

Provide raw mic signals to another system **without an analog splitter**.

### **How**

1. Routing → Outputs

2. Select AES50 Output

3. Source \= AES50 Input (same number)

Example:

* AES50 In 1 → AES50 Out 1

* AES50 In 2 → AES50 Out 2

* etc.

### **Result**

* Raw mic signals

* No EQ, compression, or buses

* Possible gain included (preamp-dependent)

Use:

* External IEM rigs

* Secondary consoles

* Festival splits

---

## **Key Takeaways**

* Routing \= assigning **sources to destinations**

* Channels are stereo; sources are mono

* AES50 must be patched explicitly for recording

* ALT inputs enable:

  * Virtual soundcheck

  * Backup mics

* User Signals unlock:

  * Advanced recording

  * Custom stereo mapping

  * Post-processing capture

* WING can digitally replace analog splitters

---

# **Behringer WING Virtual Soundcheck**

## **Using the WING-LIVE Expansion Card**

---

## **Purpose**

This guide explains how to perform a **virtual soundcheck** on the Behringer WING using the **WING-LIVE SD card expansion**, allowing you to:

* Record a rehearsal or show

* Play it back through the console

* Mix as if the band were on stage

* Switch instantly between live inputs and playback

---

## **WING-LIVE Expansion Card Overview**

### **Hardware**

* Two SD card slots

* Accepts **SDHC cards**

* **Class 10 or faster required**

* Recommended size: **32 GB**

### **Recording Capacity**

* **32 channels per SD card**

* Cards can be **linked** for:

  * **64-channel recording**

* If unlinked:

  * Card 1 \= 32 channels

  * Card 2 \= 32 channels

---

## **SD Card Preparation**

### **Formatting (Required)**

1. Insert SD cards

2. Open **WING-LIVE page**

3. Go to **Settings**

4. Format **each card individually**

5. Start with blank cards before recording

---

## **Recording Format & Limits**

* Records **32-channel WAV files**

* Sample rate matches console setting (e.g. 48 kHz)

* Playback requires the console to be set to the **same sample rate**

* Approx. **1 hr 25 min** of recording time on two linked 32 GB cards at 48 kHz

* Files can be extracted into individual tracks using Behringer tools

---

## **Preparing for Virtual Soundcheck (Routing Strategy)**

### **Key Principle**

You must **duplicate your channel input routing** to the WING-LIVE recorder.

The recorder captures whatever is patched to it — nothing records unless explicitly routed.

---

## **Routing Audio TO the WING-LIVE Recorder**

1. Go to **Routing → Outputs**

2. Select **WING-LIVE Record**

3. Unlock routing

4. For each record channel:

   * Assign the **same source** used by the channel

   * Examples:

     * USB Audio

     * AES50 (stagebox)

     * Local inputs

5. Use **Plus One Auto** to speed patching

⚠️ If using a stagebox, you **must patch AES50 inputs**, or recordings will be silent.

---

## **Recording a Session**

1. Go to the **WING-LIVE page**

2. Confirm meters are moving

3. Press **Record**

4. Play audio or run rehearsal

5. Press **Stop** to finalize the session

---

## **Playback Routing for Virtual Soundcheck**

### **Why ALT Inputs Matter**

Each channel has:

* **Main input** (live stage)

* **ALT input** (playback source)

Using ALT inputs allows instant switching between:

* Live show

* Virtual soundcheck

---

### **Routing Playback to ALT Inputs**

1. Go to **Routing → Channels**

2. Select **ALT input** (not Main)

3. Choose **WING-LIVE Playback**

4. Unlock routing

5. Use **Plus One Auto** to patch sequentially

---

## **Switching Between Live & Playback (Global ALT)**

1. Press **Setup → Audio**

2. Set **Input Select \= ALT**

   * All channels switch to playback

3. Press **Play** on WING-LIVE

4. Mix normally (solo, EQ, compression, etc.)

5. When finished:

   * Switch **Input Select \= MAIN**

   * Console returns to live stage inputs

---

## **Markers & Navigation (WING-LIVE Playback)**

### **Markers**

* Can be added during playback

* Useful for:

  * Verses

  * Choruses

  * Specific problem sections

* Jump instantly to any marker

### **Playback Positioning**

* After stopping playback, you can:

  * Manually set time position

  * Create additional markers

  * Loop specific sections

---

## **Recording Signal Path (Important Limitation)**

* WING-LIVE records **directly from inputs**

* Recording is:

  * **Pre-EQ**

  * **Pre-compression**

  * **Pre-fader**

* Processing changes do **not** affect the recording

### **Why This Is Good**

* Non-destructive

* Safe to experiment during virtual soundcheck

* Ideal for dialing in PA and monitor mixes

---

## **Caution When Returning to Live Mode**

* Aggressive EQ or compression adjustments made during playback

* May cause **feedback** when switching back to live inputs

* Always re-check gains and dynamics before the show

---

## **Best Uses for Virtual Soundcheck**

* Preparing for large events

* Mixing in an empty room

* Learning the console without pressure

* Refining PA tuning

* Practicing mixes at home or during downtime

---

## **Summary**

* WING-LIVE enables powerful virtual soundchecks

* Cards must be formatted and routed explicitly

* ALT inputs allow instant live/playback switching

* Recording is always pre-processing

* Markers make rehearsal playback efficient

* Ideal for preparation without a band present

---

## **User Signals, SD Card Recording & Virtual Soundcheck**

---

## **1\. What Are User Signals?**

**User Signals** are **virtual channels** inside the Behringer WING that allow you to:

* Route **channels, buses, mains, or matrices** into a virtual signal

* Forward that signal to:

  * **USB Audio**

  * **WING-LIVE SD card recorder**

* Capture audio **post-fader** and **post-processing**

### **Key Advantage**

User Signals allow you to record the **exact sound of your live mix**, including:

* EQ

* Dynamics

* Inserts

* Fader moves

This is not possible with direct preamp recording alone.

---

## **2\. Routing a Channel to a User Signal**

### **Step-by-Step**

1. Press **Routing**

2. Set **Source Group \= User Signal**

3. Select a **User Signal number**

4. Customize:

   * Name

   * Icon

   * Tags

   * Mono / Stereo / Mid-Side

5. Select **Source** (top-left):

   * Choose source group (Channel, Bus, Main, Matrix)

   * Choose the specific source

6. Select **Tap Point**:

   * Pre-fader

   * Post-fader

---

## **3\. Stereo Behavior in User Signals**

* All WING channels are **stereo**

* User Signals can receive:

  * Left only

  * Right only

  * L+R summed to mono

### **True Stereo Recording**

To record stereo via User Signals:

* Use **two adjacent User Signals**

* Assign:

  * One \= Left

  * One \= Right

* Both use the same source

---

## **4\. Routing User Signals to Outputs**

### **Output Assignment**

1. Go to **Routing → Outputs**

2. Unlock routing

3. Select output destination:

   * USB Audio

   * WING-LIVE Record

4. Set **Source Group \= User Signal**

5. Assign User Signal to output channel

6. Lock routing

---

## **5\. Example Use Case**

Record simultaneously:

* **Raw preamp input** (direct source)

* **Post-fader processed signal** (via User Signal)

This allows:

* Safety recording

* Live mix reference

* Hybrid workflows

---

## **6\. WING-LIVE Expansion Card Overview**

### **Hardware**

* Installed by default

* Two SD card slots

* **32 channels per card**

* **64 channels total** when linked

### **SD Card Requirements**

* Class 10

* 32 GB recommended

* FAT32 formatted

---

## **7\. Formatting SD Cards**

1. Insert SD card

2. Press **SD Card / USB icon**

3. Open **Settings (cog icon)**

4. Format card

5. Card icon:

   * White \= detected

   * Grey \= no card

---

## **8\. Routing Signal to WING-LIVE (Recording)**

### **Important Rules**

* Nothing records unless explicitly routed

* Channels:

  * 1–32 → SD Card A

  * 33–64 → SD Card B

### **Steps**

1. Press **Routing**

2. Select **Outputs**

3. Choose **WING-LIVE Record**

4. Unlock routing

5. Assign sources:

   * Local inputs

   * AES50 stagebox inputs

   * USB Audio

   * User Signals

6. Lock routing

---

## **9\. Recording to SD Card**

1. Open **WING-LIVE page**

2. Press **Record**

3. Recording begins immediately

4. Press **Stop** to end session

5. Press **Folder icon** to view sessions

---

## **10\. Markers & Session Management**

### **Markers**

* Can be added during recording

* Useful for song sections or notes

### **Marker Editing**

1. Select session

2. Press **Arrow icon**

3. Select marker

4. Drag marker to new position

5. Press **Update**

### **Other Management**

* Rename sessions

* Delete sessions

* Delete markers

---

## **11\. Playback for Virtual Soundcheck**

### **Input Routing**

* Playback feeds channels via **WING-LIVE Play**

* Input must be explicitly patched

### **Best Practice**

Use **ALT inputs** for playback:

* MAIN \= live stage

* ALT \= SD playback

This allows instant switching.

---

## **12\. Switching Between Live & Playback**

1. Patch playback to **ALT inputs**

2. Press **Setup → Audio**

3. Switch input selection:

   * MAIN ↔ ALT

4. Mix playback as if band were on stage

5. Switch back to MAIN for live show

---

## **13\. Playback Channel Count**

Always ensure:

* Number of playback channels ≥ number of recorded channels

Mismatch will result in missing audio.

---

## **14\. Why Use ALT Inputs?**

* Instant virtual soundcheck

* No repatching required

* No impact on live routing

* Ideal for rehearsals, prep, and training

---

## **15\. Summary**

* **User Signals** enable post-fader, post-processing recording

* **WING-LIVE** records up to 64 channels

* SD cards must be Class 10, FAT32

* Explicit routing is mandatory

* ALT inputs enable seamless virtual soundcheck

* Markers simplify navigation and rehearsal workflows

---

## **Global Audio Settings Reference**

This document provides a consolidated overview of **Behringer WING global audio settings**, including clocking, input selection, solo behavior, mute logic, and USB audio configuration.

---

## **1\. Audio Clock Settings**

### **Clock Rate (Sample Rate)**

The sample rate defines how many audio samples the console processes per second.

**Common rates:**

* 44.1 kHz – CD audio, many music playback files

* 48 kHz – Standard for live sound and professional production

* Higher multiples (96 kHz, 192 kHz) where supported

**Critical constraints:**

* WING does **not** perform sample-rate conversion

* All connected digital systems must use the **same sample rate**, including:

  * AES50 stage boxes

  * USB-connected computer

  * WING-LIVE SD card recording/playback

  * USB-drive playback/recording

* AES50 stage boxes automatically follow WING’s sample rate if WING is the sync master

**Best practice:**

* Match the sample rate to your recording project

* Choose 44.1 kHz if most playback material is CD-derived

* Choose 48 kHz for live sound and broadcast workflows

---

### **Sync Source (Clock Master)**

The sync source determines which device controls the shared digital clock.

**Typical configurations:**

* **Internal (WING)** – Recommended for most live setups

* **AES50 A/B/C** – Use when another console controls preamps

  * Example: X32 monitors \+ WING FOH

    * X32: Internal clock

    * WING: Sync source \= AES50 A

* **EXP CARD** – Use when clocking from Dante or other expansion cards

* **AES/EBU** – Refers to the 2-channel digital XLR input on the rear panel

**Rule of thumb:**

* The device controlling the **headamps** should usually be the clock master

---

## **2\. Input Select (Main / Alt Inputs)**

### **Dual Input Architecture**

Every input channel supports:

* **Main source** – Live microphones, DIs, playback

* **Alt source** – Multitrack playback, virtual soundcheck, backup inputs

### **Global Input Select**

* Found in **Global Audio Settings**

* Switches **all channels** between Main and Alt

* Ideal for **virtual soundcheck**

### **Per-Channel Input Select**

* Available in each channel’s **Head Amp submenu**

* Allows:

  * Assigning Alt sources

  * Switching individual channels independently

### **Routing-Based Alt Assignment**

To assign multiple Alt inputs at once:

1. Press **ROUTING**

2. Select **CHANNELS**

3. Set **Channel Input \= ALT**

4. Unlock routing

5. Patch Alt sources

---

### **Auto vs Manual Channel Switching**

* **AUTO** – Channel follows global Main/Alt switch

* **MANUAL** – Channel ignores global switch

#### **Firmware ≥ 1.11 Enhancement**

* Channel overview screen (grid icon, lower-left)

* Left side:

  * Manually toggle channels between Main (blue) and Alt (orange)

* Right side:

  * Set Auto vs Manual per channel

* Allows selective global switching (e.g., channels 1–16 only)

---

## **3\. Preferences**

### **Main Link**

* Function currently undocumented / unclear

---

### **DCA Mute Groups**

* When enabled:

  * Muting a DCA mutes all assigned channels

  * Behaves like a mute group

---

### **Mute Group / SIP Override**

Channels can be muted externally by:

* Mute groups

* DCAs

* Solo-in-Place (SIP)

**Override behavior:**

* **Enabled (default):**

  * Pressing MUTE overrides the external mute and unmutes the channel

* **Disabled:**

  * Pressing MUTE manually mutes the channel

  * Channel stays muted even when the external mute is released

Muted channels caused by external sources flash their MUTE button in red.

---

### **Startup Main Mute**

* Mutes the main output on boot

* Strongly recommended to prevent feedback or accidental audio

---

## **4\. Solo System Settings**

### **Exclusive Solo**

* Only one solo active at a time

* Soloing a new channel cancels the previous solo

---

### **Solo Follows Select**

* Selecting a channel automatically solos it

---

### **Select Follows Solo**

* Soloing a channel automatically selects it

---

### **Sends-on-Faders Activates Solo**

* When entering Sends-on-Faders mode:

  * The selected bus is automatically soloed

* Useful for monitor mixing

---

### **Solo Mode Types**

#### **Live**

* Soloing does **not** affect main bus audio

* Recommended for live shows

#### **Studio**

* Behavior undocumented / unclear

#### **Solo-in-Place (SIP)**

* Soloing mutes all other channels

* Destructive solo

* Useful during soundcheck only

* Highly dangerous during live shows

* SIP indicator appears in the status bar when active

---

### **PFL vs AFL**

#### **PFL (Pre-Fader Listen)**

* Ignores fader level

* Ideal for gain staging

* Can use PFL dim level in monitoring settings

#### **AFL (After-Fader Listen)**

* Includes fader level

* Preserves mix balance while soloing

Solo modes can be configured independently for:

* Channels

* Buses

* Mains

* Matrices

---

## **5\. Source Solo (Firmware ≥ 1.11)**

### **Function**

* Allows previewing sources without assigning them to channels

### **Behavior**

* Selecting CH39 or AUX7 automatically configures it as the Source Solo channel

* From the **Sources routing page**:

  * Tap **SRC SOLO**

  * Select a source

  * Audio is routed to the Source Solo channel

### **Use Cases**

* Quickly audition inputs

* Verify stagebox signals

* Preview playback sources

---

## **6\. USB Audio Interface Configuration**

### **USB In/Out Channel Count**

Controls how many USB channels are exposed to a connected computer.

**Available options:**

* 2 in / 2 out

* 8 in / 8 out

* 16 in / 16 out

* 32 in / 32 out

* 48 in / 48 out

**Best practice:**

* Reduce channel count if:

  * Using an older or slower computer

  * Experiencing USB stability issues

---

## **Summary**

* WING requires a **single shared sample rate** across all digital devices

* Clock master selection is critical in multi-console systems

* Dual Main/Alt inputs enable powerful virtual soundcheck workflows

* Firmware 1.11 greatly improves input-source management

* Solo behavior is highly configurable but must be used carefully

* USB audio channel count is adjustable for system stability

---

## **Processing & Effects Models – Comprehensive Reference**

This document consolidates **all per-channel processing models and FX Rack processors** available on the Behringer WING, including known or commonly accepted **analog inspirations**. Where lineage is uncertain, models are noted as *estimated*.

---

## **Global Architecture Notes**

* All processing slots are **model-selectable**

* Most processors are **analog-inspired**

* Channel processing is **zero-latency**

* Many processors appear in **multiple contexts** (channel, bus, FX Rack)

* FX Rack contains **additional processors not available inline**

* AUX channels have **reduced processing availability**

* Firmware **v1.09–v1.12** significantly expanded the processing library

---

# **PART I — PER-CHANNEL PROCESSING**

## **1\. Per-Channel EQ Models**

### **Availability**

* All standard input channels

* **MACH EQ4 is not available on AUX channels**

### **Common EQ Features**

* FFT spectrum display

* Wet/Dry (Mix) control

* High-pass & low-pass filters

### **EQ Models**

| Model | Analog Inspiration |
| ----- | ----- |
| **WING EQ** | Native digital parametric |
| **SOUL ANALOGUE** | SSL Channel Strip |
| **EVEN 88 FORMANT** | Neve 88RS |
| **EVEN 84** | Neve 1073 / 1084 |
| **FORTISSIMO 110** | Focusrite ISA 110 |
| **PULSAR** | Pultec / PuigTec EQs |
| **MACH EQ4** | Mäag EQ4 |

---

## **2\. Per-Channel Gate / Dynamics Models**

### **Slot Type**

* Gate slot (shared with expanders, de-essers, transient tools, specialty dynamics)

### **Gate & Dynamics Models**

| Model | Analog Inspiration |
| ----- | ----- |
| **GATE / EXPANDER** | Native digital |
| **DUCKER** | Digital |
| **SOUL 9000 GATE** | SSL 9000 |
| **EVEN 88 GATE** | Neve 88RS |
| **DRAW MORE 241** | Drawmer DL241 |
| **BDX 902 DEESSER** | dbx 902 |
| **76 LIMITER AMP** | Urei 1176 |
| **LA LEVELER** | Teletronix LA-2A |
| **SOURCE EXTRACTOR** | Neve Portico 545 |
| **WAVE DESIGNER** | SPL Transient Designer |
| **AUTO RIDER** | Digital |
| **SOUL WARMTH PRE** | SSL Channel Strip (preamp coloration) |
| **DYNAMIC EQ** | Native digital |

**Notes**

* De-essing consumes the gate slot

* Some compressors appear here for **pre-compression use**

* Additional models added in firmware **v1.12**

---

## **3\. Per-Channel Compressor Models**

### **Slot Type**

* Dedicated compressor slot

### **Important Limitation**

* **Precision Limiter** is FX Rack–only (not available inline)

### **Compressor Models**

| Model | Analog Inspiration |
| ----- | ----- |
| **WING COMPRESSOR** | Native digital |
| **WING EXPANDER** | Native digital |
| **BDX 160 COMP** | dbx 160 |
| **BDX 560 EASY** | dbx 560A |
| **DRAW MORE COMP** | Drawmer DL241 |
| **RED3 COMPRESSOR** | Focusrite Red |
| **SOUL 9000** | SSL 9000 |
| **SOUL BUS COMP** | SSL 4000 G Bus |
| **EVEN COMP/LIM** | Neve 33609 |
| **ETERNAL BLISS** | Elysia Xpressor |
| **76 LIMITER AMP** | Urei 1176 |
| **LA LEVELER** | Teletronix LA-2A |
| **FAIR KID** | Fairchild 670 |
| **NO-STRESSOR** | Empirical Labs Distressor |
| **PIA2250 RACK** *(v1.12)* | API 2500 |
| **LTA100 LEVELER** *(v1.12)* | Summit Audio TLA-100A |
| **WAVE DESIGNER** | SPL Transient Designer |
| **AUTO RIDER** | Digital |

---

## **4\. Practical Channel Slot Usage**

### **Gate Slot – Best Uses**

* De-essing

* Transient shaping

* Expansion

* Vocal leveling (Auto Rider)

*Only one gate-type processor per channel.*

### **Compressor Slot – Best Uses**

* Tone shaping

* Dynamic control

* Parallel-style compression (via buses)

### **Model Overlap Enables**

* Stacked dynamics (e.g. **LA-2A → 1176**)

* Pre-compression transient shaping

* Vocal riding before compression

---

# **PART II — EFFECTS RACK PROCESSORS**

## **FX Rack Overview**

* Contains **premium processors** not available inline

* Many FX duplicate channel tools with **expanded control**

* Designed for **sends, inserts, parallel chains, and mastering**

---

## **5\. Reverbs**

### **Premium Reverbs**

| FX | Inspiration |
| ----- | ----- |
| **HALL / ROOM / CHAMBER / PLATE / CONCERT / AMBIENCE** | Lexicon 480L |
| **VSS3 REVERB** | TC Electronic VSS3 |
| **VINTAGE ROOM** | Quantec QRS |
| **VINTAGE REVERB** | EMT 250 |
| **VINTAGE PLATE** | EMT 140 |
| **BLUE PLATE** | Lexicon PCM70 |
| **DELAY REVERB** | Lexicon PCM70 |

### **Special Reverbs**

* GATED REVERB

* REVERSE REVERB

* SHIMMER REVERB

* SPRING REVERB – *Pioneer SR-202*

---

## **6\. Modulation & Time-Based FX**

### **Chorus / Modulation**

| FX | Inspiration |
| ----- | ----- |
| **DIMENSION CRS** | TC Electronic 3rd Dimension |
| **STEREO CHORUS** | Boss CE-2 |
| **STEREO FLANGER** | Analog |
| **PHASER** | Analog |
| **TREMOLO PANNER** | Analog |

### **Delay Effects**

| FX | Inspiration |
| ----- | ----- |
| **STEREO DELAY** | Digital |
| **ULTRATAP DELAY** | Korg SDD-3000 |
| **TAPE DELAY** | Roland RE-201 |
| **OILCAN DELAY** | Tel-Ray Ad-N-Echo |
| **BBD DELAY** | Analog |

---

## **7\. Pitch & Vocal FX**

| FX | Inspiration |
| ----- | ----- |
| **STEREO PITCH** | Lexicon PCM70 |
| **DUAL PITCH** | Standard |
| **DOUBLE VOCAL** | iZotope Vocal Doubler |
| **PITCH FIX** | Antares Auto-Tune Pro |

---

## **8\. Dynamics, EQ & Utility FX**

| FX | Inspiration |
| ----- | ----- |
| **GRAPHIC EQ** | Digital |
| **PIA 560 GEQ** | API 560 |
| **TRIPLE DEQ** *(v1.11)* | Dynamic EQ |
| **PRECISION LIMITER** | Digital mastering limiter |
| **2 BAND DEESSER** | SPL 9629 |
| **COMBINATOR** | Multi-FX |
| **SPEAKER MANAGER** *(v1.11)* | System processor |

---

## **9\. Enhancement & Tone Shaping**

| FX | Inspiration |
| ----- | ----- |
| **ULTRA ENHANCER** | Digital |
| **EXCITER** | Aphex Exciter |
| **PSYCHO BASS** | Digital |
| **BODYREZ** | TC Electronic |
| **VELVET IMAGER** *(v1.11)* | Stereo imaging |
| **MOOD FILTER** | Moog |
| **TAPE MACHINE** | Analog tape |

---

## **10\. Bass & Guitar Processing**

### **Bass FX**

* **SUB OCTAVER** – Boss OC-2

* **SUB MONSTER** *(v1.09)* – Midas

### **Amp Modeling**

| FX | Inspiration |
| ----- | ----- |
| **RACK AMP** | Tech 21 SansAmp |
| **UK ROCK AMP** | Marshall |
| **ANGEL AMP** | ENGL |
| **JAZZ CLEAN AMP** | Roland JC-120 |
| **DELUXE AMP** | Fender |

---

## **11\. Channel EQs (FX Rack Versions)**

FX Rack versions mirror channel EQs:

* SOUL ANALOGUE – SSL

* EVEN 88 FORMANT – Neve

* EVEN 84 – Neve

* FORTISSIMO 110 – Focusrite

* PULSAR – Pultec-style

* MACH EQ4 – Mäag

---

## **12\. Channel Strips (FX Rack)**

| Channel Strip | Inspiration | Firmware |
| ----- | ----- | ----- |
| **EVEN** | Neve | v1.12 |
| **SOUL** | SSL | v1.12 |
| **Vintage** | Hybrid | v1.12 |
| **Bus** | Bus processing | v1.12 |
| **Master** | Mastering chain | v1.12 |

---

## **Final Summary**

* WING offers **one of the deepest processing ecosystems in live sound**

* Channel and FX Rack tools mirror **classic studio workflows**

* Zero-latency design enables **safe parallel and stacked dynamics**

* FX Rack rivals **high-end plugin suites**

* Firmware v1.09–v1.12 dramatically expanded creative and system tools

* AUX channels intentionally retain **simplified processing**

---

* 

