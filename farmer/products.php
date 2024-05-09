<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("../conn.php");
if(!isset($_SESSION['user_id']))
{
    header("location:../login.php");
}

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    <?php include 'css/product.css' ?>
</style>
</head>

<body>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Products</h1>
          </div>
          <div class="col-sm-6">    
          </div>
        </div>
      </div>
    </div>


    <!-- modal -->
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
                $url = "products.php?success=true";
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
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="quantity" class="form-control" id="quantity" name="quantity" required>
                </div>
                <!-- <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" class="form-select" aria-label="Status" required>
                        <option selected disabled>Select...</option>
                        <option value="2">Customer</option>
                        <option value="3">Seller</option>
                    </select>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
    </div>

    <div class="card">
            <div class="card-header">
            <button type="submit" name="submit" class="btn btn-success" id="openModalBtn">Add New</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
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
                    <tr class = "data-row"> 
                        <td> <?php echo $row['pname']; ?> </td>
                        <td> <?php echo $row['category']; ?> </td>
                        <td> <?php echo $row['price']; ?> </td>
                        <td> <?php echo $row['quantity']; ?> </td>
                        <td> <?php echo $row['status']; ?> </td>
                        <td>
                            <?php
                                $date = date('F d, Y', strtotime($row['dateadded']));
                                echo $date;                                        
                            ?>
                        </td>
                        <td>
                            <div class="row d-flex justify-content-center">
                                <button type="button" class="edit mx-1" data-id='<?php echo $row['bname_ID']; ?>'><i class="fa fa-edit"></i></button>
                                <button type="button" class="delete" data-id='<?php echo $row['bname_ID']; ?>'><i class='fa fa-archive' ></i></button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
            ?> 
        </tbody>
    </table>
</div>
</div>
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


</body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
  </script>

<?php
include('includes/footer.php');
?>
