<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];


    $patient_name = trim($_POST['patient_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $request_for = $_POST['request_for'];

   
    if (empty($patient_name)) {
        $errors[] = "Patient name is required.";
    }

    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (!empty($contact) && !preg_match("/^[0-9]{11}$/", $contact)) {
        $errors[] = "Contact number must be 11 digits.";
    }

    if (empty($request_for)) {
        $errors[] = "Request For is required.";
    }


    if (!empty($errors)) {
        echo "<h3>Form Errors:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><a href='../index.html'>Go Back</a>";
    } else {
        echo "<h3>Form Submitted Successfully ✅</h3>";
        echo "<p><strong>Patient Name:</strong> $patient_name</p>";
        echo "<p><strong>Date of Birth:</strong> $dob</p>";
        echo "<p><strong>Gender:</strong> $gender</p>";
        echo "<p><strong>Contact:</strong> $contact</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Request For:</strong> $request_for</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Request Form</title>
  <link rel="stylesheet" href="appointment.css">
</head>

<body>
  

<nav class="navbar">
    <div class="nav-left">
      <a href="../index.php">Home</a>
      <a href="#">About Us</a>
      <a href="#">Emergency Contact</a>
    </div>
    <div class="nav-right">
      <a href="#">Login</a>
    </div>
  </nav>


  <div class="form-container">
    <h2>Appointment Request Form</h2>
    <form action="submit.php" method="POST">
      <div class="form-row">
        <div class="form-group">
          <label>Patient Name <span>*</span></label>
          <input type="text" name="patient_name" placeholder="Enter Patient Name" required>
        </div>
        <div class="form-group">
          <label>Date of Birth</label>
          <input type="date" name="dob">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Gender <span>*</span></label>
          <select name="gender" required>
            <option value="">Select Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select>
        </div>
        <div class="form-group">
          <label>Contact Number</label>
          <input type="tel" name="contact" placeholder="Enter Contact Number" pattern="[0-9]{11}">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Email <span>*</span></label>
          <input type="email" name="email" placeholder="Enter email address" required>
        </div>
        <div class="form-group">
          <label>Request For <span>*</span></label>
          <select name="request_for" required>
            <option value="">Select Request</option>
            <option>Outpatient Consultation</option>
            <option>Follow-up</option>
            <option>Emergency</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <button type="submit">Submit</button>
      </div>


    </form>
  </div>
</body>
</html>
