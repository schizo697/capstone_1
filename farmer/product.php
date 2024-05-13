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
    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Products</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"> Add New </button>
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

                            $sql = "SELECT * FROM product JOIN pcategory ON pcategory.catid = product.catid WHERE product.uid = '$uid'";
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
                                        <button type="button" class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['prodid']; ?>" data-name="<?php echo $row['pname']; ?>" data-category="<?php echo $row['category']; ?>" data-price="<?php echo $row['price']; ?>" data-quantity="<?php echo $row['quantity']; ?>">Edit<i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm archive-button" data-id="<?php echo $row['prodid']; ?>">Archive</button>
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

    <!-- Edit Product Modal -->
    <div class="modal" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editProductForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editProductId" name="productId">
                        <div class="form-group">
                            <label for="editProductName">Product Name:</label>
                            <input type="text" class="form-control" id="editProductName" name="productName" >
                        </div>
                        <div class="form-group">
                            <label for="editCategory">Category:</label>
                            <select id="editCategory" name="category" class="form-select" aria-label="Category" >
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editPrice">Price per Kilo:</label>
                            <input type="text" class="form-control" id="editPrice" name="price" >
                        </div>
                        <div class="form-group">
                            <label for="editQuantity">Kilo:</label>
                            <input type="text" class="form-control" id="editQuantity" name="quantity" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <script>
$(document).ready(function() {
  // Populate modal with data when edit button is clicked
  $('.edit-button').click(function() {
    var productId = $(this).data('data-id');
    var productName = $(this).data('name');
    var category = $(this).data('category');
    var price = $(this).data('price');
    var kilo = $(this).data('quantity');
    

    $('#productId').val(productId);
    $('#editProductName').val(productName);
    $('#editCategory').val(category);
    $('#editPrice').val(price);
    $('#editQuantity').val(kilo);
    
  
  });
}
  // Handle form submission for updating data
  $('#editForm').submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
      type: 'POST',
      url: 'edit_product.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        console.log(response);
        $('#editModal').modal('hide');
        location.reload(); // Reload the page after successful update
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }));


    </script>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- Include DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> <!-- Include Bootstrap JS -->
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
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
    })
    </script>

</body>
<?php
include('includes/footer.php');
?>
</html>
