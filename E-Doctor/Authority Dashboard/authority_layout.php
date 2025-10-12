<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}
$user = $_SESSION['user'];

include '../myDB/db.php';

// Fetch summary stats
$totalDoctors = $conn->query("SELECT COUNT(*) AS cnt FROM doctorDB")->fetch_assoc()['cnt'];
$totalPatients = $conn->query("SELECT COUNT(*) AS cnt FROM patientDB")->fetch_assoc()['cnt'];
$totalAppointments = $conn->query("SELECT COUNT(*) AS cnt FROM appointmentDB")->fetch_assoc()['cnt'];

$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM appointmentDB WHERE appointment_date = ?");
$today = date('Y-m-d');
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$todayAppointments = $result['cnt'];
$stmt->close();

// Fetch recent doctors
$recentDoctors = [];
$result = $conn->query("SELECT * FROM doctorDB ORDER BY created_at DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    $recentDoctors[] = $row;
}
$result->free();

// Fetch recent patients
$recentPatients = [];
$result = $conn->query("SELECT * FROM patientDB ORDER BY created_at DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    $recentPatients[] = $row;
}
$result->free();

// Fetch recent appointments
$recentAppointments = [];
$sql = "
    SELECT a.id, p.name AS patient, d.name AS doctor, a.status, a.appointment_date 
    FROM appointmentDB a
    JOIN patientDB p ON a.patient_id = p.id
    JOIN doctorDB d ON a.doctor_id = d.id
    ORDER BY a.created_at DESC LIMIT 5
";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $recentAppointments[] = $row;
}
$result->free();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authority Dashboard</title>
    <link rel="stylesheet" href="authority.css">
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
    <a href="authority.php" class="active">📊 Dashboard</a>
    <a href="ManageDoc.php">🧑‍⚕️ Manage Doctors</a>
    <a href="ManagePatient.php">👨‍💼 Manage Patients</a>
    <a href="Reports.php">📈 Reports</a>
    <a href="Settings.php">⚙️ Settings</a>
</div>

<!-- Main content -->
<div class="main">
    <div class="topbar">
        <h1>Dashboard</h1>
        <div class="profile">
            <span><?= htmlspecialchars($user['name']); ?></span>
            <img src="https://via.placeholder.com/35" alt="profile">
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="cards">
        <div class="card">
            <h3>Total Doctors</h3>
            <p><?= $totalDoctors ?></p>
        </div>
        <div class="card">
            <h3>Total Patients</h3>
            <p><?= $totalPatients ?></p>
        </div>
        <div class="card">
            <h3>Total Appointments</h3>
            <p><?= $totalAppointments ?></p>
        </div>
        <div class="card">
            <h3>Today’s Appointments</h3>
            <p><?= $todayAppointments ?></p>
        </div>
    </div>

    <!-- Recent Doctors -->
    <div class="recent-section">
        <h2>Recent Doctors</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Specialty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentDoctors as $doc): ?>
                <tr>
                    <td><?= $doc['id'] ?></td>
                    <td><?= htmlspecialchars($doc['name']) ?></td>
                    <td><?= htmlspecialchars($doc['email']) ?></td>
                    <td><?= htmlspecialchars($doc['specialty']) ?></td>
                    <td>
                        <a href="editDoctor.php?id=<?= $doc['id'] ?>">Edit</a> | 
                        <a href="deleteDoctor.php?id=<?= $doc['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Recent Patients -->
    <div class="recent-section">
        <h2>Recent Patients</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentPatients as $pat): ?>
                <tr>
                    <td><?= $pat['id'] ?></td>
                    <td><?= htmlspecialchars($pat['name']) ?></td>
                    <td><?= htmlspecialchars($pat['email']) ?></td>
                    <td><?= htmlspecialchars($pat['phone']) ?></td>
                    <td>
                        <a href="editPatient.php?id=<?= $pat['id'] ?>">Edit</a> | 
                        <a href="deletePatient.php?id=<?= $pat['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Recent Appointments -->
    <div class="recent-section">
        <h2>Recent Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentAppointments as $app): ?>
                <tr>
                    <td><?= $app['id'] ?></td>
                    <td><?= htmlspecialchars($app['patient']) ?></td>
                    <td><?= htmlspecialchars($app['doctor']) ?></td>
                    <td><?= htmlspecialchars($app['status']) ?></td>
                    <td><?= $app['appointment_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Footer -->
<footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>

</body>
</html>
