<?php
session_start();
require __DIR__ . '/../myDB/db.php'; // MySQLi OOP connection ($conn)

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // PHP validation
    if ($email === '' || $password === '') {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $role = null;
        $user = null;

        // Check authority
        $stmt = $conn->prepare("SELECT * FROM authorDB WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user) $role = 'authority';
        $stmt->close();

        // Check doctor
        if (!$user) {
            $stmt = $conn->prepare("SELECT * FROM doctorDB WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user) $role = 'doctor';
            $stmt->close();
        }

        // Check patient
        if (!$user) {
            $stmt = $conn->prepare("SELECT * FROM patientDB WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user) $role = 'patient';
            $stmt->close();
        }

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $role;

            // Redirect to respective dashboard
            if ($role === 'authority') {
                header("Location: ../Authority Dashboard/authority.php");
            } elseif ($role === 'doctor') {
                header("Location: ../Doctors Portal/docportal.php");
            } elseif ($role === 'patient') {
                header("Location: ../Patient Dashboard/patientPortal.php");
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../signup/signup.css">
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
        <a href="../signup/signup.php">Sign Up</a>
    </div>
</nav>

<!-- Login Box -->
<div class="signup-box" style="margin-top:100px;">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label>Password:</label>
        <input type="password" name="password">

        <button type="submit">Login</button>
    </form>

    <p style="margin-top:15px;">Don't have an account? <a href="../signup/signup.php"> - Sign up! </a></p>
</div>

<!-- Footer -->
<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
