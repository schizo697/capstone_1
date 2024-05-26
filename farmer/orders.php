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
    <!-- Table Start -->
    <div class="container-fluid about pt-5">
        <div class="container">
            <div class="row gx-9">
                <div class="card">
                    <h1> Customer Orders </h1>
                    <div class="card-header">
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Mode of Payment</th>
                                    <th>Date of Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../conn.php";
                                $uid = $_SESSION['user_id'];

                                $sql = "SELECT orders.order_id, orders.quantity, CONCAT(firstname, ' ', lastname) AS fullName, orders.*, product.*
                                FROM orders 
                                JOIN user_account ON user_account.user_id = orders.user_id 
                                JOIN user_info ON user_info.info_id = user_account.info_id
                                JOIN product ON product.prodid = orders.prodid
                                WHERE product.uid = '$uid' AND orders.status = 1";
                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr class="data-row">
                                        <td><?php echo $row['fullName']; ?></td>
                                        <td><?php echo $row['pname']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td> .. </td>
                                        <td><?php echo date('F d, Y', strtotime($row['date_of_order'])); ?></td>
                                        <td id="status-<?php echo $row['order_id']; ?>">To Pay</td>
                                        <td>
                                            <button id='confirm-btn-<?php echo $row['order_id']; ?>' class='btn btn-primary confirm-btn' data-id='<?php echo $row['order_id']; ?>'>
                                                <i class='fas fa-check-circle'></i> Confirm
                                            </button>
                                            <button id='cancel-btn-<?php echo $row['order_id']; ?>' class='btn btn-danger cancel-btn' data-id='<?php echo $row['order_id']; ?>'>
                                                <i class='fas fa-times-circle'></i> Cancel
                                            </button>
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->

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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <script>
$(document).ready(function() {
    $('.confirm-btn').click(function() {
        var orderId = $(this).data('id');
        var button = $(this);
        updateStatus(orderId, 2, button); // 2 for confirmed status
    });

    $('.cancel-btn').click(function() {
        var orderId = $(this).data('id');
        var button = $(this);
        updateStatus(orderId, 0, button); // 0 for cancelled status
    });

    function updateStatus(orderId, status, button) {
        $.ajax({
            type: 'POST',
            url: 'update_status.php', // Create a PHP file to handle this request
            data: {
                orderId: orderId,
                status: status
            },
            success: function(response) {
                if (response == 'success') {
                    $('#status-' + orderId).text(status == 2 ? 'Confirmed' : 'Cancelled');
                    button.prop('disabled', true); // Disable the button that was clicked
                    button.siblings('button').prop('disabled', true); // Disable the sibling button
                } else {
                    alert('Failed to update status.');
                }
            }
        });
    }
});
</script>

</body>
<?php
include('includes/footer.php');
?>
</html>
