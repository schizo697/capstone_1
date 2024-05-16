<?php
include "../conn.php";
if (isset($_GET['pid'])) {
    $prodid = intval($_GET['pid']);
    $stmt = $conn->prepare("SELECT product.*, pcategory.category, listing.imgid, listing.details, listing.dateposted, user_info.contact, user_info.address, CONCAT(firstname,' ',lastname) AS fullname 
    FROM product 
    JOIN pcategory ON pcategory.catid = product.catid 
    JOIN listing ON listing.prodid = product.prodid
    JOIN user_account ON user_account.user_id = product.uid
    JOIN user_info ON user_info.info_id = user_account.info_id 
    WHERE product.prodid = ?");
    
    $stmt->bind_param("i", $prodid);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

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
        .logo {
            max-height: 120px;
            width: auto;
            margin-right: 0.5rem;
        }

        .product-details {
            padding: 30px 0;
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-details .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product-details .col-lg-6 {
            flex: 0 0 45%;
            max-width: 45%;
            margin: 10px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-details h1, 
        .product-details h2, 
        .product-details h5, 
        .product-details p {
            margin-bottom: 15px;
        }

        .product-details h2 {
            color: #28a745;
        }

        .btn-back, .btn-add-to-cart {
            margin: 5px;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
        }

        .footer a {
            color: #f8f9fa;
        }
        .bg-dark {
    background-color: #263A4F !important;
}
    </style>
</head>

<body>
<div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0"><a class="text-secondary fw-bold" ></a></p>
        </div>
    </div>
    <!-- Product Details Start -->
    <div class="container product-details">
        <div class="row">
            <div class="col-lg-6">
                <img src="<?php echo "../img/products/" . $product['imgid']; ?>" alt="<?php echo $product['pname']; ?>">
            </div>
            <div class="col-lg-6">
                <h1><?php echo $product['pname']; ?></h1>
                <h2>&#8369; <?php echo $product['price']; ?>.00</h2>
                <h5>Category: <?php echo $product['category']; ?></h5>
                <h5>Available: <?php echo $product['quantity']; ?> kilo</h5>
                <p><?php echo $product['details']; ?></p>
                <p>Farmer Name: <?php echo $product['fullname']; ?></p>
                <p>Address: <?php echo $product['address']; ?></p>
                <p>Contact: <?php echo $product['contact']; ?></p>
                <p>Date posted: <?php echo $product['dateposted']; ?></p>
                <a href="customer_dashboard.php" class="btn btn-secondary btn-back">Back to Products</a>
                <a href="add_to_cart.php?id=<?php echo $product['prodid']; ?>" class="btn btn-primary btn-add-to-cart"><i class="fas fa-cart-plus"></i> Add to Cart</a>
            </div>
        </div>
    </div>
    <!-- Product Details End -->

    <!-- Footer -->
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
