<?php
include '../myDB/db.php';

$doctor_id = $_GET['id'] ?? '';
if (empty($doctor_id)) {
    echo "Doctor not found!";
    exit();
}

// Fetch doctor info
$stmt = $conn->prepare("SELECT * FROM doctordb WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$doctor) {
    echo "Doctor not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Profile - <?= htmlspecialchars($doctor['name']); ?></title>
<link rel="stylesheet" href="viewprofile.css">
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
    background: #f0f6ff;
    color: #0b2a5a;
}
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #0b2a5a;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    z-index: 1000;
}
.navbar a {
    color: white;
    text-decoration: none;
    margin-right: 20px;
}
.navbar a:hover {
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 10px;
    border-radius: 5px;
}
.profile-container {
    max-width: 800px;
    margin: 120px auto 40px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.profile-header {
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
}
.profile-header img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #0b2a5a;
}
.profile-header h2 {
    margin: 0;
    font-size: 26px;
}
.profile-header p {
    margin: 4px 0;
    font-size: 14px;
    color: #555;
}
.profile-description {
    margin-top: 15px;
    font-size: 14px;
    line-height: 1.5;
    color: #444;
    max-height: 100px;
    overflow: hidden;
}
.back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 22px;
    background-color: #0b2a5a;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
}
.back-btn:hover {
    background-color: #0d3c91;
}
.footer {
    width: 100%;
    background: #0b2a5a;
    color: white;
    text-align: center;
    padding: 15px 0;
    position: fixed;
    bottom: 0;
    left: 0;
}
</style>
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <a href="../index.php">Home</a>
        <a href="../about us/aboutus.php">About Us</a>
        <a href="../emergency/emergency.php">Emergency Contact</a>
    </div>
</nav>

<div class="profile-container">
    <div class="profile-header">
        <img src="<?= htmlspecialchars($doctor['photo']) ?: 'images/default.png'; ?>" alt="<?= htmlspecialchars($doctor['name']); ?>">
        <div>
            <h2><?= htmlspecialchars($doctor['name']); ?></h2>
            <p><strong>Department:</strong> <?= htmlspecialchars($doctor['specialty']); ?></p>
            <?php if(!empty($doctor['qualification'])): ?>
                <p><strong>Qualification:</strong> <?= htmlspecialchars($doctor['qualification']); ?></p>
            <?php endif; ?>
            <?php if(!empty($doctor['email'])): ?>
                <p><strong>Email:</strong> <?= htmlspecialchars($doctor['email']); ?></p>
            <?php endif; ?>
            <?php if(!empty($doctor['phone'])): ?>
                <p><strong>Phone:</strong> <?= htmlspecialchars($doctor['phone']); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php if(!empty($doctor['description'])): ?>
        <div class="profile-description">
            <?= nl2br(htmlspecialchars($doctor['description'])); ?>
        </div>
    <?php endif; ?>

    <a class="back-btn" href="findadoc.php">← Back to Find Doctor</a>
</div>

<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
