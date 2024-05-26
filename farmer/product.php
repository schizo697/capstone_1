<?php
// Initialize session and set cache limiter
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();

// Start output buffering
ob_start();

// Include database connection
include("../conn.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location:../index.php");
    exit();
}

// Include header and navbar
include('includes/header.php');
include('includes/navbar.php');

// Handle product archiving
if (isset($_POST['btnUpdate'])) {
    $archiveid = $_POST['archiveid'];
    $archiveproduct = "UPDATE product SET status = 'Not Available' WHERE prodid = ?";
    $stmt = $conn->prepare($archiveproduct);
    $stmt->bind_param("i", $archiveid);
    if ($stmt->execute()) {
        header("location: product.php?update_success=true");
        exit();
    }
}

// Handle adding a new product
if (isset($_POST['productname']) && isset($_POST['category']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['weight_id'])) {
    $productname = $_POST['productname'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $weight_id = $_POST['weight_id'];
    $uid = $_SESSION['user_id'];

    $sql = "INSERT INTO product (pname, catid, price, quantity, weight_id, uid, status) VALUES (?, ?, ?, ?, ?, ?, 'Available')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $productname, $category, $price, $quantity, $weight_id, $uid);
    if ($stmt->execute()) {
        header("location: product.php?success=true");
        exit();
    } else {
        echo "<script>Swal.fire({ icon: 'error', text: 'Something went wrong!' });</script>";
    }
}

// Handle editing a product
if (isset($_POST['editproductname']) && isset($_POST['editcategory']) && isset($_POST['editprice']) && isset($_POST['editquantity']) && isset($_POST['editweight']) && isset($_POST['editprodid'])) {
    $productname = $_POST['editproductname'];
    $category = $_POST['editcategory'];
    $price = $_POST['editprice'];
    $quantity = $_POST['editquantity'];
    $weight_id = $_POST['editweight'];
    $prodid = $_POST['editprodid'];

    $sql = "UPDATE product SET pname = ?, catid = ?, price = ?, weight_id = ?, quantity = ? WHERE prodid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $productname, $category, $price, $weight_id, $quantity, $prodid);
    if ($stmt->execute()) {
        header("location: product.php?update_success=true");
        exit();
    } else {
        echo "<script>Swal.fire({ icon: 'error', text: 'Something went wrong!' });</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Farmer's Market</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        <?php 
            include '../main/css/style.css'; 
            include '../main/css/bootstrap.min.css';
        ?>
        .edit-btn, .archive-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .edit-btn i, .archive-btn i {
            margin-right: 0.25rem;
        }
    </style>
</head>

<body>
    <!-- Archive Modal -->
    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Archive</h1>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <label for="archiveid">Are you sure you want to archive this product?</label>
                        <input type="hidden" id="archiveid" name="archiveid" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btnUpdate" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Products</h5>
                </div>
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
                                    $name_query = "SELECT * FROM pcategory";
                                    $r = mysqli_query($conn, $name_query);
                                    while ($row = mysqli_fetch_array($r)) {
                                        echo "<option value='{$row['catid']}'>{$row['category']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price per Kilo:</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="weight_id">Measurement:</label>
                            <select name="weight_id" class="form-select" aria-label="Measurement" required>
                                <?php
                                    $name_query = "SELECT * FROM weight";
                                    $r = mysqli_query($conn, $name_query);
                                    while ($row = mysqli_fetch_array($r)) {
                                        echo "<option value='{$row['weight_id']}'>{$row['measurement']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                </div>
                <form action="" method="POST" id="editproduct">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editproductname">Product Name:</label>
                            <input type="text" class="form-control" id="editproductname" name="editproductname" required>
                        </div>
                        <div class="form-group">
                            <label for="editcategory">Category:</label>
                            <select name="editcategory" id="editcategory" class="form-select" required>
                                <option selected disabled>Select...</option>
                                <?php
                                    $name_query = "SELECT * FROM pcategory";
                                    $r = mysqli_query($conn, $name_query);
                                    while ($row = mysqli_fetch_array($r)) {
                                        echo "<option value='{$row['catid']}'>{$row['category']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editprice">Price per Kilo:</label>
                            <input type="text" class="form-control" id="editprice" name="editprice" required>
                        </div>
                        <div class="form-group">
                            <label for="editweight">Measurement:</label>
                            <select name="editweight" id="editweight" class="form-select" required>
                                <?php
                                    $name_query = "SELECT * FROM weight";
                                    $r = mysqli_query($conn, $name_query);
                                    while ($row = mysqli_fetch_array($r)) {
                                        echo "<option value='{$row['weight_id']}'>{$row['measurement']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editquantity">Quantity:</label>
                            <input type="text" class="form-control" id="editquantity" name="editquantity" required>
                        </div>
                        <input type="hidden" id="editprodid" name="editprodid">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Table -->
    <div class="container-fluid about pt-5">
        <div class="container">
            <div class="row gx-9">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add Product
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price per Kilo</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Kilo or Sack</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $uid = $_SESSION['user_id'];
                                    $query = "SELECT p.prodid, p.pname, c.category, p.price, p.quantity, p.status w.measurement FROM product p JOIN pcategory c ON p.catid = c.catid WHERE p.uid = ? AND p.status = 'Available'";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("i", $uid);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                <td>{$row['pname']}</td>
                                                <td>{$row['category']}</td>
                                                <td>{$row['price']}</td>
                                                <td>{$row['quantity']}</td>
                                                <td>{$row['quantity']}</td>
                                                <td>{$row['status']}</td>
                                                <td>
                                                    <button class='btn btn-primary edit-button edit-btn' data-id='{$row['prodid']}' data-name='{$row['pname']}' data-category='{$row['category']}' data-price='{$row['price']}' data-quantity='{$row['quantity']}'>
                                                        <i class='fas fa-edit'></i> Edit
                                                    </button>
                                                    <button class='btn btn-danger archive-btn' data-id='{$row['prodid']}'>
                                                        <i class='fas fa-archive'></i> Archive
                                                    </button>
                                                </td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
        </div>
    </div>

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
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>


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

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle archiving products
            $('#example').on('click', '.archive-btn', function() {
                var proid = $(this).data('id');
                $('#archiveid').val(proid);
                $('#archiveModal').modal('show');
            });

            // Handle editing products
            $('#example').on('click', '.edit-button', function() {
                var prodid = $(this).data('id');
                var pname = $(this).data('name');
                var category = $(this).data('category');
                var price = $(this).data('price');
                var quantity = $(this).data('quantity');

                $('#editprodid').val(prodid);
                $('#editproductname').val(pname);
                $('#editcategory').val(category);
                $('#editprice').val(price);
                $('#editquantity').val(quantity);

                $('#editModal').modal('show');
            });

            // Show success messages
            function showModal(message, type = 'success') {
                Swal.fire({
                    position: 'center',
                    icon: type,
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }

            function checkExistParam() {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('success') && urlParams.get('success') === 'true') {
                    showModal('Product Added Successfully');
                } else if (urlParams.has('update_success') && urlParams.get('update_success') === 'true') {
                    showModal('Product Archived Successfully');
                }
            }

            window.onload = checkExistParam;

            // Initialize DataTable
            $('#example').DataTable();
        });
    </script>
</body>
</html>
