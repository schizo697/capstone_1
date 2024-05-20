<?php
include '../conn.php';

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$postal = $_POST['postal'];
$payMethod = $_POST['payMethod'];
$user_id = $_POST['userid'];
$pname = $_POST['pname'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$date_of_order = date('Y-m-d');
$total = $_POST['total'];

// Splitting $prodid into individual values
$prodid_array = explode(',', $_POST['prodid']);

// Update quantities in cart
foreach ($prodid_array as $prod_id) {
    $quantityupdate = "UPDATE cart SET quantity = 0 WHERE prodid = '$prod_id' AND user_id = '$user_id'";
    $quantityupdateres = mysqli_query($conn, $quantityupdate);
    if (!$quantityupdateres) {
        echo 'Error updating quantity in cart';
        exit();
    }
}

// Update user info
$update = "UPDATE user_info SET firstname = '$firstname', lastname = '$lastname', contact = '$phone', address = '$address', postal_code = '$postal' WHERE info_id = '$user_id'";
$updateres = mysqli_query($conn, $update);
if (!$updateres) {
    echo 'Error updating user info';
    exit();
}

// Insert orders
foreach ($prodid_array as $prod_id) {
    $orders = "INSERT INTO orders (user_id, prodid, pname, price, quantity, date_of_order, total) VALUES ('$user_id', '$prod_id', '$pname', '$price', '$quantity', '$date_of_order', '$total')";
    $ordersres = mysqli_query($conn, $orders);
    if (!$ordersres) {
        echo 'Error inserting order';
        exit();
    }
}

$url = "customer_mypurchase.php?success=true";
echo "<script>window.location.href = '$url'; </script>";
exit();
?>
