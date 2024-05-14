<?php 
session_start();

include('main/includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Farming</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- baba kay sweetalert -->
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
    <h2>Login</h2>
    <?php
    include 'conn.php'; // Include database connection

    // Check if logout parameter is set and true
    if(isset($_GET['logout']) && $_GET['logout'] == 'true') {
        // If user is logged in, update isOnline status to NULL
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $updateIsOnline = "UPDATE user_account SET isOnline = NULL WHERE user_id = '$user_id'";
            mysqli_query($conn, $updateIsOnline);

            session_destroy();
            header("Location: login.php");
            exit;
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $escaped_username = mysqli_real_escape_string($conn, $username);

            $sql = "SELECT password, level_id, user_id FROM user_account WHERE username = '$escaped_username'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $row['user_id']; // Store user_id in session
                    
                    $level_id = $row['level_id'];
                    $sql = "SELECT level FROM user_level WHERE level_id = '$level_id'";
                    $level_result = mysqli_query($conn, $sql);

                    if ($level_result && mysqli_num_rows($level_result) == 1) {
                        $level_row = mysqli_fetch_assoc($level_result);
                        $user_level = $level_row['level'];
                        
                        if ($user_level == 2) {
                            header("location: customer/customer_dashboard.php");
                            exit();
                        } elseif ($user_level == 3) {
                            header("location: farmer/farmer_dashboard.php");
                            exit();
                        }
                    } else {
                        $error = "Error fetching user level";
                    }
                } else {
                    $error = "Username or password is incorrect";
                }
            } else {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    text: "Incorrect Username or Password"
                });
                </script>';            
            }
        }
    }
    ?>
  
    <div class="col-md-12 right-box">
        <div class="row align-items-center">
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="username" id="username" class="form-control form-control-lg bg-light fs-6" placeholder="Username">
                </div>
                <div class="input-group mb-1">
                    <input type="password" name="password" id="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                </div>
                <!-- <div class="input-group mb-5 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck">
                        <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                    </div>
                    <div class="forgot">
                        <small><a href="resetpw.php">Forgot Password?</a></small>
                    </div>
                </div> -->
                <div class="input-group mb-3">
                    <button type="submit" name="submit" class="btn btn-lg btn-primary w-100 fs-6">Login
                    <span class="loading-text" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </span></button>
                </div>
                <div class="row">
                    <small>Don't have account? <a href="signup.php">Sign Up</a></small>
                </div>
            </form>
          </div>
       </div> 
</body>
<script src="main/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
