# 🏥 E-Doctor's Appointment System

> A role-based healthcare appointment management platform that connects **patients, doctors, and administrators** in one system.

**E-Doctor's Appointment System** is a full-featured web-based healthcare platform built with **PHP and MySQL**. It allows patients to find doctors, explore specialities, request appointments, and manage their appointments, while doctors and authorities can manage the appointment process through dedicated dashboards.

The system follows a **role-based architecture** with three user roles: **Patient, Doctor, and Authority/Admin**.

---

## 🎯 Objectives

* Provide an easy-to-use platform for patients to find doctors and request appointments.
* Allow doctors to view and update their assigned appointments.
* Allow Authority/Admin to manage doctors, patients, and appointment-related information.
* Implement secure authentication and role-based access control.
* Provide practical healthcare features such as doctor search, specialities, and emergency contact services.

---

## ✨ Key Features

### 🛡️ Authority / Admin Panel

* 🔐 Secure session-based admin login
* 📊 Dashboard with total doctors, patients, and appointments
* 📅 Today's appointment statistics
* ➕ Add, edit, and delete doctors
* 👤 Add, edit, and delete patients
* 📋 View doctor feedback reports
* ⚙️ Manage account settings

### 👨‍⚕️ Doctor Portal

* 🔐 Secure session-based doctor login
* 📅 View assigned appointments
* 📋 View appointment history
* 🔄 Update appointment status
* 👤 Access relevant patient information

### 👤 Patient Dashboard

* 📝 Patient registration and secure login
* 🔎 Find doctors and view their profiles
* 🩺 Browse available specialities
* 📅 Request an appointment by selecting doctor, date, and time
* 🚨 Automatic redirection to the **Emergency Contact** page for emergency requests
* 📋 Track personal appointments
* ⚙️ Manage account settings

---

## 🛠️ Technologies Used

| Category                    | Technologies            |
| --------------------------- | ----------------------- |
| **Frontend**                | HTML5, CSS3, JavaScript |
| **Backend**                 | PHP                     |
| **Database**                | MySQL                   |
| **Database Connectivity**   | MySQLi                  |
| **Development Environment** | XAMPP, phpMyAdmin       |

---

## 🔐 Security

The system implements several basic security practices:

* Session-based authentication
* Role-based access control
* Password hashing using `password_hash()`
* Password verification using `password_verify()`
* MySQLi prepared statements
* Input validation

---

## 🗄️ Database

**Database Name:** `edoctor`

### Main Tables

| Table           | Description                                    |
| --------------- | ---------------------------------------------- |
| `authordb`      | Stores Authority/Admin account information     |
| `doctordb`      | Stores doctor information and specializations  |
| `patientdb`     | Stores patient information and account details |
| `appointmentdb` | Stores patient-doctor appointment information  |
| `feedbackdb`    | Stores doctor feedback, ratings, and comments  |
| `specialist`    | Stores doctor specialities/departments         |

---

## ⚙️ Setup & Installation

### 1. Install XAMPP

Install **XAMPP** with Apache and MySQL.

### 2. Start Services

Open the XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 3. Clone the Repository

```bash
git clone https://github.com/lubna-21/E-Doctor-Appointment-System.git
```

### 4. Move the Project

Place the project folder inside the XAMPP `htdocs` directory:

```text
C:\xampp\htdocs\E-Doctor\
```

### 5. Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
edoctor
```

Then import the provided SQL file located at [`E-Doctor/edoctor.sql`](E-Doctor/edoctor.sql) using phpMyAdmin:
   - Open phpMyAdmin → select the `edoctor` database
   - Go to the **Import** tab
   - Choose the `edoctor.sql` file from the `E-Doctor` folder
   - Click **Go** — this will create all required tables (`authordb`, `doctordb`, `patientdb`, `appointmentdb`, `feedbackdb`, `specialities`)

### 6. Configure Database Connection

Check the database configuration in:

```text
myDB/db.php
```

Default configuration:

```text
Host: localhost
Username: root
Password: empty
Database: edoctor
```

### 7. Run the Application

Open your browser and visit:

```text
http://localhost/E-Doctor/index.php
```

---

## 🔄 How It Works

**Patient**

```text
Register / Login
      ↓
Patient Dashboard
      ↓
Find Doctor / Specialities / Request Appointment
      ↓
Select Doctor + Date + Time
      ↓
Appointment Request
      ↓
Doctor Reviews & Updates Status
```

If the patient selects **Emergency** as the request type:

```text
Emergency Request
      ↓
Emergency Contact Page
```

**Doctor**

```text
Login
  ↓
Doctor Portal
  ↓
View Assigned Appointments
  ↓
Update Appointment Status
```

**Authority**

```text
Login
  ↓
Authority Dashboard
  ↓
Manage Doctors / Patients
  ↓
View Statistics & Feedback Reports
```

---

## 🚀 Future Enhancements

* 💳 Online payment gateway integration
* 🕐 Doctor availability and time-slot management
* 🚫 Double-booking prevention
* 📧 Email/SMS appointment notifications
* ⭐ Doctor review and rating system
* 🔑 Forgot password / email password reset
* 🔔 Real-time appointment notifications

---


⭐ **If you find this project useful, consider giving it a star!**
