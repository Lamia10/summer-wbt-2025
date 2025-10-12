<?php
$successMsg = $patient_idErr = $dateErr = $timeErr = $requestForErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"] ?? "";
    $doctor_id = $_POST["doctor_id"] ?? "";
    $doctor_name = $_POST["doctor_name"] ?? "";
    $department = $_POST["department"] ?? "";
    $appointment_date = $_POST["appointment_date"] ?? "";
    $appointment_time = $_POST["appointment_time"] ?? "";
    $request_for = $_POST["request_for"] ?? "";

    // Emergency redirect
    if ($request_for === "Emergency") {
        header("Location: ../emergency/emergency.php");
        exit();
    }

    // Validation
    if (empty($patient_id)) $patient_idErr = "Patient ID is required";
    if (empty($appointment_date)) $dateErr = "Date is required";
    if (empty($appointment_time)) $timeErr = "Time is required";
    if (empty($request_for)) $requestForErr = "Please select a request type";

    if (empty($patient_idErr) && empty($dateErr) && empty($timeErr) && empty($requestForErr)) {
        include '../myDB/db.php';

        $stmt = $conn->prepare("INSERT INTO appointmentdb (patient_id, doctor_id, appointment_date, appointment_time, status) 
                                VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iiss", $patient_id, $doctor_id, $appointment_date, $appointment_time);

        if ($stmt->execute()) {
            $successMsg = "Appointment booked successfully!";
        } else {
            $successMsg = "Error: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Appointment</title>
<link rel="stylesheet" href="appointment.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar">
    <div class="nav-left">
        <a href="../index.php">Home</a>
        <a href="../about us/aboutus.php">About Us</a>
        <a href="../emergency/emergency.php">Emergency Contact</a>
    </div>
</nav>

<!-- Main Content Center -->
<div class="main-content">
    <div class="form-container">
        <h2>Book Appointment</h2>
        <?php if (!empty($successMsg)) echo "<p class='success'>$successMsg</p>"; ?>

        <form method="POST" action="">
            <!-- Patient ID + Request For -->
            <div class="form-row">
                <div class="form-group">
                    <label>Patient ID <span>*</span></label>
                    <input type="number" name="patient_id" required>
                    <span class="error"><?php echo $patient_idErr; ?></span>
                </div>

                <div class="form-group">
                    <label>Request For <span>*</span></label>
                    <select name="request_for" required>
                        <option value="">--Select Request--</option>
                        <option value="Outpatient Consultation">Outpatient Consultation</option>
                        <option value="Follow-up">Follow-up</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                    <span class="error"><?php echo $requestForErr; ?></span>
                </div>
            </div>

            <!-- Doctor Name + Department -->
            <div class="form-row">
                <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" name="doctor_name" value="<?php echo $_GET['doctor_name'] ?? ''; ?>" readonly>
                    <input type="hidden" name="doctor_id" value="<?php echo $_GET['doctor_id'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <input type="text" name="department" value="<?php echo $_GET['department'] ?? ''; ?>" readonly>
                </div>
            </div>

            <!-- Date + Time -->
            <div class="form-row">
                <div class="form-group">
                    <label>Appointment Date <span>*</span></label>
                    <input type="date" name="appointment_date" required>
                    <span class="error"><?php echo $dateErr; ?></span>
                </div>
                <div class="form-group">
                    <label>Appointment Time <span>*</span></label>
                    <input type="time" name="appointment_time" required>
                    <span class="error"><?php echo $timeErr; ?></span>
                </div>
            </div>

            <button type="submit">Confirm Appointment</button>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2025 E-Doctor's Appointment System. All rights reserved.</p>
</div>
</body>
</html>
