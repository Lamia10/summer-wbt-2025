<?php
require __DIR__ . '/../myDB/db.php'; // $conn = new mysqli(...)

$errors = [];
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name      = trim($_POST['name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $contact   = trim($_POST['contact'] ?? '');
    $nid       = trim($_POST['nid'] ?? '');
    $gender    = trim($_POST['gender'] ?? '');
    $occupation= trim($_POST['occupation'] ?? '');
    $present_address   = trim($_POST['present_address'] ?? '');
    $permanent_address = trim($_POST['permanent_address'] ?? '');

    // Validation
    if (empty($name)) $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($contact)) $errors[] = "Phone/Contact is required.";
    if (empty($nid)) $errors[] = "NID is required.";
    if (empty($gender)) $errors[] = "Gender is required.";
    if (empty($occupation)) $errors[] = "Occupation is required.";
    if (empty($present_address)) $errors[] = "Present address is required.";
    if (empty($permanent_address)) $errors[] = "Permanent address is required.";

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check duplicate email
        $check = $conn->prepare("SELECT id FROM patientDB WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $errors[] = "Email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO patientDB 
                (name, email, password, contact, nid, gender, occupation, present_address, permanent_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssssssss",
                $name,
                $email,
                $hashedPassword,
                $contact,
                $nid,
                $gender,
                $occupation,
                $present_address,
                $permanent_address
            );

            if ($stmt->execute()) {
                $successMsg = "Patient registered successfully!";
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Signup</title>
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

<div class="signup-box">
    <h2>Patient Signup</h2>

    <?php if($errors): ?>
        <div class="form-message">
            <?php foreach($errors as $error) echo "<p class='error'>".htmlspecialchars($error)."</p>"; ?>
        </div>
    <?php endif; ?>

    <?php if($successMsg): ?>
        <div class="form-message">
            <p class="success"><?= htmlspecialchars($successMsg) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label>Password:</label>
        <input type="password" name="password">

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password">

        <label>Phone / Contact:</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($_POST['contact'] ?? '') ?>">

        <label>NID:</label>
        <input type="text" name="nid" value="<?= htmlspecialchars($_POST['nid'] ?? '') ?>">

        <label>Gender:</label>
        <select name="gender">
            <option value="">--Select--</option>
            <option value="Male" <?= (($_POST['gender'] ?? '') === 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (($_POST['gender'] ?? '') === 'Female') ? 'selected' : '' ?>>Female</option>
        </select>

        <label>Occupation:</label>
        <input type="text" name="occupation" value="<?= htmlspecialchars($_POST['occupation'] ?? '') ?>">

        <label>Present Address:</label>
        <input type="text" name="present_address" value="<?= htmlspecialchars($_POST['present_address'] ?? '') ?>">

        <label>Permanent Address:</label>
        <input type="text" name="permanent_address" value="<?= htmlspecialchars($_POST['permanent_address'] ?? '') ?>">

        <button type="submit">Register</button>
    </form>
</div>

<footer class="footer">
  <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
