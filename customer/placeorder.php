<?php
include '../conn.php';

// Function to generate a random order ID
function generateOrderId() {
    return rand(10000, 99999);
}

// Sanitize input data
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$postal = mysqli_real_escape_string($conn, $_POST['postal']);
$payMethod = mysqli_real_escape_string($conn, $_POST['payMethod']);
$user_id = mysqli_real_escape_string($conn, $_POST['userid']);
$date_of_order = date('Y-m-d');
$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
$total = mysqli_real_escape_string($conn, $_POST['total']);

// Split $prodid into individual values
$prodid_array = explode(',', $_POST['prodid']);

// Update user info
$update_query = "UPDATE user_info SET firstname = '$firstname', lastname = '$lastname', contact = '$phone', address = '$address', postal_code = '$postal' WHERE info_id = '$user_id'";
$update_result = mysqli_query($conn, $update_query);
if (!$update_result) {
    echo 'Error updating user info';
    exit();
}

// Generate order ID
$orderid = generateOrderId();

// Insert orders
foreach ($prodid_array as $prod_id) {
    // Fetch product details
    $product_query = "SELECT * FROM product WHERE prodid = '$prod_id'";
    $product_result = mysqli_query($conn, $product_query);
    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product_row = mysqli_fetch_assoc($product_result);
        $prodname = $product_row['pname'];
        $prodprice = $product_row['price'];

        // Fetch cart quantity
        $quantity_query = "SELECT quantity FROM cart WHERE prodid = '$prod_id' AND user_id = '$user_id'";
        $quantity_result = mysqli_query($conn, $quantity_query);
        if ($quantity_result && mysqli_num_rows($quantity_result) > 0) {
            $quantity_row = mysqli_fetch_assoc($quantity_result);
            $prodquantity = $quantity_row['quantity'];

                    $orders = "INSERT INTO orders (order_id, user_id, prodid, pname, price, quantity, date_of_order, total) VALUES ('$orderid', '$user_id', '$prod_id', '$prodname', '$prodprice', '$prodquantity', '$date_of_order', '$total')";
                    $ordersres = mysqli_query($conn, $orders);
                    if ($ordersres) {
                        $oder_update = "UPDATE product SET quantity = quantity - $order_quantity WHERE prodid = '$prod_id'";
                        $oder_updateres = mysqli_query($conn, $oder_update);
                
                        if(!$oder_updateres){
                            echo 'Error updating order';
                            exit();
                        }
                    } else {
                        echo 'Error inserting order';
                        exit();
                    }
                }
            }
        }
    }
}

// Delete items from cart
foreach ($prodid_array as $prod_id) {
    $quantityupdate = "UPDATE cart SET quantity = 0 WHERE prodid = '$prod_id' AND user_id = '$user_id'";
    $quantityupdateres = mysqli_query($conn, $quantityupdate);
    if (!$quantityupdateres) {
        echo 'Error updating quantity in cart';
        exit();
    }
}

// Redirect to success page
$url = "customer_mypurchase.php?success=true";
echo "<script>window.location.href = '$url'; </script>";
exit();
?>
