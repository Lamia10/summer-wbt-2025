<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

$user = $_SESSION['user'] ?? [];
$userName = is_array($user) && isset($user['name']) ? $user['name'] : 'Admin';

require '../myDB/db.php'; // MySQLi OOP connection ($conn)

// Fetch all doctors
$result = $conn->query("SELECT * FROM doctorDB ORDER BY created_at DESC");
$doctors = [];
if ($result) {
    $doctors = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Flash messages
$flashSuccess = $_SESSION['success'] ?? '';
$flashError = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="ManageDoc.css">
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
        <a href="ManageDoc.php" class="active">🧑‍⚕️ Manage Doctors</a>
        <a href="ManagePatient.php">👨‍💼 Manage Patients</a>
        <a href="Reports.php">📈 Reports</a>
        <a href="Settings.php">⚙️ Settings</a>
    </div>

    <!-- Main content -->
    <div class="main">
        <div class="topbar">
            <h1>Manage Doctors</h1>
            <div class="profile">
                <span><?= htmlspecialchars($userName) ?></span>
                <img src="https://via.placeholder.com/35" alt="profile">
            </div>
        </div>

        <div class="action-buttons">
            <a href="addDoctor.php" class="btn">➕ Add New Doctor</a>
        </div>

        <?php if ($flashSuccess): ?>
            <p class="success"><?= htmlspecialchars($flashSuccess) ?></p>
        <?php endif; ?>
        <?php if ($flashError): ?>
            <p class="error"><?= htmlspecialchars($flashError) ?></p>
        <?php endif; ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Hospital</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($doctors): ?>
                    <?php foreach ($doctors as $doc): ?>
                        <tr>
                            <td><?= htmlspecialchars($doc['name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($doc['specialty'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($doc['hospital'] ?? '-') ?></td>
                            <td>
                                <a href="editDoctor.php?id=<?= $doc['id'] ?>" class="btn-edit">✏️ Edit</a>
                                <a href="deleteDoctor.php?id=<?= $doc['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this doctor?');">🗑️ Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No doctors found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
    </footer>

</body>
</html>
