<!DOCTYPE html>
<html lang="en">
<head>
  <title>Farming</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include('includes/login_css.php'); ?>
</head>
<body>
    
  <div class="login-box">
    <h2>Login</h2>
    <?php
    include 'conn.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $escaped_username = mysqli_real_escape_string($conn, $username);

            $sql = "SELECT user_id, password, level_id FROM user_account WHERE username = '$escaped_username'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) == 1) {
              $row = mysqli_fetch_assoc($result);
              $hashed_password = $row['password'];
          
              if (password_verify($password, $hashed_password)) {
                  $user_id = $row['user_id'];
                  $_SESSION['user_id'] = $user_id; // Updated this line to store user_id
          
                  $level_id = $row['level_id'];
                  $sql = "SELECT level FROM user_level WHERE level_id = '$level_id'";
                  $level_result = mysqli_query($conn, $sql);
          
                  if ($level_result && mysqli_num_rows($level_result) == 1) {
                      $level_row = mysqli_fetch_assoc($level_result);
                      $user_level = $level_row['level'];
          
                      if ($user_level == 1) {
                          header("location: admin_dashboard.php");
                          exit();
                      } 
                  } else {
                      $error = "Error fetching user level";
                  }
              } else {
                  $error = "Username or password is incorrect";
              }
          } else {
              echo "<script>
              Swal.fire({
                icon: 'error',
                text: 'Incorrect Username or Password ',
              });
              </script>";
          }          
        }
    }
    ?>
    <form action="" method="POST">
      <div class="user-box">
        <input type="text" name="username" required>
        <label>Username</label>
      </div>
      <div class="user-box">
        <input type="password" name="password" required>
        <label>Password</label>
      </div>
      <button type="submit" name="submit">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Login
      </button>
    </form>
  </div>
</body>
</html>
