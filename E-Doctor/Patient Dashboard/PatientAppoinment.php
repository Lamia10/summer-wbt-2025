<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="PatientAppoinment.css">
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
            <li><a href="PatientAppoinment.php"> 📅Appointments </a> </li>
            <li><a href="PatientReport.php">📈 Reports </a> </li>
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
            <div class="appointment-card">
                <div class="appointment-info">
                    <h3>Dr. Rahman <span>(Cardiologist)</span></h3>
                    <p>Date: 15 Sept, 3:00 PM</p>
                    <p>Status: <span class="status confirmed">Confirmed</span></p>
                </div>
                <div class="appointment-actions">
                    <button>View</button>
                    <button>Cancel</button>
                </div>
            </div>

            <div class="appointment-card">
                <div class="appointment-info">
                    <h3>Dr. Ayesha <span>(Dentist)</span></h3>
                    <p>Date: 20 Sept, 11:00 AM</p>
                    <p>Status: <span class="status pending">Pending</span></p>
                </div>
                <div class="appointment-actions">
                    <button>View</button>
                    <button>Reschedule</button>
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