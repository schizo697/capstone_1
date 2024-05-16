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

        .logo {
            max-height: 120px;
            width: auto;
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
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
                                        $cart = "SELECT cart.prodid, cart.user_id, cart.pname, cart.quantity, product.price, listing.imgid FROM cart 
                                        JOIN product ON cart.prodid = product.prodid
                                        JOIN listing ON cart.prodid = listing.prodid
                                        WHERE user_id = '$user_id';";
                                        $cartresult = mysqli_query($conn, $cart);

                                        if($cartresult && mysqli_num_rows($cartresult) > 0) {
                                            while($cartrow = mysqli_fetch_assoc($cartresult)){
                                                
                                                $imgPath = "../img/products/".$cartrow['imgid'];
                                                if(file_exists($imgPath)) { 
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <figure class="itemside align-items-center">
                                                                <div class="aside"><img src="<?php echo $imgPath ?>" class="img-sm"></div>
                                                                <figcaption class="info"> <a href="#" class="title text-dark" data-abc="true"><?php echo $cartrow['pname']; ?></a>
                                                                    <p class="text-muted small">SIZE: L <br> Brand: MAXTRA</p>
                                                                </figcaption>
                                                            </figure>
                                                        </td>
                                                        <td> 
                                                            <div class="input-group">
                                                                <button class="btn btn-outline-secondary quantity-minus" type="button" data-prodid="<?php echo $cartrow['prodid']; ?>" data-pname="<?php echo $cartrow['pname']; ?>">-</button>
                                                                <label class="form-control quantity-label" name="quantity"><?php echo $cartrow['quantity']; ?></label>
                                                                <button class="btn btn-outline-secondary quantity-add" type="button" data-prodid="<?php echo $cartrow['prodid']; ?>" data-pname="<?php echo $cartrow['pname']; ?>">+</button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="price-wrap"> <var class="price">₱ <?php echo $cartrow['price']?></var> <small class="text-muted">Per kilo</small> </div>
                                                        </td>
                                                        <td class="text-right d-none d-md-block">
                                                            <a href="" class="btn btn-light" data-abc="true"> Remove</a> 
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
                                <dl class="dlist-align">
                                    <dt>Total price:</dt>
                                    <dd class="text-right ml-3">$69.97</dd>
                                </dl>
                                <dl class="dlist-align">
                                    <dt>Discount:</dt>
                                    <dd class="text-right text-danger ml-3">- $10.00</dd>
                                </dl>
                                <dl class="dlist-align">
                                    <dt>Total:</dt>
                                    <dd class="text-right text-dark b ml-3"><strong>$59.97</strong></dd>
                                </dl>
                                <hr> 
                                <a href="#" class="btn btn-out btn-primary btn-square btn-main" data-abc="true"> Place Order </a> 
                                <a href="#" class="btn btn-out btn-success btn-square btn-main mt-2" data-abc="true">Shop More</a>
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
        $(document).ready(function() {
            $(".quantity-minus").click(function(event) {
                event.preventDefault();
                var prodid = $(this).data('prodid');
                var pname = $(this).data('pname');
                var $quantityInput = $(this).siblings('.quantity-label');

                $.ajax({
                    url: 'quantity_minus.php',
                    type: 'POST',
                    data: {
                        prodid: prodid,
                        pname: pname,
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.newQuantity !== undefined) {
                            $quantityInput.text(data.newQuantity);
                        } else {
                            alert(data.error || "An error occurred.");
                        }
                    },
                    error: function(error) {
                        console.error(error);
                        alert("An error occurred.");
                    }
                });
            });

            $(".quantity-add").click(function(event) {
                event.preventDefault();
                var prodid = $(this).data('prodid');
                var pname = $(this).data('pname');
                var $quantityInput = $(this).siblings('.quantity-label');

                $.ajax({
                    url: 'quantity_add.php',
                    type: 'POST',
                    data: {
                        prodid: prodid,
                        pname: pname,
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.newQuantity !== undefined) {
                            $quantityInput.text(data.newQuantity);
                        } else {
                            alert(data.error || "An error occurred.");
                        }
                    },
                    error: function(error) {
                        console.error(error);
                        alert("An error occurred.");
                    }
                });
            });
        });
    </script>




    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
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