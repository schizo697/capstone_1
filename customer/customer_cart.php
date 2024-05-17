<?php 
include('includes/header.php');
include('includes/footer.php');
include('../conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Farmer's Market</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        <?php 
            include '../main/css/style.css'; 
            include '../main/css/bootstrap.min.css';
            include 'css/customer_cart.css';
        ?>

.bg-green {
    background-color: #34AD54!important;
}
    </style>
</head>

<body>
<div class="container-fluid bg-green text-white py-4">
        <div class="container text-center">
            <p class="mb-0"><a class="text-secondary fw-bold" ></a></p>
        </div>
    </div>
    <!-- body -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <aside class="col-lg-9">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-borderless table-shopping-cart">
                                    <thead class="text-muted">
                                        <tr class="small text-uppercase">
                                            <th scope="col">Product</th>
                                            <th scope="col" width="120">Quantity</th>
                                            <th scope="col" width="120">Price</th>
                                            <th scope="col" class="text-right d-none d-md-block" width="200"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(isset($_SESSION['user_id'])){
                                        $user_id = $_SESSION['user_id'];
                                        $cart = "SELECT cart.prodid, cart.user_id, cart.pname, cart.quantity, product.price, product.status, listing.imgid FROM cart 
                                        JOIN product ON cart.prodid = product.prodid
                                        JOIN listing ON cart.prodid = listing.prodid
                                        WHERE user_id = '$user_id' AND cart.quantity > 0";
                                        $cartresult = mysqli_query($conn, $cart);

                                        if($cartresult && mysqli_num_rows($cartresult) > 0) {
                                            while($cartrow = mysqli_fetch_assoc($cartresult)){

                                                $imgPath = "../img/products/".$cartrow['imgid'];
                                                if(file_exists($imgPath)) { 
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <figure class="itemside align-items-center">
                                                                <div class="aside">
                                                                    <input type="checkbox" name="select_item[]" value="<?php echo $cartrow['prodid']; ?>" class="mr-2" onclick="updateSelectedItems(this)">
                                                                    <img src="<?php echo $imgPath ?>" class="img-sm">
                                                                </div>
                                                                <figcaption class="info">
                                                                    <a href="#" class="title text-dark" data-abc="true"><?php echo $cartrow['pname']; ?></a>
                                                                    <p class="text-muted small"><?php echo $cartrow['status'] ?></p>
                                                                </figcaption>
                                                            </figure>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <a href="quantity_minus.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                    <button class="btn btn-outline-secondary quantity-minus" type="button">-</button>
                                                                </a>
                                                                <label class="form-control quantity-label" name="quantity"><?php echo $cartrow['quantity']; ?></label>
                                                                <a href="quantity_add.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                    <button class="btn btn-outline-secondary quantity-minus" type="button">+</button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="price-wrap">
                                                                <var class="price">₱ <?php echo $cartrow['price']?></var>
                                                                <small class="text-muted">Per kilo</small>
                                                            </div>
                                                        </td>
                                                        <td class="text-right d-none d-md-block">
                                                            <a href="cart_remove.php?prodid=<?php echo $cartrow['prodid'] ?>">
                                                                <button class="btn btn-outline-danger quantity-minus" type="button">Remove</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    echo "Image file does not exist: ".$imgPath;
                                                }
                                            }
                                        }
                                    } 
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </aside>
                    <aside class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                            <?php
                            $checkout = "SELECT cart.prodid, cart.user_id, cart.pname, cart.quantity, product.price, listing.imgid FROM cart 
                            JOIN product ON cart.prodid = product.prodid
                            JOIN listing ON cart.prodid = listing.prodid
                            WHERE user_id = '$user_id' AND cart.quantity > 0";
                            $checkoutres = mysqli_query($conn, $checkout);

                            $totalPrice = 0;
                            if ($checkoutres && mysqli_num_rows($checkoutres) > 0) {
                            ?>
                                <dl class="dlist-align">
                                    <dt>Item</dt>
                                    <dt class="ml-auto">Quantity</dt>
                                    <dt class="text-right ml-auto">Price</dt>
                                </dl>
                                <?php
                                while ($checkoutrow = mysqli_fetch_assoc($checkoutres)) {
                                    $prodid = $checkoutrow['prodid'];
                                    $pname = $checkoutrow['pname'];
                                    $price = $checkoutrow['price'];
                                    $quantity = $checkoutrow['quantity'];
                                    $totalItemPrice = $price * $quantity;
                                    $totalPrice += $totalItemPrice;
                                ?>
                                <dl class="dlist-align">
                                    <dt><?php echo $pname; ?></dt>
                                    <dt class="ml-auto"><?php echo $quantity ?></dt>
                                    <dd class="text-right ml-auto">₱<?php echo $totalItemPrice; ?></dd>
                                </dl>
                                <?php
                                }
                                ?>
                                <hr>
                                <dl class="dlist-align">
                                    <dt>Total:</dt>
                                    <dd class="text-right text-dark b ml-3"><strong>₱<?php echo $totalPrice; ?></strong></dd>
                                </dl>
                                <hr>

                                <!-- Payment Method Selection -->
                                <?php
                                if(isset($_POST['btnOrder'])){
                                    $selected_prodids = explode(',', $_POST['selected_prodid']);
                                    $pname = $_POST['pname'];
                                    $quantity = $_POST['quantity'];
                                    $priceperprod = $_POST['priceperprod'];
                                    $total_price = $_POST['total_price'];
                                    $payment_method = $_POST['payment_method'];

                                    $success = true;

                                    foreach($selected_prodids as $prodid){
                                        $order = "INSERT INTO orders (prodid, user_id, pname, quantity, price_per_prod, total_price, payment_method) VALUES ('$prodid', '$user_id', '$pname', '$quantity', '$priceperprod', '$total_price', '$payment_method')";
                                        $orderresult = mysqli_query($conn, $order);

                                        if ($orderresult) {
                                            $update = "UPDATE cart SET quantity = 0 WHERE user_id = '$user_id' AND prodid = '$prodid'";
                                            $updateres = mysqli_query($conn, $update);
                                            
                                            if(!$updateres) {
                                                $success = false;
                                                break;
                                            }
                                        } else {
                                            $success = false;
                                            break;
                                        }
                                    }

                                    if ($success) {
                                        $url = "customer_cart.php?success=true";
                                    } else {
                                        $url = "customer_cart.php?error=true";
                                    }
                                    echo "<script>window.location.href='" . $url . "'</script>";
                                    exit();
                                }
                                ?>

                                <form action="" method="POST">
                                    <div>
                                        <input type="radio" id="cod" name="payment_method" value="cod" checked>
                                        <label for="cod">Cash on Delivery (COD)</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="gcash" name="payment_method" value="gcash">
                                        <label for="gcash">GCash</label>
                                    </div>

                                    <input type="hidden" name="selected_prodid" value="">
                                    <input type="hidden" name="pname" value="<?php echo $pname; ?>">
                                    <input type="hidden" name="price" value="<?php echo $totalPpricerice; ?>">
                                    <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                                    <input type="hidden" name="priceperprod" value="<?php echo $totalItemPrice; ?>">
                                    <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
                                    <button type="submit" name="btnOrder" class="btn btn-out btn-primary btn-square btn-main" data-abc="true">Check out</button>
                                    <a href="customer_dashboard.php" class="btn btn-out btn-success btn-square btn-main mt-2" data-abc="true">Shop More</a>
                                </form>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- body -->
    <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
        </div>
    </div>
    <!-- Footer End -->

    <script>
    function updateSelectedItems(checkbox) {
        const selectedInput = document.querySelector('input[name="selected_prodid"]');
        let selectedItems = selectedInput.value ? selectedInput.value.split(',') : [];
        
        if (checkbox.checked) {
            selectedItems.push(checkbox.value);
        } else {
            selectedItems = selectedItems.filter(item => item !== checkbox.value);
        }
        
        selectedInput.value = selectedItems.join(',');
    }
    </script>


    <script>
        function showAlert(type, message) {
            Swal.fire({
                icon: type,
                text: message,
            });
        }

        function checkURLParams() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success') && urlParams.get('success') === 'true') {
                showAlert('success', 'Checkout successfully!');
            } else if (urlParams.has('error') && urlParams.get('error') === 'true') {
                showAlert('warning', 'An error occurred!');
            } 
        }

        window.onload = checkURLParams;
    </script>

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../main/js/main.js"></script>
</body>

</html>