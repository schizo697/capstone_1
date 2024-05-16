<?php
session_start();
include '../conn.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    echo 'Error: session';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
      .btn-circle {
    width: 45px;
    height: 45px;
    text-align: center;
    padding: 7px 0;
    font-size: 18px;
    line-height: 1.428571429;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin-right: 10px; /* Adjust this value as needed */
}

.btn-circle i {
    margin: 0;
}

.btn-square {
    width: 45px;
    height: 45px;
    text-align: center;
    padding: 7px 0;
    font-size: 18px;
    line-height: 1.428571429;
    border-radius: 10%;
}

.me-2 {
    margin-right: 0.5rem !important;
}

.logo {
    height: 150px;
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
                <a class="btn btn-primary btn-circle" href="customer_profile.php"><i class="fas fa-user"></i></a>
                <a class="btn btn-primary btn-circle" href="customer_cart.php"><i class="fas fa-shopping-cart"></i></a>
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
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <!-- Add your navbar links here -->
    </div>
</nav>
<!-- Navbar End -->

<!-- jQuery, Popper.js, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
