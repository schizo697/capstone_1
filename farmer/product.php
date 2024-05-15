<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("../conn.php");
if (!isset($_SESSION['user_id'])) {
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
    <!-- archive modal -->
    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Archive</h1>
                </div>
                <?php 
                if(isset($_POST['btnUpdate'])){
                    $arhiveid = $_POST['archiveid'];
                    $archiveproduct = "UPDATE product SET status = 'Not Available' WHERE prodid = '$arhiveid'";
                    $archiveresult = mysqli_query($conn, $archiveproduct);

                    if($archiveresult){
                        $url = "product.php?update_success=true";
                        echo "<script>window.location.href='$url';</script>";
                        exit();                        
                    }
                }
                
                ?>
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
                <?php
                include '../conn.php';

                if (isset($_POST['productname']) && isset($_POST['category']) && isset($_POST['price']) && isset($_POST['quantity'])) {
                    $productname = $_POST['productname'];
                    $category = $_POST['category'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];
                    $uid = $_SESSION['user_id'];

                    $sql = "INSERT INTO product (pname, catid, price, quantity, uid, status) VALUES (?, ?, ?, ?, ?, 'Available')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $productname, $category, $price, $quantity, $uid);
                    if ($stmt->execute()) {
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
                <?php
                if (isset($_POST['editproductname']) && isset($_POST['editcategory']) && isset($_POST['editprice']) && isset($_POST['editquantity']) && isset($_POST['editprodid'])) {
                    $productname = $_POST['editproductname'];
                    $category = $_POST['editcategory'];
                    $price = $_POST['editprice'];
                    $quantity = $_POST['editquantity'];
                    $prodid = $_POST['editprodid'];

                    $sql = "UPDATE product SET pname = ?, catid = ?, price = ?, quantity = ? WHERE prodid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $productname, $category, $price, $quantity, $prodid);

                    if ($stmt->execute()) {
                        $url = "product.php?update_success=true";
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
                            <label for="editprice">Price per Kilo:</label>
                            <input type="text" class="form-control" id="editprice" name="editprice" required>
                        </div>
                        <div class="form-group">
                            <label for="editquantity">Kilo:</label>
                            <input type="quantity" class="form-control" id="editquantity" name="editquantity" required>
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

    <!-- Table Start -->
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
                                    <th scope="col">Kilo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $uid = $_SESSION['user_id'];
                                    $query = "SELECT p.prodid, p.pname, c.category, p.price, p.quantity, p.status FROM product p JOIN pcategory c ON p.catid = c.catid WHERE p.uid = $uid AND p.status = 'Available'";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?> 
                                            <tr>
                                                <td><?php echo $row['pname']; ?></td>
                                                <td><?php echo $row['category']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td>
                                                    <button class='btn btn-primary edit-button edit-btn' data-id='<?php echo $row['prodid']; ?>' data-name='<?php echo $row['pname']; ?>' data-category='<?php echo $row['category']; ?>' data-price='<?php echo $row['price']; ?>' data-quantity='<?php echo $row['quantity']; ?>'>
                                                        <i class='fas fa-edit'></i> Edit
                                                    </button>
                                                    <button class='btn btn-danger archive-btn' data-id='<?php echo $row['prodid']; ?>'>
                                                        <i class='fas fa-archive'></i> Archive
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
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
    <!-- Table End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light mt-5 py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-4 col-md-6 mb-5">
                    <h4 class="text-uppercase text-primary">Get In Touch</h4>
                    <p class="mb-4">Contact us for any inquiries.</p>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>123 Street, City, Country</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary me-3"></i>+123 456 7890</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary me-3"></i>watapampam@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-primary btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-primary btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-primary btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <h4 class="text-uppercase text-primary">Quick Links</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Home</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Services</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Contact</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <h4 class="text-uppercase text-primary">Newsletter</h4>
                    <p class="mb-4">Subscribe to our newsletter for the latest updates.</p>
                    <form action="">
                        <div class="input-group">
                            <input type="email" class="form-control border-0 p-3" placeholder="Your Email">
                            <button class="btn btn-primary">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container border-top border-light pt-5">
            <p class="m-0 text-center text-light">&copy; <a href="#">Farmer's Market</a>. All Rights Reserved.</p>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
    // archived
        document.addEventListener('DOMContentLoaded', function() {
            $('#example').on('click', '.archive-btn', function() {
                var proid = $(this).data('id');
                
                $('#archiveid').val(proid); // Assuming there's an input with id 'archiveid'
                $('#archiveModal').modal('show');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });

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
    </script>
</body>
</html>

<?php
include('includes/footer.php');
?>
