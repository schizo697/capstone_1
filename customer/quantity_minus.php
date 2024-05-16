<?php
session_start();
include '../conn.php';

if (isset($_GET['prodid']) && isset($_GET['pname'])) {
    $prodid = $_GET['prodid'];
    $pname = $_GET['pname'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND prodid = '$prodid'";
        $checkresult = mysqli_query($conn, $check);

        if ($checkresult && mysqli_num_rows($checkresult) > 0) {
            $row = mysqli_fetch_assoc($checkresult);
            $quantity = $row['quantity'];

            if ($quantity > 0) {
                $update = "UPDATE cart SET quantity = quantity - 1 WHERE user_id = '$user_id' AND prodid = '$prodid'";
                $updateres = mysqli_query($conn, $update);
                if ($updateres) {
                    header("Location: customer_cart.php");
                    exit();
                }
            } else {
                echo "Quantity cannot be less than 0.";
            }
        } else {
            echo "No item found in the cart.";
        }
    } else {
        echo "User not logged in.";
    }
} else {
    echo 'Invalid request.';
}
?>
