<?php
session_start();
include("../conn.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$prodid = $data['prodid'];
$status = $data['status'];

$sql = "UPDATE orders SET status = ? WHERE prodid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $status, $prodid);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();
?>
