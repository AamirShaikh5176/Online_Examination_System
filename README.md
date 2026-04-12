<p align="center">
  <img src="https://github.com/user-attachments/assets/7c4a46f2-e185-416f-b52a-2825ed65cb0d" width="24%"/>
  <img src="https://github.com/user-attachments/assets/2faa8243-c611-46db-be21-408e1fb56af9" width="24%"/>
  <img src="https://github.com/user-attachments/assets/71ed11df-ec8c-4b83-a124-709913ede777" width="24%"/>
  <img src="https://github.com/user-attachments/assets/887cf9c1-fc4a-4295-af2f-a01b3c32294a" width="24%"/>
</p>
<p align="center">
  <img src="https://github.com/user-attachments/assets/5f57b12d-fdb5-4736-8bb1-e08ebafff40c" width="32%"/>
  <img src="https://github.com/user-attachments/assets/fd9a6467-8560-48ef-bebc-102d7eaeedd7" width="32%"/>
  <img src="https://github.com/user-attachments/assets/e021ebb8-da88-4de9-be7d-f52bd4faa525" width="32%"/>
</p>
<p align="center">
  <img src="https://github.com/user-attachments/assets/8c983206-0ff1-46dd-97a5-0417cd20ae87" width="32%"/>
  <img src="https://github.com/user-attachments/assets/7b23ab96-ae92-4abf-b392-cd65444c6caf" width="32%"/>
  <img src="https://github.com/user-attachments/assets/2d6a8b36-76fa-45ec-bd78-4905e37bc23d" width="32%"/>
<p align="center">
 <img src="https://github.com/user-attachments/assets/06cfbc7e-924f-4127-8f64-3d0c01be8f01" width="32%"/>
 <img src="https://github.com/user-attachments/assets/f3b78f5e-9210-4797-a66f-79b52f13b6b2" width="32%"/>
 <img src="https://github.com/user-attachments/assets/129011f7-5016-4a19-a201-e79bc5a250a4" width="32%"/>
</p>

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

## 🔑 How to Change Admin Username & Password

Follow these steps using **phpMyAdmin**:

1. Open **phpMyAdmin**
2. Select your database (e.g., `online_exam`)
3. Open the table that stores admin
4. Click on the **Edit (✏️)** button for the admin row
5. Update:

   * `username` → your new username
   * `password` → your new password
6. Click **Go / Save**

⚠️ Note:

* If password is hashed (e.g., MD5), select **MD5** from function dropdown before saving
* If not hashed, you can enter plain password directly

---
