<?php
$host = "127.0.0.1";
$user = "root";      // default for XAMPP
$pass = "";          // default password is empty
$dbname = "product_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
