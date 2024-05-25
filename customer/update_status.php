<?php
// Update status logic

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderId']) && isset($_POST['status'])) {
    include "../conn.php";

    // Sanitize input to prevent SQL injection
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("ii", $status, $orderId);

    // Execute the statement
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Close statement and connection
    $stmt->close();
    mysqli_close($conn);
} else {
    // If orderId or status is not set or request method is not POST
    echo 'error';
}
?>
