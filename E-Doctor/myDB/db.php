<?php
$host = 'localhost';
$db   = 'edoctor';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysqli:host=$host;dbname=$db;charset=$charset";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset($charset);
?>
