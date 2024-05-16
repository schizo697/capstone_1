<?php
session_start();
include '../conn.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    echo 'Error: session';
}
?>
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
                <a class="btn btn-primary rounded-circle" href="customer_dashboard.php"><i class="bi bi-user"></i></a>
                    <a class="btn btn-primary rounded-circle" href="customer_cart.php"><i class="bi bi-cart"></i></a>
                    <a class="btn btn-primary btn-square rounded-circle me-2" href="customer_profile.php"><i class="fab fa-twitter">Profile</i></a>
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
       
        </div>
    </nav>
    <!-- Navbar End -->