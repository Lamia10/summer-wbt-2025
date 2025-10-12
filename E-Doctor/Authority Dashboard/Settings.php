<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

$user = $_SESSION['user'] ?? [];
$userId = $user['id'] ?? 0;
$userName = $user['name'] ?? 'Admin';
$userEmail = $user['email'] ?? '';

require '../myDB/db.php'; // MySQLi OOP connection ($conn)

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_account'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($name) || empty($email)) {
        $error = "Name and email cannot be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $sql = "UPDATE authorDB SET name = ?, email = ?";
        $params = [$name, $email];

        if (!empty($password)) {
            $sql .= ", password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = ?";
        $params[] = $userId;

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);
            if ($stmt->execute()) {
                $success = "Settings updated successfully.";
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
            } else {
                $error = "Error updating settings.";
            }
            $stmt->close();
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    $stmt = $conn->prepare("DELETE FROM authorDB WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link rel="stylesheet" href="settings.css"> <!-- same CSS for consistency -->
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
    <a href="Reports.php">📈 Reports</a>
    <a href="Settings.php" class="active">⚙️ Settings</a>
</div>

<!-- Main content -->
<div class="main">
    <div class="topbar">
        <h1>Settings</h1>
        <div class="profile">
            <span><?= htmlspecialchars($userName) ?></span>
            <img src="https://via.placeholder.com/35" alt="profile">
        </div>
    </div>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="name">Change Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($userName) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Change Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($userEmail) ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Change Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password (leave blank to keep current)">
        </div>

        <div class="buttons">
            <button type="submit" class="save-btn">Save Changes</button>
            <button type="reset" class="cancel-btn">Cancel</button>
        </div>

        <div class="delete-section">
            <button type="submit" name="delete_account" class="delete-btn" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
        </div>
    </form>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
