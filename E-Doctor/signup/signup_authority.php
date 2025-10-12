<?php
require __DIR__ . '/../myDB/db.php';

$errors = [];
$successMsg = "";

// Initialize variables to keep form values after submission
$name = $email = $password = $contact = $nid = $gender = $present_address = $permanent_address = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get POST values
    $name              = trim($_POST['name'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $password          = trim($_POST['password'] ?? '');
    $contact           = trim($_POST['contact'] ?? '');
    $nid               = trim($_POST['nid'] ?? '');
    $gender            = trim($_POST['gender'] ?? '');
    $present_address   = trim($_POST['present_address'] ?? '');
    $permanent_address = trim($_POST['permanent_address'] ?? '');

    // PHP Validation
    if ($name === '') $errors[] = "Name is required.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($contact === '') $errors[] = "Phone number is required.";
    if ($nid === '') $errors[] = "NID is required.";
    if ($gender === '') $errors[] = "Gender is required.";
    if ($present_address === '') $errors[] = "Present address is required.";
    if ($permanent_address === '') $errors[] = "Permanent address is required.";

    // Check for duplicate email
    $stmt = $conn->prepare("SELECT id FROM authorDB WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->fetch_assoc()) $errors[] = "Email already registered.";
    $stmt->close();

    // If no errors, insert into database
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            INSERT INTO authorDB 
            (name, email, password, contact, nid, gender, present_address, permanent_address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssssss",
            $name,
            $email,
            $hashedPassword,
            $contact,
            $nid,
            $gender,
            $present_address,
            $permanent_address
        );
        $stmt->execute();
        $stmt->close();

        $successMsg = "Authority registered successfully!";
        // Clear form values after success
        $name = $email = $password = $contact = $nid = $gender = $present_address = $permanent_address = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authority Signup</title>
    <link rel="stylesheet" href="signup.css">
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
        <a href="../Login/login.php">Login</a>
    </div>
</nav>

<div class="signup-box" style="margin-top:100px;">
    <h2>Authority Signup</h2>

    <?php if($errors): ?>
        <div class="form-message">
            <?php foreach($errors as $error) echo "<p class='error'>{$error}</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if($successMsg): ?>
        <div class="form-message">
            <p class="success"><?= htmlspecialchars($successMsg) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

        <label>Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">

        <label>Password:</label>
        <input type="password" name="password">

        <label>Phone:</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($contact) ?>">

        <label>NID:</label>
        <input type="text" name="nid" value="<?= htmlspecialchars($nid) ?>">

        <label>Gender:</label>
        <select name="gender">
            <option value="">--Select--</option>
            <option value="Male" <?= $gender === "Male" ? "selected" : "" ?>>Male</option>
            <option value="Female" <?= $gender === "Female" ? "selected" : "" ?>>Female</option>
            <option value="Other" <?= $gender === "Other" ? "selected" : "" ?>>Other</option>
        </select>

        <label>Present Address:</label>
        <textarea name="present_address"><?= htmlspecialchars($present_address) ?></textarea>

        <label>Permanent Address:</label>
        <textarea name="permanent_address"><?= htmlspecialchars($permanent_address) ?></textarea>

        <button type="submit">Register</button>
    </form>

    <p style="margin-top:15px;">Already have an account? <a href="../Login/login.php">Login</a></p>
</div>

<!-- Footer -->
<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
