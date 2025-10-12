<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

require '../myDB/db.php'; // MySQLi OOP connection ($conn)

$doctorId = $_GET['id'] ?? null;
$error = "";
$success = "";
$doctor = null;

// Fetch existing doctor details
if ($doctorId) {
    $stmt = $conn->prepare("SELECT * FROM doctorDB WHERE id = ?");
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();
    $stmt->close();

    if (!$doctor) {
        $error = "Doctor not found.";
    }
} else {
    $error = "Invalid doctor ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $hospital = trim($_POST['hospital'] ?? '');

    if (empty($name) || empty($specialty) || empty($hospital)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE doctorDB SET name = ?, specialty = ?, hospital = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $specialty, $hospital, $doctorId);

        if ($stmt->execute()) {
            $success = "Doctor details updated successfully.";
            // Refresh doctor data
            $stmt->close();
            $stmt = $conn->prepare("SELECT * FROM doctorDB WHERE id = ?");
            $stmt->bind_param("i", $doctorId);
            $stmt->execute();
            $result = $stmt->get_result();
            $doctor = $result->fetch_assoc();
        } else {
            $error = "Failed to update doctor details.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="editDoctor.css">
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
    <h1>Edit Doctor</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($doctor): ?>
    <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="specialty">Department/Specialty:</label>
            <input type="text" id="specialty" name="specialty" value="<?= htmlspecialchars($doctor['specialty']) ?>" required>
        </div>
        <div class="form-group">
            <label for="hospital">Hospital:</label>
            <input type="text" id="hospital" name="hospital" value="<?= htmlspecialchars($doctor['hospital']) ?>" required>
        </div>
        <button type="submit" class="save-btn">Save Changes</button>
    </form>
    <?php endif; ?>
</div>

<footer class="footer">
  <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>
</body>
</html>
