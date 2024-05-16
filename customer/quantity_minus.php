<?php
session_start();
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $prodid  = $_POST['prodid'];
    $pname = $_POST['pname'];

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];

        $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND prodid = '$prodid'";
        $checkresult = mysqli_query($conn, $check);

        if($checkresult && mysqli_num_rows($checkresult) > 0){
            $row = mysqli_fetch_assoc($checkresult);
            $quantity = $row['quantity'];

            if($quantity > 1) {
                $update = "UPDATE cart SET quantity = $quantity - 1 WHERE user_id = '$user_id' AND prodid = '$prodid'";
                $updateres = mysqli_query($conn, $update);

                if($updateres){
                    echo json_encode(['newQuantity' => $quantity - 1]);
                } else {
                    echo json_encode(['error' => 'Failed to update quantity']);
                }
            } else {
                // Optionally, you can handle the case where quantity is reduced to 0
                echo json_encode(['error' => 'Cannot reduce quantity below 1']);
            }
        } else {
            echo json_encode(['error' => 'Product not found in cart']);
        }
    } else {
        echo json_encode(['error' => 'User not logged in']);
    }
}
?>
