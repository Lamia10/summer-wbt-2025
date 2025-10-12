<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'authority') {
    header("Location: ../Login/login.php");
    exit;
}

include '../myDB/db.php';

// Get patient ID from URL
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM patientDB WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Patient deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete patient.";
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid patient ID.";
}

$conn->close();

// Redirect back to ManagePatient page
header("Location: ManagePatient.php");
exit;
?>
