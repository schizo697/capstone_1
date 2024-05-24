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
        .edit-btn,
        .archive-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .edit-btn i,
        .archive-btn i {
            margin-right: 0.25rem;
        }
    </style>
</head>

<body>
    <!-- Analytics Start -->
    <div class="container-fluid about pt-5">
        <div class="container" style="display: flex;">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">In-demand Products</h5>
                        <div id="barChart"></div>
                        <script>document.addEventListener("DOMContentLoaded", () => {
                           new ApexCharts(document.querySelector("#barChart"), {
                             series: [{
                               data: [400, 430, 448, 470, 540]
                             }],
                             chart: {
                               type: 'bar',
                               height: 350
                             },
                             plotOptions: {
                               bar: {
                                 borderRadius: 4,
                                 horizontal: true,
                               }
                             },
                             dataLabels: {
                               enabled: false
                             },
                             xaxis: {
                               categories: ['Okra', 'Ampalaya', 'Kalabasa', 'Pechay', 'Beans'
                               ],
                             }
                           }).render();
                           });
                        </script> 
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Current Supply in the Market</h5>
                        <div id="barChartSupply"></div>
                        <script>document.addEventListener("DOMContentLoaded", () => {
                           new ApexCharts(document.querySelector("#barChartSupply"), {
                             series: [{
                               data: [470, 540, 580, 1100, 1380]
                             }],
                             chart: {
                               type: 'bar',
                               height: 350
                             },
                             plotOptions: {
                               bar: {
                                 borderRadius: 4,
                                 horizontal: true,
                               }
                             },
                             dataLabels: {
                               enabled: false
                             },
                             xaxis: {
                               categories: ['Okra', 'Ampalaya', 'Kalabasa', 'Pechay', 'Beans'
                               ],
                             }
                           }).render();
                           });
                        </script> 
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container" style="display: flex;">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Current Stock</h5>
                        <div id="pieChart"></div>
                        <script>document.addEventListener("DOMContentLoaded", () => {
                           new ApexCharts(document.querySelector("#pieChart"), {
                             series: [4, 10, 8, 20, 0],
                             chart: {
                               height: 350,
                               type: 'pie',
                               toolbar: {
                                 show: true
                               }
                             },
                             labels: ['Kalabasa', 'Ampalaya', 'Okra', 'Pechay', 'Beans']
                           }).render();
                           });
                        </script> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Analytics End -->

    <br>
    <br>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/js/apexcharts.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>


</body>
<?php
include('includes/footer.php');
?>
</html>
