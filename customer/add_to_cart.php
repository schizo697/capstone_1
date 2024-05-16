<?php
session_start();
include '../conn.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prodid = $_POST['prodid'];
    $pname = $_POST['pname'];

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        
        $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND prodid = '$prodid'";
        $checkresult = mysqli_query($conn, $check);

        if($checkresult && mysqli_num_rows($checkresult) > 0){
            // Fetch current quantity
            $row = mysqli_fetch_assoc($checkresult);
            $quantity = $row['quantity'];
            
            // Update quantity
            $update = "UPDATE cart SET quantity = $quantity + 1 WHERE user_id = '$user_id' AND prodid = '$prodid'";
            $updateResult = mysqli_query($conn, $update);

            if($updateResult){
                echo "Product added to cart successfully!";
            } else {
                echo 'Error updating quantity: ' . mysqli_error($conn);
            }
        } else {
            $sql = "INSERT INTO cart (prodid, user_id, pname, quantity) VALUES ('$prodid', '$user_id', '$pname', 1)";
        
            if (mysqli_query($conn, $sql)) {
                echo "Product added to cart successfully!";
            } else {
                echo "Error inserting product into cart: " . mysqli_error($conn);
            }
        }
    } else {
        echo 'Error: session';
    }
}
?>
