<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

include '../myDB/db.php';

$doctorId = $_GET['id'] ?? null;

if ($doctorId) {
    $stmt = $conn->prepare("DELETE FROM doctorDB WHERE id = ?");
    $stmt->bind_param("i", $doctorId);
    if ($stmt->execute()) {
        header("Location: ManageDoc.php?msg=deleted");
        exit;
    } else {
        $error = "Failed to delete doctor.";
    }
    $stmt->close();
} else {
    $error = "Invalid doctor ID.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Doctor</title>
    <link rel="stylesheet" href="deleteDoctor.css">
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

<div class="container">
    <h1>Delete Doctor</h1>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <a href="ManageDoc.php" class="back-btn">Back to Manage Doctors</a>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>
</body>
</html>
