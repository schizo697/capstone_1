<?php 
include('includes/header.php');
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

    <!-- Custom Stylesheet -->
    <link href="../main/css/style.css" rel="stylesheet">
    <link href="../main/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/customer_cart.css" rel="stylesheet">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
       body {
           margin-top: 20px;
           background: white;
       }
       .ui-w-40 {
           width: 40px !important;
           height: auto;
       }
       .card {
           box-shadow: 0 1px 15px 1px rgba(52,40,104,.08);
       }
       .ui-product-color {
           display: inline-block;
           overflow: hidden;
           margin: .144em;
           width: .875rem;
           height: .875rem;
           border-radius: 10rem;
           -webkit-box-shadow: 0 0 0 1px rgba(0,0,0,0.15) inset;
           box-shadow: 0 0 0 1px rgba(0,0,0,0.15) inset;
           vertical-align: middle;
       }
       .bg-green {
           background-color: #34AD54 !important;
       }
       <style>
        /* Modal styling */
        .modal-content {
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        .modal-header .modal-title {
            font-weight: bold;
        }

        .modal-header .close {
            margin-top: -10px;
        }

        .modal-body {
            padding: 2rem;
            background-color: #fff;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        .product-modal-content {
            text-align: center;
        }

        .product-modal-content h5 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #333;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-price {
            font-size: 1.25rem;
            color: #007bff;
            margin-bottom: 10px;
        }

        .product-details {
            font-size: 1rem;
            color: #555;
        }
    </style>
    </style>
</head>

<body>
    <div class="container-fluid bg-green text-white py-4">
        <div class="container text-center">
            <!-- Add any content you want for the header here -->
        </div>
    </div>

    <div class="content-wrapper">
        <div class="container-xl px-4 mt-4">
            <nav class="nav nav-borders">
                <a class="nav-link active ms-0" href="customer_profile.php">Profile</a>
                <a class="nav-link" href="customer_mypurchase.php">My Purchases</a>
                <a class="nav-link" href="#">Chats</a>
            </nav>
            <hr class="mt-0 mb-4">
            
            <!-- Add Tabs Here -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="to-pay-tab" data-toggle="tab" href="#to-pay" role="tab" aria-controls="to-pay" aria-selected="true">To Pay</a>
                </li>
               
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="to-receive-tab" data-toggle="tab" href="#to-receive" role="tab" aria-controls="to-receive" aria-selected="false">To Receive</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="to-pay" role="tabpanel" aria-labelledby="to-pay-tab">
                    <div class="container px-3 my-5 clearfix">
                        <!-- Shopping cart table for To Pay -->
                        <div class="card">
                            <div class="card-header">
                                <h2>Shopping Cart - To Pay</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered m-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center py-3 px-4" style="width: 30px;">Product Name &amp; Details</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                                <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
    <?php
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $cart = "SELECT orders.order_id, orders.user_id, orders.prodid, orders.pname, orders.price, orders.quantity, orders.total, product.pname AS product_name, listing.details, listing.imgid
        FROM orders
        JOIN product ON orders.prodid = product.prodid
        JOIN listing ON listing.prodid = product.prodid
        WHERE orders.status = 1";
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
                                    <p class="text-muted small"><?php echo $cartrow['details'] ?></p>
                                </figcaption>
                            </figure>
                        </td>
                        <td>
                            <div class="input-group">
                                <a href="quantity_minus.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                    <!-- Add minus button content if needed -->
                                </a>
                                <label class="form-control quantity-label" name="quantity"><?php echo $cartrow['quantity']; ?></label>
                                <a href="quantity_add.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                    <!-- Add plus button content if needed -->
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
                            <a href="#">
                                <button class="btn btn-outline-success" type="button">View</button>
                            </a>
                            <a href="cart_remove.php?prodid=<?php echo $cartrow['prodid'] ?>" class="cancel-button">
                                <button class="btn btn-outline-danger" type="button">Cancel</button>
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
                                <!-- / Shopping cart table -->
                            </div>
                        </div>
                    </div>
                </div>
              
                <div class="tab-pane fade" id="to-receive" role="tabpanel" aria-labelledby="to-receive-tab">
                    <div class="container px-3 my-5 clearfix">
                        <!-- Shopping cart table for To Receive -->
                        <div class="card">
                            <div class="card-header">
                                <h2>Shopping Cart - To Receive</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered m-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center py-3 px-4" style="width: 30px;">Product Name &amp; Details</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Quantity</th>
                                                <th class="text-center py-3 px-4" style="width: 120px;">Total</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_SESSION['user_id'])){
                                                $user_id = $_SESSION['user_id'];
                                                $cart = "SELECT orders.order_id, orders.user_id, orders.prodid, orders.pname, orders.price, orders.quantity, orders.total, product.pname AS product_name, listing.details, listing.imgid
                                                FROM orders
                                                JOIN product ON orders.prodid = product.prodid
                                                JOIN listing ON listing.prodid = product.prodid
                                                WHERE orders.status = 2";
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
                                                                            <p class="text-muted small"><?php echo $cartrow['details'] ?></p>
                                                                        </figcaption>
                                                                    </figure>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <a href="quantity_minus.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                            <!-- Add minus button content if needed -->
                                                                        </a>
                                                                        <label class="form-control quantity-label" name="quantity"><?php echo $cartrow['quantity']; ?></label>
                                                                        <a href="quantity_add.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                            <!-- Add plus button content if needed -->
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="price-wrap">
                                                                        <var class="price"><?php echo $cartrow['price']?></var>                                            
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="price-wrap">
                                                                        <var class="total">₱ <?php echo $cartrow['total']?></var>                                            
                                                                    </div>
                                                                </td>
                                                                <td class="text-right d-none d-md-block">
                                                                    <a href="#">
                                                                    <button class="btn btn-outline-success view-btn" type="button" data-toggle="modal" data-target="#productModal" data-product-id="<?php echo $cartrow['prodid']; ?>">View</button>
                                                                    <button class="btn btn-outline-success complete-btn" type="button" data-order-id="<?php echo $cartrow['order_id']; ?>">Completed</button>
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
                                <!-- / Shopping cart table -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    <div class="container px-3 my-5 clearfix">
                        <!-- Shopping cart table for Cancelled -->
                        <div class="card">
                            <div class="card-header">
                                <h2>Shopping Cart - Cancelled</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered m-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center py-3 px-4" style="width: 30px;">Product Name &amp; Details</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                                <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_SESSION['user_id'])){
                                                $user_id = $_SESSION['user_id'];
                                                $cart = "SELECT orders.order_id, orders.user_id, orders.prodid, orders.pname, orders.price, orders.quantity, orders.total, product.pname AS product_name, listing.details, listing.imgid
                                                FROM orders
                                                JOIN product ON orders.prodid = product.prodid
                                                JOIN listing ON listing.prodid = product.prodid
                                                WHERE orders.status = 0";
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
                                                                            <p class="text-muted small"><?php echo $cartrow['details'] ?></p>
                                                                        </figcaption>
                                                                    </figure>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <a href="quantity_minus.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                            <!-- Add minus button content if needed -->
                                                                        </a>
                                                                        <label class="form-control quantity-label" name="quantity"><?php echo $cartrow['quantity']; ?></label>
                                                                        <a href="quantity_add.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                            <!-- Add plus button content if needed -->
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
                                                                    <a href="#">
                                                                        <button class="btn btn-outline-success" type="button">View</button>
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
                                <!-- / Shopping cart table -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                    <div class="container px-3 my-5 clearfix">
                        <!-- Shopping cart table for Completed -->
                        <div class="card">
                            <div class="card-header">
                                <h2>Shopping Cart - Completed</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered m-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center py-3 px-4" style="width: 30px;">Product Name &amp; Details</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                                <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                                                <th class="text-right py-3 px-4" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_SESSION['user_id'])){
                                                $user_id = $_SESSION['user_id'];
                                                $cart = "SELECT orders.order_id, orders.user_id, orders.prodid, orders.pname, orders.price, orders.quantity, orders.total, product.pname AS product_name, listing.details, listing.imgid
                                                FROM orders
                                                JOIN product ON orders.prodid = product.prodid
                                                JOIN listing ON listing.prodid = product.prodid
                                                WHERE orders.status = 3";
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
                                                                            <!-- Add minus button content if needed -->
                                                                        </a>
                                                                        <label class="form-control quantity-label" name="quantity"><?php echo $cartrow['quantity']; ?></label>
                                                                        <a href="quantity_add.php?prodid=<?php echo $cartrow['prodid'] ?>&pname=<?php echo $cartrow['pname'] ?>">
                                                                            <!-- Add plus button content if needed -->
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
                                                                    <a href="#">
                                                                        <button class="btn btn-outline-success" type="button">View</button>
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
                                <!-- / Shopping cart table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Modal for product details -->
  <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Product details will be loaded here via AJAX -->
                    <div class="product-modal-content">
                        <h5>Sample Product Name</h5>
                        <img src="path/to/image.jpg" alt="Product Image" class="img-fluid product-image">
                        <p class="product-price">Price: ₱ 1000</p>
                        <p class="product-details">Details: Sample product details go here.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Handle View button click event
    $('.view-btn').click(function() {
        var productId = $(this).data('product-id');
        $.ajax({
            url: 'product_details.php', // Replace with the actual URL to fetch product details
            method: 'GET',
            data: { productId: productId },
            success: function(response) {
                $('#productModal .modal-body').html(response);
            }
        });
    });

    // Handle Completed button click event
    $('.complete-btn').click(function() {
        var orderId = $(this).data('order-id');
        $.ajax({
            url: 'update_status.php', // Replace with the actual URL to update order status
            method: 'POST',
            data: { orderId: orderId, status: 3 },
            success: function(response) {
                // Optionally, you can handle the response if needed
                console.log('Order status updated successfully.');
                // Reload the page or update UI as required
            }
        });
    });
</script>

    <script>
        $('#myTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var activeTab = $(e.target).attr("id");
                if(activeTab === 'to-pay-tab') {
                    $(".cancel-button").show();
                } else {
                    $(".cancel-button").hide();
                }
            });

            // Initially hide cancel button in all tabs except "To Pay"
            if($("#to-pay-tab").hasClass('active')) {
                $(".cancel-button").show();
            } else {
                $(".cancel-button").hide();
            }
        });
    </script>
      <!-- Footer start -->
   <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
        </div>
    </div>
    <!-- Footer End -->
</body>
</html>
<?php 
include('includes/footer.php');
?>
