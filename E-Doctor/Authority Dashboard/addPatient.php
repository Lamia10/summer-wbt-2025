<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

include '../myDB/db.php';

$user = $_SESSION['user'] ?? [];
$userName = $user['name'] ?? 'Admin';

$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $age = $_POST['age'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $contact = trim($_POST['contact'] ?? '');

    // Validation
    if (!$name || !$email || !$password) {
        $error = "Name, Email, and Password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO patientDB (name, email, password, age, gender, contact) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $name, $email, $hashedPassword, $age, $gender, $contact);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Patient added successfully!";
            header("Location: ManagePatient.php");
            exit;
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Patient</title>
    <link rel="stylesheet" href="addPatient.css">
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
    <a href="authority.php">📊 Dashboard</a>
    <a href="ManageDoc.php">🧑‍⚕️ Manage Doctors</a>
    <a href="ManagePatient.php" class="active">👨‍💼 Manage Patients</a>
    <a href="Reports.php">📈 Reports</a>
    <a href="Settings.php">⚙️ Settings</a>
</div>

<div class="main">
    <div class="topbar">
        <h1>Add New Patient</h1>
        <div class="profile">
            <span><?= htmlspecialchars($userName) ?></span>
            <img src="https://via.placeholder.com/35" alt="profile">
        </div>
    </div>

    <div class="container">
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Age:</label>
                <input type="number" name="age" min="0" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <select name="gender">
                    <option value="">Select</option>
                    <option value="Male" <?= (($_POST['gender'] ?? '') === 'Male') ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= (($_POST['gender'] ?? '') === 'Female') ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= (($_POST['gender'] ?? '') === 'Other') ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Contact:</label>
                <input type="text" name="contact" value="<?= htmlspecialchars($_POST['contact'] ?? '') ?>">
            </div>
            <div class="buttons">
                <button type="submit" class="save-btn">Add Patient</button>
                <a href="ManagePatient.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
