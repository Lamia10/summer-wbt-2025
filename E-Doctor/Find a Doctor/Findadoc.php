<?php
include '../myDB/db.php'; // mysqli connection

$departmentFilter = $_GET['department'] ?? '';
$nameSearch = $_GET['name'] ?? '';

// Base query
$query = "SELECT * FROM doctordb WHERE 1";
$params = [];
$types = "";

// Department filter
if (!empty($departmentFilter)) {
    $query .= " AND specialty = ?";
    $params[] = $departmentFilter;
    $types .= "s";
}

// Name search filter
if (!empty($nameSearch)) {
    $query .= " AND name LIKE ?";
    $params[] = "%" . $nameSearch . "%";
    $types .= "s";
}

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$doctors = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Find a Doctor</title>
<link rel="stylesheet" href="findadoc.css">
</head>
<body>
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

<section class="search-section">
    <h2>Search Doctors</h2>
    <form method="GET" class="search-box">
        <select name="department" id="departmentFilter">
            <option value="">Select Department</option>
            <option value="Accident & Emergency" <?= $departmentFilter=='Accident & Emergency'?'selected':'' ?>>Accident & Emergency</option>
            <option value="Urology" <?= $departmentFilter=='Urology'?'selected':'' ?>>Urology</option>
            <option value="Cancer Care Centre" <?= $departmentFilter=='Cancer Care Centre'?'selected':'' ?>>Cancer Care Centre</option>
            <option value="Cardiology Care Centre" <?= $departmentFilter=='Cardiology Care Centre'?'selected':'' ?>>Cardiology Care Centre</option>
            <option value="Ophthalmology" <?= $departmentFilter=='Ophthalmology'?'selected':'' ?>>Ophthalmology</option>
            <option value="Nephrologist" <?= $departmentFilter=='Nephrologist'?'selected':'' ?>>Nephrologist</option>
            <option value="Counselling Centre" <?= $departmentFilter=='Counselling Centre'?'selected':'' ?>>Counselling Centre</option>
            <option value="Critical Care Units" <?= $departmentFilter=='Critical Care Units'?'selected':'' ?>>Critical Care Units</option>
            <option value="Dental & Maxillofacial Surgery" <?= $departmentFilter=='Dental & Maxillofacial Surgery'?'selected':'' ?>>Dental & Maxillofacial Surgery</option>
            <option value="Dermatology & Venereology" <?= $departmentFilter=='Dermatology & Venereology'?'selected':'' ?>>Dermatology & Venereology</option>
            <option value="Diabetology & Endocrinology" <?= $departmentFilter=='Diabetology & Endocrinology'?'selected':'' ?>>Diabetology & Endocrinology</option>
            <option value="Cardiothoracic Anaesthesia" <?= $departmentFilter=='Cardiothoracic Anaesthesia'?'selected':'' ?>>Cardiothoracic Anaesthesia</option>
        </select>

        <input type="text" name="name" id="nameSearch" placeholder="Search by doctor name" value="<?= htmlspecialchars($nameSearch) ?>">
        <button class="search-btn" type="submit">Search
        </button>
    </form>
</section>

<section class="doctor-list" id="doctorList">
<?php if($doctors): ?>
    <?php foreach($doctors as $doc): ?>
        <div class="doctor-card" data-name="<?= htmlspecialchars($doc['name']) ?>" data-department="<?= htmlspecialchars($doc['specialty']) ?>">
            <img src="<?= htmlspecialchars($doc['photo']) ?: 'images/default.png' ?>" alt="<?= htmlspecialchars($doc['name']) ?>" onerror="this.src='images/default.png'">
            <h4><?= htmlspecialchars($doc['name']) ?></h4>
            <p><?= htmlspecialchars($doc['specialty']) ?></p>
            
            <div class="doc-actions-vertical">
                <a href="viewprofile.php?id=<?= $doc['id']; ?>" class="btn">View Profile</a>
                <a href="../Appointment/appointment.php?doctor_id=<?= $doc['id']; ?>&doctor_name=<?= urlencode($doc['name']); ?>&department=<?= urlencode($doc['specialty']); ?>" class="btn">Book Appointment</a>
            </div>
        </div>
        

    <?php endforeach; ?>
<?php else: ?>
    <p>No doctors found.</p>
<?php endif; ?>
</section>

<footer class="footer">
  <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>
</body>
</html>
