<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . '/../myDB/db.php'; // mysqli connection $conn

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'doctor') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$doctorId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$id || !in_array($action, ['approve', 'decline'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
        exit;
    }

    $status = $action === 'approve' ? 'Approved' : 'Declined';

    $stmt = $conn->prepare("UPDATE appointmentDB SET status=? WHERE id=? AND doctor_id=?");
    $stmt->bind_param("sii", $status, $id, $doctorId);
    $updated = $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => $updated]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);
?>
