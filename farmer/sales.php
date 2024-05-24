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
            <div class="col-lg-7">
                <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Sales Reports</h5>
                        <div id="lineChart"></div>
                        <script>document.addEventListener("DOMContentLoaded", () => {
                           new ApexCharts(document.querySelector("#lineChart"), {
                             series: [{
                               name: "Desktops",
                               data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
                             }],
                             chart: {
                               height: 350,
                               type: 'line',
                               zoom: {
                                 enabled: false
                               }
                             },
                             dataLabels: {
                               enabled: false
                             },
                             stroke: {
                               curve: 'straight'
                             },
                             grid: {
                               row: {
                                 colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                 opacity: 0.5
                               },
                             },
                             xaxis: {
                               categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                             }
                           }).render();
                           });
                        </script> 
                    </div>
                </div>   
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Best Selling Products</h5>
                        <div id="pieChart"></div>
                        <script>document.addEventListener("DOMContentLoaded", () => {
                           new ApexCharts(document.querySelector("#pieChart"), {
                             series: [44, 55, 13, 43, 22],
                             chart: {
                               height: 350,
                               type: 'pie',
                               toolbar: {
                                 show: true
                               }
                             },
                             labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E']
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

    <script>
    function showModal(){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Product Added Successfully',
            showConfirmButton: false
        });
    }

    function checkExistParam() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === 'true') {
            showModal();
        }
    }

    window.onload = checkExistParam; 
    </script>

    <script>
    // Wait for the DOM to be ready
    document.addEventListener("DOMContentLoaded", function() {
        // Get the button element
        var openModalBtn = document.getElementById('openModalBtn');

        // Get the modal element
        var modal = document.querySelector('.modal');

        // When the button is clicked, show the modal
        openModalBtn.addEventListener('click', function() {
            modal.style.display = 'block';
        });

        // When the close button inside the modal is clicked, hide the modal
        modal.querySelector('.close').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // When the user clicks anywhere outside of the modal, close it
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    });
    </script>

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

    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
    </script>

    <script>
    // Restore product functionality
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.restore-button').forEach(function(button) {
            button.addEventListener('click', function() {
                const prodId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to restore this product?')) {
                    fetch(`restore_product.php?prodid=${prodId}`, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product restored successfully!');
                            location.reload();
                        } else {
                            alert('Error restoring product.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error restoring product.');
                    });
                }
            });
        });
    });
    </script>
</body>
<?php
include('includes/footer.php');
?>
</html>
