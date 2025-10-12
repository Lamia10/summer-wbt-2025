
<?php
require __DIR__ . '/myDB/db.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <div class="nav-left">
            <a href="#">Home</a>
            <a href="about us/aboutus.php">About Us</a>
            <a href="emergency/emergency.php">Emergency Contact</a>
        </div>
        <div class="nav-right">
            <a href="Login/login.php">Login</a>
        </div>
    </nav>

    <div class="bg">
        <div class="button-row">
            <div class="card">
                <div class="icon">
                    <img src="image/findadoc.webp" alt="doctor">
                </div>
                <a href="Find a Doctor/Findadoc.php">FIND A DOCTOR</a>
            </div>

            <div class="card">
                <div class="icon">
                    <img src="image/appointment.png" alt="appointment">
                </div>
                <a href="Appointment/appointment.php">REQUEST AN APPOINTMENT</a>
            </div>

            <div class="card">
                <div class="icon">
                    <img src="image/specialities.webp" alt="Specialities">
                </div>
                <a href="Specialities/specialities.php">OUR SPECIALITIES</a>
            </div>
        </div>
    </div>
</body>

<footer class="footer">
  <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</html>
