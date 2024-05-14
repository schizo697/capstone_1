<?php
session_start();

include 'main/includes/header.php';
include 'conn.php'; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Farming - Signup</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="main/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="main/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php
        include 'main/css/login.css';
        ?>
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Create Account</h2>
        <?php
        include 'conn.php';
        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['gender']) && isset($_POST['contact']) && isset($_POST['address']) && isset($_POST['username']) && isset($_POST['password'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $gender = $_POST['gender'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $encrypted = password_hash($password, PASSWORD_DEFAULT);

            $check_username = "SELECT username FROM user_account WHERE username = '$username'";
            $check_result = mysqli_query($conn, $check_username);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                // sweetalert exist
                echo "<script>
                  Swal.fire({
                      text: 'Username Already Exist',
                      icon: 'warning',
                      confirmButtonColor: '#3085d6',
                  });
                </script>";
            } else {
                $sql = "INSERT INTO user_info (firstname, lastname, gender, contact, address) VALUES ('$first_name', '$last_name', '$gender', '$contact', '$address')";

                if ($conn->query($sql) === TRUE) {
                    $info_id = $conn->insert_id;

                    $sql = "INSERT INTO user_level (level) VALUES (2)";
                    if ($conn->query($sql) === TRUE) {
                        $level_id = $conn->insert_id;
                        $sql = "INSERT INTO user_account (username, password, level_id, info_id, status) VALUES ('$username', '$encrypted', '$level_id', '$info_id', 2)";

                        if ($conn->query($sql) === TRUE) {
                          // sweetalert success
                          echo "<script>
                              Swal.fire({
                                  position: 'center',
                                  icon: 'success',
                                  title: 'Account Created Successfully',
                                  showConfirmButton: false
                              });
                              setTimeout(function() {
                                  window.location.href = 'login.php';
                              }, 2000); // 2 seconds delay
                          </script>";
                      } else {
                          // sweetalert error
                          echo "<script>
                              Swal.fire({
                                  icon: 'error',
                                  text: 'Something went wrong!',
                              });
                          </script>";
                        }
                    }
                }
            }
        }
        ?>
        <div class="col-md-12">
            <div class="row justify-content-center align-items-center">
                <form action="" method="POST" class="w-100">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="first_name" id="first_name" class="form-control form-control-lg bg-light fs-6" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="last_name" id="last_name" class="form-control form-control-lg bg-light fs-6" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="gender" id="gender" class="form-control form-control-lg bg-light fs-6" placeholder="Gender" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="contact" id="contact" class="form-control form-control-lg bg-light fs-6" placeholder="Contact" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" name="address" id="address" class="form-control form-control-lg bg-light fs-6" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="username" id="username" class="form-control form-control-lg bg-light fs-6" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <button type="submit" name="submit" class="btn btn-lg btn-primary w-100 fs-6">Signup
                                    <span class="loading-text" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

</body>
<script src="main/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
