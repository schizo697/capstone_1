<!DOCTYPE html>
<html lang="en">
<head>
  <title>Farming</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <style>
      html {
  height: 100%;
}
body {
  margin:0;
  padding:0;
  font-family: sans-serif;
  background: linear-gradient(#2af598, #08b3e5);
}

.login-box {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  padding: 40px;
  transform: translate(-50%, -50%);
  background: rgba(0,0,0,.5);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 10px;
}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
}

.login-box .user-box {
  position: relative;
}

.login-box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.login-box .user-box label {
  position: absolute;
  top:0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: .5s;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #f68e44;
  font-size: 12px;
}

.login-box button {
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #22e4ac;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  margin-top: 40px;
  letter-spacing: 4px;
  border: none;
  background-color: transparent;
  cursor: pointer;
}

.login-box button:hover {
  background: #08b3e5;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #08b3e5,
              0 0 25px #2af598,
              0 0 50px #22e4ac,
              0 0 100px #d5cf1e;
}

.login-box button span {
  position: absolute;
  display: block;
}

.login-box button span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #08b3e5);
  animation: btn-anim1 1s linear infinite;
}

@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,100% {
    left: 100%;
  }
}

.login-box button span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #08b3e5);
  animation: btn-anim2 1s linear infinite;
  animation-delay: .25s
}

@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,100% {
    top: 100%;
  }
}

.login-box button span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #08b3e5);
  animation: btn-anim3 1s linear infinite;
  animation-delay: .5s
}

@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,100% {
    right: 100%;
  }
}

.login-box button span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #08b3e5);
  animation: btn-anim4 1s linear infinite;
  animation-delay: .75s
}

@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,100% {
    bottom: 100%;
  }
}

  </style>
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

            $sql = "SELECT password, level_id FROM user_account WHERE username = '$escaped_username'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username;
                    
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
