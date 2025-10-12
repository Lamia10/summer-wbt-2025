<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="PatientSettings.css">
</head>

<body>

    <nav class="navbar">
        <div class="nav-left">
            <a href="../index.php">Home</a>
            <a href="../about us/aboutus.php">About Us</a>
            <a href="../emergency/emergency.php">Emergency Contact</a>
        </div>
        <div class="nav-right">
            <a href="../Login/login">Login</a>
        </div>
    </nav>


    <aside class="sidebar">
        <h2>Patient Dashboard</h2>
        <ul>
            <li><a href="PatientPortal.php">🏠Home</a></li>
            <li><a href="PatientAppoinment.php">📅 Appointments </a> </li>
            <li><a href="PatientReport.php">📈 Reports </a> </li>
            <li><a href="PatientSettings.php">⚙️Settings </a></li>
            <li><a href="../index.php>"> ➜]Log out</a></li>
        </ul>
    </aside>


    <main class="main-content">
      


        <section class="settings">
            <h2>Settings</h2>

            <div class="setting-card">
                <h3>Profile Settings</h3>
                <label>Full Name:</label>
                <input type="text" placeholder="Enter full name">
                <label>Email:</label>
                <input type="email" placeholder="Enter email">
                <label>Phone Number:</label>
                <input type="text" placeholder="Enter phone number">
                <label>Date of Birth:</label>
                <input type="text" placeholder="DD-MM-YYYY" id="dob">
            </div>


            <div class="setting-card">
                <h3>Account Settings</h3>
                <label>Change Password:</label>
                <input type="password" placeholder="New password">

                <label>Two-Factor Authentication (2FA):</label>
                <div class="toggle-switch">
                    <input type="checkbox" id="2fa-toggle">
                    <label for="2fa-toggle"></label>
                </div>
            </div>
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