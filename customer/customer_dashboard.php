<?php 
include '../conn.php';
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Farmer's Market</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../main/css/style.css" rel="stylesheet">
    <link href="../main/css/bootstrap.min.css" rel="stylesheet">
     <!-- sweetalert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        <?php 
            include '../main/css/style.css'; 
            include '../main/css/bootstrap.min.css';
        ?>
        /* Custom Styles */
        .product-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .product-item {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .product-item .btn-action {
            margin-top: auto;
        }
        .product-item h6,
        .product-item h5 {
            margin: 10px 0;
        }
        .btn-action a {
            margin: 0 5px;
        }
        .logo {
            max-height: 120px;
            width: auto;
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 bg-hero mb-5">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <div class="col-md-20">
                        <form id="filter-list" method="POST">
                            <div class="row g-4" style="margin-bottom: 8px;">
                                <div class="col-md-8">
                                    <input type="text" class="form-control border-0 py-3 enter-loc" id="product" name="product" placeholder="Search Product">
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-2" style="width: 300px">
                                    <select name="cate" id="cate" value="category" class="form-control border-0 py-3 enter-loc">
                                        <option value="" selected disabled>Category</option>
                                        <option value="Vegetable"> Vegetable </option>
                                        <option value="Fruits"> Fruits </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" id="search" class="btn btn-dark border-0 w-100 py-3">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="mx-auto text-center mb-5" style="max-width: 500px;">
                <h6 class="text-primary text-uppercase">Products</h6>
                <h1 class="display-5">Available Products</h1>
            </div>
            <div class="row g-5">
            <?php 
            $sqlproduct = "SELECT listing.*, product.*, pcategory.category, weight.measurement
            FROM listing
            JOIN product ON listing.prodid = product.prodid
            JOIN pcategory ON pcategory.catid = product.catid
            JOIN weight ON product.weight_id = weight.weight_id
            WHERE status = 'Available'";
            $productresult = mysqli_query($conn, $sqlproduct);

            if ($productresult && mysqli_num_rows($productresult)) {
                while ($productrow = mysqli_fetch_assoc($productresult)) {
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="product-item position-relative bg-white d-flex flex-column text-center">
                    <input type="hidden" name="prodid" value="<?php echo $productrow['prodid'] ?>">
                    <img class="img-fluid mb-4" src="<?php echo "../img/products/".$productrow['imgid']; ?>" alt="<?php echo $productrow['pname']; ?>">
                    <h6 class="mb-3"><?php echo $productrow['pname'];?></h6>
                    <h5 class="text-primary mb-0">&#8369; <?php echo $productrow['price'];?>.00</h5>                   
                    <h6 class="mb-3">Quantity: <?php echo $productrow['quantity'];?> <?php echo $productrow['measurement'];?> </h6>
                    <div class="btn-action d-flex justify-content-center">
                        <button class="btn btn-primary py-2 px-3 add-to-cart" type="button" data-prodid="<?php echo $productrow['prodid']; ?>" data-pname="<?php echo $productrow['pname'] ?>">
                            <i class="bi bi-cart text-white"></i>
                        </button>
                        <a class="btn bg-secondary py-2 px-3" href="view_products.php?pid=<?php echo $productrow['prodid']; ?>"><i class="bi bi-eye text-white"></i></a>
                    </div>
                </div>
            </div>
            <?php 
                } 
            }
            ?>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.add-to-cart').click(function(){
            var prodid = $(this).data('prodid');
            var pname = $(this).data('pname');

            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data: {
                    prodid: prodid, // Include prodid here
                    pname: pname
                },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        text: response,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error){
                    console.error('AJAX Error: ' + status + error);
                    console.error(xhr);
                }
            });
        });
    });
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../main/js/main.js"></script>
</body>

</html>
