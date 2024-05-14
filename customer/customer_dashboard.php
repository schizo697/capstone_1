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
        /* Custom Styles */

/* Ensure all product images are of the same size */
.product-item img {
    width: 100%;
    height: 250px; /* Adjust height as needed */
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

.logo {
    max-height: 120px; /* Adjust the height as needed */
    width: auto;
    margin-right: 0.5rem;
}
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid px-5 d-none d-lg-block">
        <div class="row gx-5 py-3 align-items-center">
            <div class="col-lg-3">
                <div class="d-flex align-items-center justify-content-start">
                 
                    <img src="assets/dist/img/logo.png" alt="Your Logo" class="logo">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="index.html" class="navbar-brand ms-lg-5">
                        <h1 class="m-0 display-4 text-primary"><span class="text-secondary">Farmer's </span>Market</h1>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="d-flex align-items-center justify-content-end">
                    <a class="btn btn-primary btn-square rounded-circle me-2"><i class="fas fa-cart-plus"></i></a>
                    <a class="btn btn-primary btn-square rounded-circle me-2"><i class="fas fa-cart-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark shadow-sm py-3 py-lg-0 px-3 px-lg-5">
        <a href="index.html" class="navbar-brand d-flex d-lg-none">
            <h1 class="m-0 display-4 text-secondary"><span class="text-white">Farmer's </span>Market</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- Navbar End -->


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
                    include "../conn.php";
                    
                    $getlisting = "SELECT * FROM listing 
                                    JOIN product ON listing.prodid = product.prodid 
                                    JOIN pcategory ON pcategory.catid = product.catid";
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
                        <h6 class="mb-3">Quantity: <?php echo $row['quantity'];?> Kilo</h6>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn bg-primary py-2 px-3" href=""><i class="bi bi-cart text-white"></i></a>
                            <a class="btn bg-secondary py-2 px-3" href="view_products.php?id=<?php echo $row['prodid']; ?>"><i class="bi bi-eye text-white"></i></a>
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
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
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
