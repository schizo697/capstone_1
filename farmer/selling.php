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
include('../conn.php');
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
    

    <!-- Form Start -->
    <div class="container-fluid about pt-5">
        <div class="container">
            <div class="row gx-9">
                <div class="card">
                    <div class = "containers">
                        <div class = "offset-md-12 col-md-12 modal-header" style = "padding: 0; padding-left: 15px; margin-bottom: 15px"> 
                            <legend class = "text-left"> Sell a Product </legend>
                                <a href = "listingproducts.php"><button class="btn btn-primary" name="bsubmit">
   		                            <i class="bx bx-detail"></i> <span>My Listing</span></button>
                                </a>
                                    </div> 
                                <div class="container">
                                    <div class="content">
                                    <?php 
                                            if(isset($_POST['btnPost'])){
                                                $uid = $_SESSION['user_id'];
                                                $product = $_POST['product'];
                                                $visibility = $_POST['visibility'];
                                                $description = $_POST['description'];

                                                if (isset($_FILES['image'])) {
                                                    $img_name = $_FILES['image']['name'];
                                                    $img_size = $_FILES['image']['size'];
                                                    $tmp_name = $_FILES['image']['tmp_name'];
                                                    $error = $_FILES['image']['error'];
                                                    
                                                    if ($error === 0) {
                                                        if ($img_size > 1250000) {
                                                                $message = "Sorry, your file is too large";
                                                                header("Location: selling.php?error=$message");
                                                        } else {
                                                            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                                                            $img_ex_loc = strtolower($img_ex);
                                                    
                                                            $allowed_ex = array ("jpg", "jpeg", "png", "pdf");
                                                    
                                                            if (in_array($img_ex_loc, $allowed_ex)) {
                                                                $new_img_name = uniqid("FP-", true).'.'.$img_ex_loc;
                                                                $img_upload_path = '../img/products/'.$new_img_name;
                                                                move_uploaded_file($tmp_name, $img_upload_path);
                                                    
                                                                //into the database
                                                                $sql = "INSERT INTO listing (prodid, uid, details, imgid, visibility) VALUES (?, ?, ?, ?,?)";
                                                                $stmt = $conn->prepare($sql);
                                                                $stmt->bind_param("sssss", $product, $uid, $description, $new_img_name, $visibility);
                                                                if($stmt->execute()) {
                                                                    $url = "selling.php?success=true";
                                                                    echo '<script>window.location.href= "' . $url . '";</script>'; 
                                                                } else {
                                                                    echo "<script>Swal.fire({
                                                                        icon: 'error',
                                                                        text: 'Something went wrong!',
                                                                    });
                                                                    </script>";
                                                                } 
                                        
                                                            } else {
                                                                $message = "You cannot upload files of this type";
                                                                header("Location: ownerPost.php?error=$message");
                                                            }
                                                        }
                                                    } else {
                                                        $message = "Please upload the required images";
                                                        header("Location: ownerPost.php?error=$message");
                                                    }
                                                }
                                                
                                            }
                                        ?>
                                        <form method="POST" action="" class="needs-validation" enctype = "multipart/form-data" novalidate>
                                            <div class="row">
    											<div class="col-xl-12">
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label"> Choose Product <span style = "color:red;">*</span></label>
    													<div class="col-lg-4">
    														<select class="custom-select" id = "product" name="product" required>
                                                            <option selected disabled>Choose...</option>
                                                                <?php
                                                                    include "../conn.php";
                                                                    $uid = $_SESSION['user_id'];
                                                                                        
                                                                    $name_query = "SELECT * FROM product WHERE uid = '$uid'";
                                                                    $r = mysqli_query($conn, $name_query);
                                                                
                                                                    while ($row = mysqli_fetch_array($r)) {
                                                                    ?>
                                                                        <option value="<?php echo $row['prodid']; ?>"> <?php echo $row['pname']; ?></option>
                                                                    <?php
                                                                    }
                                                                ?>
    														</select>
    													</div>
    												</div>
    												<div class="form-group row">  
    													<label class="col-lg-2 col-form-label"> Visibility <span style = "color:red;">*</span></label>
    													<div class="col-lg-4">
    														<select class="custom-select" required name="visibility">
                                                                <option selected disabled value="">Choose...</option>
                                                                <option value="Public">Public</option>
                                                                <option value="Private">Private</option>
    														</select>
    													</div>
    											    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Image <span style = "color:red;">*</span></label>
                                                        <div class="col-lg-5">
                                                            <input type = "file" name="image" id="image' style="border: solid gray 1px; padding: 6px; width: 80%; border-radius: 4px"/>
                                                        </div>
                                                    </div>
                                                    <br>
    												<div class="form-group row">
    													<label class="col-lg-2 col-form-label">Description</label>
    													<div class="col-lg-9">
                                                            <textarea name = "description" id = "description" class="form-control" id="validationCustom07" required></textarea>	
    													</div>
                                                        <div class = "invalid-feedback"> 
                                                                Please provide some description
                                                            </div>
    												</div>
                                                </div>
    										</div><br>
                                            <!-- Button trigger modal -->
                                            <a href="#" class="btn btn-primary post-button" data-bs-toggle="modal" data-bs-target="#postmodal">
                                                Post
                                            </a>   
                                        </div> 
                                    </div>
                                </div>
                                <!-- post modal -->
                                <div class="modal fade" id="postmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Archive</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        
                                                <div class="modal-body">
                                                    Are you sure you want to sell this product?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="btnPost" class="btn btn-primary">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
</body>
<?php
include('includes/footer.php');
?>
</html>