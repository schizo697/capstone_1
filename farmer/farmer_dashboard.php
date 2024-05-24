<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("../conn.php");
if(!isset($_SESSION['user_id']))
{
    header("location:../index.php");
}

include('includes/header.php');
include('includes/navbar.php');
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
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        <?php 
            include '../main/css/style.css'; 
            include '../main/css/bootstrap.min.css';
        ?>
    </style>
</head>

<body>
    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-3">
                    <div class="bg-light text-center p-3">
                        <!-- <i class="fa fa-carrot display-1 text-primary mb-3"></i> -->
                        <h4>Total Listing</h4>
                        <h1> 5 </h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="bg-light text-center p-3">
                        <h4>Products</h4>
                        <h1> 5 </h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="bg-light text-center p-3">
                        <h4>Orders</h4>
                        <h1> 2 </h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="bg-light text-center p-3">
                        <h4>Customers</h4>
                        <h1> 2 </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <section class="section">
    <div class="row">
    <h5 class="display-5">Market Trends </h5>
    <!-- Top Selling Start -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php
                    // Retrieve data from the "order" table
                    $sql = "SELECT pname, prodid, SUM(quantity) AS total_quantity FROM `orders` GROUP BY prodid ASC LIMIT 10";
                    $result = mysqli_query($conn, $sql);

                    // Check if the query was successful
                    if ($result) {
                        $topSellingProductsData = array();
                        $productNames = array();
                            
                        // Fetch the data and store it in an array
                        while ($row = mysqli_fetch_assoc($result)) {
                            $topSellingProductsData[] = $row['total_quantity'];
                            $productNames[] = $row['pname'];
                        }

                        // Use the retrieved data in your JavaScript code
                        echo "<h5 class='card-title'>Top Selling Products in the Market</h5>";
                        echo "<div id='barChart'></div>";
                        echo "<script>";
                        echo "document.addEventListener('DOMContentLoaded', () => {";
                        echo "new ApexCharts(document.querySelector('#barChart'), {";
                        echo "series: [{";
                        echo "data: " . json_encode($topSellingProductsData);
                        echo "}],";
                        echo "chart: {";
                        echo "type: 'bar',";
                        echo "height: 350";
                        echo "},";
                        echo "plotOptions: {";
                        echo "bar: {";
                        echo "borderRadius: 4,";
                        echo "horizontal: true";
                        echo "}";
                        echo "},";
                        echo "dataLabels: {";
                        echo "enabled: false";
                        echo "},";
                        echo "xaxis: {";
                        echo "categories: " . json_encode($productNames);
                        echo "}";
                        echo "}).render();";
                        echo "});";
                        echo "</script>";
                    } else {
                        echo "Error retrieving data: " . mysqli_error($conn);
                    }
                    ?>
            </div>
        </div>
    </div>
    <!-- Top Selling End -->

    <!-- Top Supply -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php
                    // Retrieve data from the "order" table
                    $fetch = "SELECT product.pname, listing.prodid, SUM(product.quantity) AS total_quantity 
                                FROM `listing` 
                                JOIN product ON product.prodid = listing.prodid 
                                GROUP BY listing.prodid 
                                ASC LIMIT 10";
                    $result1 = mysqli_query($conn, $fetch);

                    // Check if the query was successful
                    if ($result1) {
                        $topSupplyProductsData = array();
                        $productNames = array();
                            
                        // Fetch the data and store it in an array
                        while ($row = mysqli_fetch_assoc($result1)) {
                            $topSupplyProductsData[] = $row['total_quantity'];
                            $productNames[] = $row['pname'];
                        }

                        // Use the retrieved data in your JavaScript code
                        echo "<h5 class='card-title'>Products with High Supply in the Market</h5>";
                        echo "<div id='barChartSupply'></div>";
                        echo "<script>";
                        echo "document.addEventListener('DOMContentLoaded', () => {";
                        echo "new ApexCharts(document.querySelector('#barChartSupply'), {";
                        echo "series: [{";
                        echo "data: " . json_encode($topSupplyProductsData);
                        echo "}],";
                        echo "chart: {";
                        echo "type: 'bar',";
                        echo "height: 350";
                        echo "},";
                        echo "plotOptions: {";
                        echo "bar: {";
                        echo "borderRadius: 4,";
                        echo "horizontal: true";
                        echo "}";
                        echo "},";
                        echo "dataLabels: {";
                        echo "enabled: false";
                        echo "},";
                        echo "xaxis: {";
                        echo "categories: " . json_encode($productNames);
                        echo "}";
                        echo "}).render();";
                        echo "});";
                        echo "</script>";
                    } else {
                        echo "Error retrieving data: " . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Supply End -->
    </div>
    </section>

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
    <script src="assets/js/apexcharts.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <script>
        function enableDropdown() {
            $('.dropdown-toggle').on('click', function() {
                $(this).siblings('.dropdown-menu').toggleClass('show');
            });

            $(document).on('click', function(e) {
                if (!$('.dropdown-toggle').is(e.target) && $('.dropdown-toggle').has(e.target).length === 0 &&
                    $('.show').has(e.target).length === 0) {
                    $('.dropdown-menu').removeClass('show');
                }
            });
        }

        $(document).ready(function() {
            enableDropdown();
        });
    </script>
    <?php
include('includes/footer.php');
?>
</body>

</html>