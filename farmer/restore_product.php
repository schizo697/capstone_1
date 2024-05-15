<?php
include('../conn.php');

if (isset($_GET['prodid'])) {
    $prodId = $_GET['prodid'];

    $sql = "UPDATE product SET status = 'Available' WHERE prodid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $prodId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
