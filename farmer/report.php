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
    <!-- Modal Start -->
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                include '../conn.php';

                if(isset($_POST['productname']) && isset($_POST['category']) && isset($_POST['price']) && isset($_POST['quantity'])) {
                    $productname = $_POST['productname'];
                    $category = $_POST['category'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];
                    $uid = $_SESSION['user_id'];

                    $sql = "INSERT INTO product (pname, catid, price, quantity, uid, status) VALUES (?, ?, ?, ?, ?, 'Available')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $productname, $category, $price, $quantity, $uid);
                    if($stmt->execute()) {
                        $url = "product.php?success=true";
                        echo '<script>window.location.href= "' . $url . '";</script>'; 
                    } else {
                        echo "<script>Swal.fire({
                            icon: 'error',
                            text: 'Something went wrong!',
                        });
                        </script>";
                    } 
                }
                ?>
                <form action="" method="POST" id="addproduct">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="productname">Product Name:</label>
                            <input type="text" class="form-control" id="productname" name="productname" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select name="category" class="form-select" aria-label="Category" required>
                                <option selected disabled>Select...</option>
                                <?php
                                    include "../conn.php";
                                                        
                                    $name_query = "SELECT * FROM pcategory";
                                    $r = mysqli_query($conn, $name_query);
                                
                                    while ($row = mysqli_fetch_array($r)) {
                                    ?>
                                        <option value="<?php echo $row['catid']; ?>"> <?php echo $row['category']; ?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price per Kilo:</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Kilo:</label>
                            <input type="quantity" class="form-control" id="quantity" name="quantity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <!-- Table Start -->
    <div class="container-fluid about pt-5">
        <div class="container">
            <div class="row gx-9">
                <div class="card">
                    <div class="card-header">
                        <p>Archive</p>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Kilo</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../conn.php";
                                $uid = $_SESSION['user_id'];

                                $sql = "SELECT * FROM product JOIN pcategory ON pcategory.catid = product.catid WHERE product.status = 'Not Available'";
                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr class="data-row">
                                        <td><?php echo $row['pname']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo date('F d, Y', strtotime($row['dateadded'])); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm restore-button" data-id="<?php echo $row['prodid']; ?>">Restore</button>
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
