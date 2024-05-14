<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("../conn.php");
if (!isset($_SESSION['user_id'])) {
    header("location:../index.php");
}

include('includes/header.php');
include('includes/navbar.php');
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

    <!-- Custom CSS -->
    <link href="../main/css/style.css" rel="stylesheet">
    <link href="../main/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Custom Styles*/

/* Ensure all product images are of the same size */
.product-item img {
    width: 100%;
    height: 200px; /* Adjust height as needed */
    object-fit: cover; /* Ensure images cover the area without distortion */
}

/* Ensure all product items have the same height */
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

    </style>
</head>

<body>
    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="mx-auto text-center mb-5" style="max-width: 500px;">
                <h6 class="text-primary text-uppercase">Products</h6>
                <h1 class="display-5">My Listing</h1>
            </div>
            <div class="row g-5">
                <?php 
                    $uid = $_SESSION['user_id'];
                    
                    $getlisting = "SELECT * FROM listing 
                                    JOIN product ON listing.prodid = product.prodid 
                                    JOIN pcategory ON pcategory.catid = product.catid 
                                    WHERE product.uid = '$uid'";
                    $fetch = $conn->query($getlisting);
                ?>               
                <?php 
                    while($row = mysqli_fetch_assoc($fetch)){ 
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="product-item position-relative bg-white d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo "../img/products/".$row['imgid']; ?>" alt="">
                        <h6 class="mb-3"><?php echo $row['pname'];?></h6>
                        <h5 class="text-primary mb-0">&#8369; <?php echo $row['price'];?>.00</h5>
                        <h6 class="mb-3">Quantity: <?php echo $row['quantity'];?> available</h6>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn bg-primary py-2 px-3" href=""><i class="bi bi-cart text-white"></i></a>
                            <a class="btn bg-secondary py-2 px-3" href=""><i class="bi bi-eye text-white"></i></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="https://freewebsitecode.com/">Farmer's Market 2024</a></p>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


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
