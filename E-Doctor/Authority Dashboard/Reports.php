<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

$user = $_SESSION['user'] ?? [];
$userName = $user['name'] ?? 'Admin';

require '../myDB/db.php'; // MySQLi OOP connection ($conn)

// Fetch reports from DB
$sql = "
    SELECT r.patient_name, d.name AS doctor_name, r.rating, r.comment
    FROM feedbackDB r
    JOIN doctorDB d ON r.doctor_id = d.id
    ORDER BY r.created_at DESC
";
$result = $conn->query($sql);
$reports = [];
if ($result) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Fetch all doctors for filter dropdown
$doctorList = [];
$result2 = $conn->query("SELECT id, name FROM doctorDB ORDER BY name ASC");
if ($result2) {
    $doctorList = $result2->fetch_all(MYSQLI_ASSOC);
    $result2->free();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors Feedback Reports</title>
    <link rel="stylesheet" href="Reports.css"> <!-- same CSS as ManageDoc -->
</head>
<body>

<!-- Navbar -->
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

<!-- Sidebar -->
<div class="sidebar">
    <h2>Authority Panel</h2>
    <a href="authority.php">📊 Dashboard</a>
    <a href="ManageDoc.php">🧑‍⚕️ Manage Doctors</a>
    <a href="ManagePatient.php">👨‍💼 Manage Patients</a>
    <a href="Reports.php" class="active">📈 Reports</a>
    <a href="Settings.php">⚙️ Settings</a>
</div>

<!-- Main content -->
<div class="main">
    <div class="topbar">
        <h1>Doctors Feedback Reports</h1>
        <div class="profile">
            <span><?= htmlspecialchars($userName) ?></span>
            <img src="https://via.placeholder.com/35" alt="profile">
        </div>
    </div>

    <div class="filters">
        <label for="doctor">Select Doctor:</label>
        <select id="doctor">
            <option value="all">All Doctors</option>
            <?php foreach ($doctorList as $doctor): ?>
                <option value="<?= $doctor['id'] ?>"><?= htmlspecialchars($doctor['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="time">Time Range:</label>
        <select id="time">
            <option value="7days">Last 7 Days</option>
            <option value="1month">Last 1 Month</option>
            <option value="all">All Time</option>
        </select>

        <button class="show-btn">Show Feedback</button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($reports): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= htmlspecialchars($report['patient_name']) ?></td>
                        <td><?= htmlspecialchars($report['doctor_name']) ?></td>
                        <td><?= htmlspecialchars($report['rating']) ?></td>
                        <td><?= htmlspecialchars($report['comment']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No feedback found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
