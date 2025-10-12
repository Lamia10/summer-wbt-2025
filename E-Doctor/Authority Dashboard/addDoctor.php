<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

include '../myDB/db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $hospital = trim($_POST['hospital'] ?? '');

    if (!$name || !$email || !$password || !$specialty || !$hospital) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO doctorDB (name, email, password, specialty, hospital) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed, $specialty, $hospital);

        if ($stmt->execute()) {
            $success = "Doctor added successfully.";
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
    <title>Add Doctor</title>
    <link rel="stylesheet" href="addDoctor.css">
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
        <h1>Add New Doctor</h1>

        <?php if($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty" value="<?= htmlspecialchars($_POST['specialty'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="hospital">Hospital:</label>
                <input type="text" name="hospital" id="hospital" value="<?= htmlspecialchars($_POST['hospital'] ?? '') ?>">
            </div>

            <button type="submit" class="save-btn">Add Doctor</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
    </footer>
</body>
</html>
