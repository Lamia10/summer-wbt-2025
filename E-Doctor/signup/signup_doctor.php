<?php
require __DIR__ . '/../myDB/db.php';

$errors = [];
$successMsg = "";

// Initialize values
$name = $email = $password = $specialty = $hospital = $contact = $nid = $gender = $degrees = $present_address = $permanent_address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name              = trim($_POST['name'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $password          = trim($_POST['password'] ?? '');
    $specialty         = trim($_POST['specialty'] ?? '');
    $hospital          = trim($_POST['hospital'] ?? '');
    $contact           = trim($_POST['contact'] ?? '');
    $nid               = trim($_POST['nid'] ?? '');
    $gender            = trim($_POST['gender'] ?? '');
    $degrees           = trim($_POST['degrees'] ?? '');
    $present_address   = trim($_POST['present_address'] ?? '');
    $permanent_address = trim($_POST['permanent_address'] ?? '');

    // Validation
    if ($name === '') $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($specialty === '') $errors[] = "Specialty is required.";
    if ($degrees === '') $errors[] = "Degrees are required.";
    if ($contact === '') $errors[] = "Contact is required.";
    if ($nid === '') $errors[] = "NID is required.";
    if ($gender === '') $errors[] = "Gender is required.";
    if ($present_address === '') $errors[] = "Present address is required.";
    if ($permanent_address === '') $errors[] = "Permanent address is required.";

    // Check duplicate email
    if ($email !== '') {
        $check = $conn->prepare("SELECT id FROM doctorDB WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) $errors[] = "Email already registered.";
        $check->close();
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO doctorDB 
            (name, email, password, specialty, hospital, contact, nid, gender, degrees, present_address, permanent_address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssssssss",
            $name,
            $email,
            $hashed,
            $specialty,
            $hospital,
            $contact,
            $nid,
            $gender,
            $degrees,
            $present_address,
            $permanent_address
        );

        if ($stmt->execute()) {
            $successMsg = "Doctor registered successfully!";
            $name = $email = $password = $specialty = $hospital = $contact = $nid = $gender = $degrees = $present_address = $permanent_address = "";
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Signup</title>
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
    <h2>Doctor Signup</h2>

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
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">

        <label>Password:</label>
        <input type="password" name="password">

        <label>Specialty:</label>
        <input type="text" name="specialty" value="<?= htmlspecialchars($specialty) ?>">

        <label>Hospital:</label>
        <input type="text" name="hospital" value="<?= htmlspecialchars($hospital) ?>">

        <label>Contact:</label>
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

        <label>Degrees:</label>
        <input type="text" name="degrees" value="<?= htmlspecialchars($degrees) ?>">

        <label>Present Address:</label>
        <textarea name="present_address"><?= htmlspecialchars($present_address) ?></textarea>

        <label>Permanent Address:</label>
        <textarea name="permanent_address"><?= htmlspecialchars($permanent_address) ?></textarea>

        <button type="submit">Register</button>
    </form>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
