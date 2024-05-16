<?php 
session_start();
include '../conn.php';

if(isset($_GET['prodid'])){
    $prodid = $_GET['prodid'];

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];

        $remove = "DELETE FROM cart WHERE user_id = '$user_id' AND prodid = '$prodid'";
        $removeresult = mysqli_query($conn, $remove);

        if($removeresult){
            header("Location: customer_cart.php");
            exit();
        } else {
            // Handle the case where deletion fails
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
