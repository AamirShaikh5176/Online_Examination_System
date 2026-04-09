# 🎓 Online Examination System (Modernized)

A robust, highly secure, and visually stunning Online Examination platform built on PHP. This system features an immersive "Glassmorphism" design aesthetic and allows institutions to conduct time-locked, subject-oriented multiple-choice question (MCQ) examinations seamlessly.

---

## 🚀 Key Features

### 1. Immersive UI / UX (Deep Ocean Glassmorphism)
The entire platform ditches generic Bootstrap layouts for a custom-built, modern glassmorphism design. Interfaces feature translucent floating cards, dynamic hover micro-animations, and a responsive grid layout mapping out the dashboards.

### 2. Multi-Subject Architecture
Unlike rigid standard tests, this system acts as an educational hub. 
* Admins can create isolated subjects (e.g., Mathematics, Computer Science).
* Questions are uniquely mapped to their respective subjects.
* Each subject features an independently configurable **Exam Timer duration**.

### 3. Bulletproof Test Security
The examination module has been heavily audited for candidate integrity:
* **Anti-Back Button:** Uses `history.pushState` to prevent students from navigating backward out of an ongoing test to escape or view prior answers without submission.
* **Tab-Switching / Minimization Lock:** Integrates `visibilitychange` listeners to actively monitor the exam window. If a student attempts to minimize or switch to a new tab/application to find answers, an explicit warning is triggered.
* **Auto-Submission:** Timers compute down using Javascript verified explicitly against a `localStorage` lock mechanism. When the timer expires, the test submits natively via an auto-trigger.

### 4. Robust Administration Portal
Admins have access to a decoupled, extremely optimized grid-dashboard allowing them full CRUD (Create, Read, Update, Delete) controls:
* **Subject Manager:** Add dependencies or rename subject boundaries.
* **Question Manager:** A master-detail workflow. Select a specific subject to see exactly which questions populate it. Admins can hit the dynamic *Edit* button to automatically refill all 4 choices and the correct answer for fast typo fixes without crashing test continuity.
* **Advanced Question Numbering:** The Add Question GUI safely displays dynamic relative question counts using Javascript, whilst the PHP backend natively performs bulletproof `MAX(global_id) + 1` indexing to protect database mapping from overlaps.
* **Timer Rules:** Change time allowances specifically for heavy or light subjects.

### 5. Authentic PDF Result Generation
Upon test completion, students are transitioned to a clean dashboard. If they press **Download Report**, Javascript rips out the graphical UI and silently formats a pristine, authentic University-grade physical transcript (*Official Statement of Marks*).
* Explicitly branded for **Bharati Vidyapeeth University**.
* Includes Candidate Details, Subject Categories, Exam Limits, Percentages, and Pass/Fail statuses mapped flawlessly against Print CSS boundaries.

---

## 🛠️ Technical Stack

* **Backend:** PHP (Object-Oriented Architecture)
* **Database:** MySQL / MariaDB (Standard MyISAM tracking)
* **Frontend:** HTML5, CSS3 (Glassmorphism Custom Stylesheet), Vanilla Javascript

---

## ⚙️ Installation & Usage

1. **Environment Setup:** Place the project folder (`Online_Examination_System`) inside your local server's root directory (e.g., `htdocs` for XAMPP or `www` for WAMP).
2. **Database Import:** 
   * Open `phpMyAdmin`.
   * Create a new database named `mcqexamination`.
   * Import the provided `DATABASE FILE/mcqexamination.sql` file.
3. **Database Configuration:**
   * If your MySQL root user has a password, update the credentials inside `lib/Database.php`.
4. **Launch Application:** Navigate to `http://localhost/Online_Examination_System/`

### Default System Accounts:
* **Admin Access:**
  * Endpoint: `/admin/login.php`
  * User: `admin` / Password: `admin`
  *(Note: Password strings are strictly MD5 hashed behind the scenes)*

---

*Note: This software was natively modified and secured via intelligent agentic coding strategies focusing on institutional-grade security models, advanced data validation constraints, and responsive modern aesthetic principles.*
