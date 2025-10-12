<?php
session_start();
require __DIR__ . '/../myDB/db.php'; // mysqli connection $conn

// Ensure only logged-in doctor can access
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'doctor') {
    header("Location: ../Login/login.php");
    exit;
}

$doctor = $_SESSION['user'];
$doctor_id = $doctor['id'];

// Fetch upcoming appointments
$stmt = $conn->prepare("SELECT a.id, a.appointment_date, a.appointment_time, a.status, p.name AS patient_name
                        FROM appointmentDB a
                        JOIN patientDB p ON a.patient_id = p.id
                        WHERE a.doctor_id = ?
                        ORDER BY a.appointment_date ASC, a.appointment_time ASC");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch patient history (last 5 appointments)
$stmt = $conn->prepare("SELECT p.name AS patient_name, COUNT(a.id) AS visits, MAX(a.appointment_date) AS last_visit
                        FROM appointmentDB a
                        JOIN patientDB p ON a.patient_id = p.id
                        WHERE a.doctor_id = ?
                        GROUP BY a.patient_id
                        ORDER BY last_visit DESC
                        LIMIT 5");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$history = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch pending appointment requests
$stmt = $conn->prepare("SELECT a.id, p.name AS patient_name, a.appointment_date, a.appointment_time, a.status
                        FROM appointmentDB a
                        JOIN patientDB p ON a.patient_id = p.id
                        WHERE a.doctor_id = ? AND a.status='Pending'
                        ORDER BY a.appointment_date ASC, a.appointment_time ASC");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$requests = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor’s Portal</title>
<link rel="stylesheet" href="DocStyle.css">
<script src="DocP.js" defer></script>
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <a href="../index.php">Home</a>
        <a href="../about us/aboutus.php">About Us</a>
        <a href="../emergency/emergency.php">Emergency Contact</a>
    </div>
    <div class="nav-right">
        <a href="../Login/logout.php">Logout</a>
    </div>
</nav>

<header class="topbar">
    <button id="menuToggle" aria-label="Toggle sidebar" class="icon-btn">☰</button>
    <h1>Doctor’s Portal</h1>
</header>

<div class="layout">
<aside class="sidebar" id="sidebar">
    <div class="profile">
        <div class="avatar">DR</div>
        <div class="details">
            <h3><?= htmlspecialchars($doctor['name']) ?></h3>
            <p><?= htmlspecialchars($doctor['specialty'] ?? '') ?></p>
        </div>
    </div>

    <nav class="side-nav">
        <a href="#" class="active">Dashboard</a>
        <a href="#">My Patients</a>
        <a href="#">Messages</a>
        <a href="#">Settings</a>
        <a href="../Login/logout.php">Logout</a>
    </nav>
</aside>

<main class="content">
<section class="grid">

<!-- Upcoming Appointments -->
<article class="card">
    <div class="card-head">
        <h2>Upcoming Appointments</h2>
        <input id="apptSearch" class="search" type="text" placeholder="Search patient…" />
    </div>
    <div class="card-body scroll">
        <table class="table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="apptTable">
                <?php foreach($appointments as $a): ?>
                    <tr>
                        <td><?= date('H:i', strtotime($a['appointment_time'])) ?></td>
                        <td><?= htmlspecialchars($a['patient_name']) ?></td>
                        <td><?= date('d M', strtotime($a['appointment_date'])) ?></td>
                        <td><?= htmlspecialchars($a['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</article>

<!-- Patient History -->
<article class="card">
    <div class="card-head"><h2>Patient History</h2></div>
    <div class="card-body scroll">
        <ul class="timeline">
            <?php foreach($history as $h): ?>
                <li>
                    <div class="dot"></div>
                    <div>
                        <strong><?= htmlspecialchars($h['patient_name']) ?></strong> – <?= $h['visits'] ?> visits
                        <div class="muted">Last: <?= date('d M Y', strtotime($h['last_visit'])) ?></div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</article>

<!-- Appointment Requests -->
<article class="card">
    <div class="card-head"><h2>Appointment Requests</h2></div>
    <div class="card-body scroll">
        <?php foreach($requests as $r): ?>
            <div class="request" data-id="<?= $r['id'] ?>">
                <div>
                    <strong><?= htmlspecialchars($r['patient_name']) ?></strong>
                    <div class="muted">Preferred: <?= date('H:i', strtotime($r['appointment_time'])) ?> • <?= date('d M', strtotime($r['appointment_date'])) ?></div>
                </div>
                <div class="actions">
                    <button class="btn success approve">Approve</button>
                    <button class="btn danger decline">Decline</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</article>

</section>
</main>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
