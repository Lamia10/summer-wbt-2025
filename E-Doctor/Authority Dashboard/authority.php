<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

// Ensure $user is an array
$user = $_SESSION['user'] ?? [];
$userName = is_array($user) && isset($user['name']) ? $user['name'] : 'Admin';

require '../myDB/db.php';

// Fetch dashboard stats
$totalDoctors = 0;
$totalPatients = 0;
$totalAppointments = 0;
$todayAppointments = 0;
$activities = [];

if ($conn) {
    // Total counts
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM doctorDB");
    $totalDoctors = $res ? $res->fetch_assoc()['cnt'] : 0;

    $res = $conn->query("SELECT COUNT(*) AS cnt FROM patientDB");
    $totalPatients = $res ? $res->fetch_assoc()['cnt'] : 0;

    $res = $conn->query("SELECT COUNT(*) AS cnt FROM appointmentDB");
    $totalAppointments = $res ? $res->fetch_assoc()['cnt'] : 0;

    // Today's appointments
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM appointmentDB WHERE appointment_date = ?");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $res = $stmt->get_result();
    $todayAppointments = $res ? $res->fetch_assoc()['cnt'] : 0;
    $stmt->close();

    // Recent activities
    $sql = "
        SELECT p.name AS patient, d.name AS doctor, a.status, a.appointment_date
        FROM appointmentDB a
        JOIN patientDB p ON a.patient_id = p.id
        JOIN doctorDB d ON a.doctor_id = d.id
        ORDER BY a.created_at DESC LIMIT 5
    ";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $activities = $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Authority Dashboard</title>
    <link rel="stylesheet" href="authority.css">
</head>

<body>
    <nav class="navbar">
        <div class="nav-left">
            <a href="../index.php">Home</a>
            <a href="../about us/aboutus.php">About Us</a>
            <a href="../emergency/emergency.php">Emergency Contact</a>
        </div>
        <div class="nav-right">
            <a href="../Login/logout.php">Log out</a>
        </div>
    </nav>

    <div class="sidebar">
        <h2>Authority Panel</h2>
        <a href="authority.php" class="active">📊 Dashboard</a>
        <a href="ManageDoc.php">🧑‍⚕️ Manage Doctors</a>
        <a href="ManagePatient.php">👨‍💼 Manage Patients</a>
        <a href="Reports.php">📈 Reports</a>
        <a href="Settings.php">⚙️ Settings</a>
    </div>

    <div class="main">
        <div class="topbar">
            <h1>Dashboard</h1>
            <div class="profile">
                <span><?= htmlspecialchars($userName) ?></span>
                <img src="https://via.placeholder.com/35" alt="profile">
            </div>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total Doctors</h3>
                <p><?= $totalDoctors ?></p>
            </div>
            <div class="card">
                <h3>Total Patients</h3>
                <p><?= $totalPatients ?></p>
            </div>
            <div class="card">
                <h3>Total Appointments</h3>
                <p><?= $totalAppointments ?></p>
            </div>
            <div class="card">
                <h3>Today’s Appointments</h3>
                <p><?= $todayAppointments ?></p>
            </div>
        </div>

        <div class="recent">
            <h2>Recent Activities</h2>
            <ul>
                <?php if (!empty($activities)): ?>
                    <?php foreach ($activities as $act): ?>
                        <li>Patient <?= htmlspecialchars($act['patient']) ?> - Appointment with Dr. <?= htmlspecialchars($act['doctor']) ?> (<?= htmlspecialchars($act['status']) ?>) on <?= htmlspecialchars($act['appointment_date']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No recent activities</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <footer class="footer">
        <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
    </footer>
</body>
</html>
