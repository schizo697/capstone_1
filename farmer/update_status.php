<?php
// Update status logic

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderId']) && isset($_POST['status'])) {
    include "../conn.php";

    // Sanitize input to prevent SQL injection
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status in the database
    $sql = "UPDATE orders SET status = '$status' WHERE order_id = '$orderId'";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }

    mysqli_close($conn);
} else {
    // If orderId or status is not set or request method is not POST
    echo 'error';
}
?>
