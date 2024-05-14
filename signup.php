<?php 
session_start();

include('main/includes/header.php');
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
</head>
<style>     
  <?php
    include 'main/css/login.css';
  ?>
</style>
<body>
    
  <div class="login-box">
    <h2>Signup</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['contact'], $_POST['address'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $first_name = $_POST['first_name'];
            $middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : ''; // Optional field
            $last_name = $_POST['last_name'];
            $gender = isset($_POST['gender']) ? $_POST['gender'] : ''; // Optional field
            $contact = $_POST['contact'];
            $address = $_POST['address'];

            // Sanitize inputs
            $escaped_username = mysqli_real_escape_string($conn, $username);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Check if the username already exists
            $sql_check = "SELECT username FROM user_account WHERE username = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $escaped_username);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    text: "Username already exists"
                });
                </script>';
            } else {
                // Insert into user_info table
                $sql_insert_info = "INSERT INTO user_info (firstname, lastname, gender, contact, address) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert_info = $conn->prepare($sql_insert_info);
                $stmt_insert_info->bind_param("sssss", $first_name, $last_name, $gender, $contact, $address);

                if ($stmt_insert_info->execute()) {
                    // Get the info_id of the newly inserted user_info
                    $info_id = $stmt_insert_info->insert_id;

                    // Insert into user_account table
                    $sql_insert_account = "INSERT INTO user_account (username, password, level_id, info_id, statues, isOnline) VALUES (?, ?, 2, ?, 1, 0)";
                    $stmt_insert_account = $conn->prepare($sql_insert_account);
                    $stmt_insert_account->bind_param("ssi", $escaped_username, $hashed_password, $info_id);

                    if ($stmt_insert_account->execute()) {
                        echo '<script>
                        Swal.fire({
                            icon: "success",
                            text: "Signup successful"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "login.php";
                            }
                        });
                        </script>';
                    } else {
                        echo '<script>
                        Swal.fire({
                            icon: "error",
                            text: "Error in registration"
                        });
                        </script>';
                    }

                    $stmt_insert_account->close();
                } else {
                    echo '<script>
                    Swal.fire({
                        icon: "error",
                        text: "Error in registration"
                    });
                    </script>';
                }

                $stmt_insert_info->close();
            }

            $stmt_check->close();
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
                            <input type="text" name="gender" id="gender" class="form-control form-control-lg bg-light fs-6" placeholder="Gender">
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
