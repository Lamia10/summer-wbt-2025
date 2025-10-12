<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="PatientPortal.css">
</head>

<body>

    <nav class="navbar">
        <a href="../index.php">Home</a>
        <a href="../about us/aboutus.php">About Us</a>
        <a href="../emergency/emergency.php">Emergency Contact</a>
        <div class="nav-right">
            <a href="../Login/login">Login</a>
        </div>
    </nav>


    <aside class="sidebar">
        <h2>Patient Dashboard</h2>
        <ul>
            <li><a href="PatientPortal.php">🏠Home</a></li>
            <li><a href="PatientAppoinment.php">📅 Appointments </a> </li>
            <li><a href="PatientReport.php"> 📈Reports </a> </li>
            <li><a href="PatientSettings.php">⚙️Settings </a></li>
            <li><a href="../index.php>">➜] Log out</a></li>
        </ul>
    </aside>


    <main class="main-content">
        <header>
            <h1>Welcome, [Patient Name]</h1>
        </header>

        <section class="appointments">
            <h2>Upcoming Appointments</h2>
            <ul>
                <li>Dr. Rahman - 15 Sept</li>
                <li>Dr. Ayesha - 20 Sept</li>
            </ul>
        </section>

        <section class="actions">
            <h2>Quick Actions</h2>
            <button>Book Appointment</button>
            <button>View Reports</button>
        </section>
    </main>
</body>

<footer class="footer">
  <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</html>