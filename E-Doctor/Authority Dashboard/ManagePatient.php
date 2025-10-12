<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

$user = $_SESSION['user'] ?? [];
$userName = $user['name'] ?? 'Admin';

require '../myDB/db.php'; // MySQLi OOP connection ($conn)

// Fetch all patients
$result = $conn->query("SELECT * FROM patientDB ORDER BY created_at DESC");
$patients = [];
if ($result) {
    $patients = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Patients</title>
    <link rel="stylesheet" href="ManageDoc.css"> <!-- Use same CSS as ManageDoc -->
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
    <a href="ManagePatient.php" class="active">👨‍💼 Manage Patients</a>
    <a href="Reports.php">📈 Reports</a>
    <a href="Settings.php">⚙️ Settings</a>
</div>

<!-- Main content -->
<div class="main">
    <div class="topbar">
        <h1>Manage Patients</h1>
        <div class="profile">
            <span><?= htmlspecialchars($userName) ?></span>
            <img src="https://via.placeholder.com/35" alt="profile">
        </div>
    </div>

    <div class="action-buttons">
        <a href="addPatient.php" class="btn">➕ Add New Patient</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($patients): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($patient['age'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($patient['gender'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($patient['contact'] ?? '-') ?></td>
                        <td>
                            <a href="editPatient.php?id=<?= $patient['id'] ?>" class="btn-edit">✏️ Edit</a>
                            <a href="deletePatient.php?id=<?= $patient['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?');">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No patients found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
