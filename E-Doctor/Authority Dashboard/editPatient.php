<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

require '../myDB/db.php'; // MySQLi OOP connection ($conn)

$user = $_SESSION['user'] ?? [];
$userName = $user['name'] ?? 'Admin';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ManagePatient.php");
    exit;
}

// Fetch existing patient
$stmt = $conn->prepare("SELECT * FROM patientDB WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
$stmt->close();

if (!$patient) {
    $_SESSION['error'] = "Patient not found.";
    header("Location: ManagePatient.php");
    exit;
}

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $age = $_POST['age'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $contact = trim($_POST['contact'] ?? '');

    if (!$name || !$email) {
        $error = "Name and Email are required.";
    } else {
        $fields = "name=?, email=?, age=?, gender=?, contact=?";
        $types = "ssiss";
        $params = [$name, $email, $age, $gender, $contact];

        if ($password) {
            $fields .= ", password=?";
            $types .= "s";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $types .= "i";
        $params[] = $id;

        $sql = "UPDATE patientDB SET $fields WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Patient updated successfully!";
            $stmt->close();
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
    <title>Edit Patient</title>
    <link rel="stylesheet" href="editPatient.css">
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
        <h1>Edit Patient</h1>
        <div class="profile">
            <span><?= htmlspecialchars($userName) ?></span>
            <img src="https://via.placeholder.com/35" alt="profile">
        </div>
    </div>

    <div class="container">
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($patient['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>" required>
            </div>
            <div class="form-group">
                <label>Password: <small>(leave blank to keep current)</small></label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label>Age:</label>
                <input type="number" name="age" value="<?= htmlspecialchars($patient['age']) ?>">
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <select name="gender">
                    <option value="">Select</option>
                    <option value="Male" <?= ($patient['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= ($patient['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= ($patient['gender'] === 'Other') ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Contact:</label>
                <input type="text" name="contact" value="<?= htmlspecialchars($patient['contact']) ?>">
            </div>
            <div class="buttons">
                <button type="submit" class="save-btn">Update Patient</button>
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
