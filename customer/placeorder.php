<?php
include '../conn.php';

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$postal = $_POST['postal'];
$payMethod = $_POST['payMethod'];
$user_id = $_POST['userid'];
$date_of_order = date('Y-m-d');
$total = $_POST['total'];

// Splitting $prodid into individual values
$prodid_array = explode(',', $_POST['prodid']);

// Update user info
$update = "UPDATE user_info SET firstname = '$firstname', lastname = '$lastname', contact = '$phone', address = '$address', postal_code = '$postal' WHERE info_id = '$user_id'";
$updateres = mysqli_query($conn, $update);
if (!$updateres) {
    echo 'Error updating user info';
    exit();
}

function generateOrderId() {
    return rand(10000, 99999);
}

$orderid = generateOrderId();

// Insert orders
foreach ($prodid_array as $prod_id) {
    //product
    $product = "SELECT * FROM product WHERE prodid IN ($prod_id)";
    $productres = mysqli_query($conn, $product);
    if($productres && mysqli_num_rows($productres) > 0){
        while($productrow = mysqli_fetch_assoc($productres)){
            $prodname = $productrow['pname'];
            $prodprice = $productrow['price'];

            //cart quantity
            $quantity = "SELECT * FROM cart WHERE prodid IN ($prod_id)";
            $quantityres = mysqli_query($conn, $quantity);
            if($quantityres && mysqli_num_rows($quantityres) > 0){
                while($quantityrow = mysqli_fetch_assoc($quantityres)){
                    $prodquantity = $quantityrow['quantity'];

                    $orders = "INSERT INTO orders (order_id, user_id, prodid, pname, price, quantity, date_of_order, total) VALUES ('$orderid', '$user_id', '$prod_id', '$prodname', '$prodprice', '$prodquantity', '$date_of_order', '$total')";
                    $ordersres = mysqli_query($conn, $orders);
                    if (!$ordersres) {
                        echo 'Error inserting order';
                        exit();
                    }
                }
            }
        }
    }
}

// Update quantities in cart
foreach ($prodid_array as $prod_id) {
    $quantityupdate = "UPDATE cart SET quantity = 0 WHERE prodid = '$prod_id' AND user_id = '$user_id'";
    $quantityupdateres = mysqli_query($conn, $quantityupdate);
    if (!$quantityupdateres) {
        echo 'Error updating quantity in cart';
        exit();
    }
}

$url = "customer_mypurchase.php?success=true";
echo "<script>window.location.href = '$url'; </script>";
exit();
?>
