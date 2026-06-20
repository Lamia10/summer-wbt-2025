@"
# 🏥 E-Doctor's Appointment System

This project is a full-featured **healthcare appointment booking platform** built using **PHP and MySQL**, designed to let patients find doctors, book appointments, and manage their healthcare — while giving admins (authority) complete control to manage doctors, patients, and appointments.

The system follows a **role-based architecture** with three separate dashboards (Patient, Doctor, Authority) and demonstrates real-world concepts such as session-based authentication, secure password hashing, role-based redirects, and prepared statements for database security.

---

## 🎯 Objectives

- Provide a simple, intuitive platform for patients to find doctors and book appointments.
- Allow doctors to manage and update their appointment status.
- Allow authority (admin) to manage doctors, patients, and bookings from a central dashboard.
- Demonstrate secure authentication and clean role-based access control.
- Apply real-world features like doctor search, specialities listing, and emergency contact handling.

---

## ✨ Key Features

### 🛡️ Authority (Admin) Panel
- Secure admin login with session-based authentication
- Dashboard showing total doctors, total patients, and total appointments (including today's appointments)
- Add, edit, and delete doctors
- Add, edit, and delete patients
- View and manage all appointment reports
- Settings page for account management

### 👨‍⚕️ Doctor Portal
- Secure doctor login with session-based authentication
- View assigned appointments
- Update appointment status

### 👤 Patient Dashboard
- Patient registration and secure login
- Browse and **find a doctor** with profile view (specialization, details)
- View **our specialities** (departments) with images
- **Book an appointment** by selecting doctor, date, and time
- Automatic redirect to **Emergency Contact** page if request type is "Emergency"
- Track personal appointments from the Patient Dashboard
- Manage account settings

---

## 🛠 Technologies Used

- PHP (Procedural, MySQLi with Prepared Statements)
- MySQL
- HTML5, CSS3
- JavaScript

---

## 🗄 Database Schema

| Table | Key Fields |
|---|---|
| **authorDB** | id, name, email, password |
| **doctorDB** | id, name, email, password, specialization |
| **patientDB** | id, name, email, password |
| **appointmentDB** | id, patient_id, doctor_id, appointment_date, appointment_time, status |

---

## ⚙ Setup Instructions

1. Install **XAMPP** (or any local server with PHP + MySQL/Apache).
2. Install **phpMyAdmin** (comes bundled with XAMPP) to manage the database.
3. Clone the repository:
``````bash
   git clone https://github.com/lubna-21/E-Doctor-Appointment-System.git
``````
4. Move the project folder into your server's root directory (e.g. ``htdocs`` for XAMPP).
5. Create a database named ``edoctor`` in phpMyAdmin and import the provided SQL file (if included).
6. Update the database credentials in ``myDB/db.php`` if needed (default: host ``localhost``, user ``root``, no password).
7. Start Apache and MySQL from the XAMPP control panel.
8. Open your browser and go to ``http://localhost/E-Doctor/index.php``.

---

## 🚀 How It Works

- A **Patient** registers, logs in, and lands on the homepage where they can **Find a Doctor**, **Request an Appointment**, or browse **Our Specialities**.
- Selecting **Find a Doctor** lets the patient view doctor profiles by specialization.
- Selecting **Request an Appointment** lets the patient choose a doctor, date, and time — and if "Emergency" is selected, they are automatically redirected to the Emergency Contact page.
- After login, the system checks the patient's role and redirects them to their respective dashboard (Patient / Doctor / Authority).
- A **Doctor** logs in separately to view and update the status of their assigned appointments.
- An **Authority (Admin)** logs in to manage doctors, patients, and appointment reports from a dedicated dashboard with live statistics.

---

## 🔮 Future Enhancements

- Add online payment gateway integration for paid consultations.
- Add doctor availability/time-slot management to prevent double booking.
- Add email or SMS notifications for appointment confirmation and reminders.
- Add a review/rating system for doctors.
- Add password reset via email (forgot password flow).
