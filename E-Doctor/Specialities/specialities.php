<?php
// Database connection
$host = "localhost";
$user = "root";   
$pass = "";      
$db   = "edoctor";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch specialities
$sql = "SELECT * FROM specialities";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Specialities</title>
  <link rel="stylesheet" href="specialities.css">
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

  <!-- Specialities Section -->
  <section class="specialities">
    <h2>Our Specialities</h2>

    <div class="specialities-grid">
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="speciality-card">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <p><?php echo htmlspecialchars($row['name']); ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No specialities available right now.</p>
      <?php endif; ?>
    </div>

    <div class="specialities-footer">
      <button class="view-btn">View All Specialities</button>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
  </footer>
</body>
</html>

<?php $conn->close(); ?>
