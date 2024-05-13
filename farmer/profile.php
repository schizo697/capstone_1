<?php
session_start();

include('includes/header.php');
include('includes/navbar.php');
include('../conn.php');
?>
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        <?php 
            include '../main/css/style.css'; 
            include '../main/css/bootstrap.min.css';
        ?>
    </style>
</head>

<body>


    <div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="profile.php">Profile</a>
        <a class="nav-link" href="paymentmethod.php">Payment Method</a>
        <a class="nav-link" href="chats.php">Chats</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                <?php 
                if(isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];

                    if(isset($_FILES['profileimg']) && isset($_POST['btnUpload'])){
                        $file_name = $_FILES['profileimg']['name'];
                        $file_tmp = $_FILES['profileimg']['tmp_name'];

                        // Check if file is an image and has allowed extensions
                        $allowed_extensions = array('jpg', 'jpeg', 'png');
                        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                        
                        if(in_array($file_extension, $allowed_extensions)){
                            // Generate a random name for the uploaded file
                            $random_name = uniqid().".".$file_extension;
                            
                            // Directory where the image will be stored
                            $upload_path = 'profiles/';
                            $upload_destination = $upload_path . $random_name;

                            // Move the uploaded file to the destination directory
                            if(move_uploaded_file($file_tmp, $upload_destination)){

                                $profilecheck = "SELECT * FROM user_profile WHERE user_id = '$user_id'";
                                $checkresult = mysqli_query($conn, $profilecheck);
        
                                if($checkresult && mysqli_num_rows($checkresult) > 0){
                                    
                                    $update = "UPDATE user_profile SET img = '$random_name' WHERE user_id = '$user_id'";
                                    $updareresult = mysqli_query($conn, $update);

                                    if($updareresult) {
                                        $url = "profile.php?upload=true";
                                        echo "<script>window.location.href='" . $url. "' </script>";
                                        exit();
                                    } else {
                                        $url = "profile.php?upload=false";
                                        echo "<script>window.location.href='" . $url. "' </script>";
                                        exit();
                                    }
                                } else {
                                    $query = "INSERT INTO user_profile (user_id, img) VALUES ('$user_id', '$random_name')";
                                    $result = mysqli_query($conn, $query);
    
                                    if($result){
                                        $url = "profile.php?upload=true";
                                        echo "<script>window.location.href='" . $url. "' </script>";
                                        exit();

                                    } else {
                                        $url = "profile.php?upload=false";
                                        echo "<script>window.location.href='" . $url. "' </script>";
                                        exit();
                                    }
                                }
                            } else {
                                $url = "profile.php?upload=false";
                                echo "<script>window.location.href='" . $url. "' </script>";
                                exit();
                            }
                        } else {
                            $url = "profile.php?upload=false";
                            echo "<script>window.location.href='" . $url. "' </script>";
                            exit();
                        }
                    }
                }
                ?>
                <?php 
                $sqlprofile = "SELECT * FROM user_profile WHERE user_id = '$user_id'";
                $profileresult = mysqli_query($conn, $sqlprofile);

                if($profileresult && mysqli_num_rows($profileresult) > 0){
                    $profilerow = mysqli_fetch_assoc($profileresult);
                    ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Profile picture image (clickable) -->
                        <label for="profileimg">
                            <div class="rounded-circle overflow-hidden d-inline-block">
                                <img class="img-account-profile" src="profiles/<?php echo $profilerow['img']; ?>" alt="" style="cursor: pointer; width: 170px; height: 100px;">
                            </div>
                        </label>
                        <!-- Display selected file name -->
                        <div id="file-name" class="small font-italic text-muted mb-2"></div>
                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <!-- Profile picture upload button-->
                        <input type="file" name="profileimg" id="profileimg" accept="image/png, image/jpeg" style="display: none;" onchange="displayFileName(this)">
                        <button class="btn btn-primary" name="btnUpload">Upload</button>
                    </form>
                    <?php
                } else {
                    ?> 
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Profile picture image (clickable) -->
                        <label for="profileimg">
                            <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="" style="cursor: pointer;">
                        </label>
                        <!-- Display selected file name -->
                        <div id="file-name" class="small font-italic text-muted mb-2"></div>
                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <!-- Profile picture upload button-->
                        <input type="file" name="profileimg" id="profileimg" accept="image/png, image/jpeg" style="display: none;" onchange="displayFileName(this)">
                        <button class="btn btn-primary" name="btnUpload">Upload</button>
                    </form>
                    <?php
                }
                ?>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- modal edit account -->
            <div class="modal fade" id="editAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Account Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php 
                            if($_SESSION['user_id']){
                                $user_id = $_SESSION['user_id'];
                                
                                $sql = "SELECT user_info.firstname, user_info.lastname, user_info.gender, user_info.contact, user_info.address, user_account.username FROM user_info
                                JOIN user_account ON user_info.info_id = user_account.info_id
                                WHERE user_info.info_id = '$user_id'";
                                $result = mysqli_query($conn, $sql);

                                if($result && mysqli_num_rows($result) > 0){
                                    $row = mysqli_fetch_assoc($result);
                                    ?> 
                                    <?php 
                                    if(isset($_POST['btnSubmit'])){
                                        $username = $_POST['username'];
                                        $firstname = $_POST['firstname'];
                                        $lastname = $_POST['lastname'];
                                        $gender = $_POST['gender'];
                                        $contact = $_POST['contact'];
                                        $address =$_POST['address'];
                                        $password = $_POST['password'];
                                        $encrypyed_passwowrd = password_hash($password, PASSWORD_DEFAULT);

                                        $updateinfo = "UPDATE user_info SET firstname = '$firstname', lastname = '$lastname', gender = '$gender', contact = '$contact', address = '$address' WHERE info_id = '$user_id'";
                                        $inforesult = mysqli_query($conn, $updateinfo);

                                        if($inforesult) {
                                            $updateacc = "UPDATE user_account SET username = '$username', password = '$encrypyed_passwowrd' WHERE user_id = '$user_id'";
                                            $accresult = mysqli_query($conn, $updateacc);
                                            
                                            if($accresult){
                                                $url = "profile.php?success=true";
                                                echo "<script>window.location.href='" . $url . "' </script>";
                                                exit();
                                            }
                                        }
                                    }
                                    ?>
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputUsername">Username:</label>
                                            <input class="form-control" name="username" type="text" placeholder="Enter your username" value="<?php echo $row['username'] ?>" required>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName">First name</label>
                                                <input class="form-control" name="firstname" type="text" placeholder="Enter your first name" value="<?php echo $row['firstname'] ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLastName">Last name</label>
                                                <input class="form-control" name="lastname" type="text" placeholder="Enter your last name" value="<?php echo $row['lastname'] ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputPhone">Gender</label>
                                                <input class="form-control" name="gender" type="text" placeholder="Enter your phone number" value="<?php echo $row['gender'] ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputPhone">Phone number</label>
                                                <input class="form-control" name="contact" type="tel" placeholder="Enter your phone number" value="<?php echo $row['contact'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Address</label>
                                            <input class="form-control" name="address" type="text" placeholder="Enter your address" value="<?php echo $row['address'] ?>" required>
                                        </div>
                                        <h6> Account Details </h6>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input class="form-control" name="password" type="password" placeholder="Enter your password" pattern=".{8,16}" title="Password must be 8-16 characters" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="cpassword">Comfirm Password</label>
                                                <input class="form-control" name="cpassword" type="password" placeholder="Confirm password" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="btnSubmit">Save changes</button>
                                        </div>
                                    </form>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Account details card-->
            
            <div class="card mb-4">
                <div class="card-header">Account Information</div>
                <div class="card-body">
                    <?php 
                    if($_SESSION['user_id']){
                        $user_id = $_SESSION['user_id'];
                        
                        $sql = "SELECT user_info.firstname, user_info.lastname, user_info.gender, user_info.contact, user_info.address, user_account.username FROM user_info
                        JOIN user_account ON user_info.info_id = user_account.info_id
                        WHERE user_info.info_id = '$user_id'";
                        $result = mysqli_query($conn, $sql);

                        if($result && mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                            ?> 
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Username:</label>
                                    <input class="form-control" name="username" type="text" placeholder="Enter your username" value="<?php echo $row['username'] ?>" readonly>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFirstName">First name</label>
                                        <input class="form-control" name="firstname" type="text" placeholder="Enter your first name" value="<?php echo $row['firstname'] ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Last name</label>
                                        <input class="form-control" name="lastname" type="text" placeholder="Enter your last name" value="<?php echo $row['lastname'] ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Gender</label>
                                        <input class="form-control" name="gender" type="text" placeholder="Enter your phone number" value="<?php echo $row['gender'] ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Phone number</label>
                                        <input class="form-control" name="contact" type="tel" placeholder="Enter your phone number" value="<?php echo $row['contact'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Address</label>
                                    <input class="form-control" name="address" type="text" placeholder="Enter your address" value="<?php echo $row['address'] ?>" readonly>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAccount" style="margin-left: 290px"> Edit </button>
                                <a href="../login.php?logout=true">
                                    <button type="button" class="btn btn-danger">Logout</button>
                                </a>
                            </form>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
 
</div>
</div>
</body>

<script>
function displayFileName(input) {
    var file = input.files[0];
    var fileName = file.name;
    document.getElementById('file-name').innerHTML = fileName;
}
</script>

<script>
    function showAlert(type, message) {
        Swal.fire({
            icon: type,
            text: message,
        });
    }

    function checkURLParams() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === 'true') {
            showAlert('success', 'Account edited successfully!');
        } else if (urlParams.has('error') && urlParams.get('error') === 'true') {
            showAlert('warning', 'Password do not match!');
        } else if (urlParams.has('upload') && urlParams.get('upload') === 'true'){
            showAlert('success', 'Profile uploaded successfully!');
        } else if (urlParams.has('upload') && urlParams.get('upload') === 'false'){
            showAlert('warning', 'Something went wrong!');
        }
    }

    window.onload = checkURLParams;
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable(); 

        $('#editButton').click(function() {
            $('#editAccount').modal('show');
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- Include DataTables -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> <!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 



<?php
include('includes/footer.php');
?>
