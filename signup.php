<!DOCTYPE html>
<html lang="en">
<head>
  <title>Farming</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- baba kay sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <h2>Create Account</h2>
    <?php 
    include 'conn.php';
    session_start();

    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['gender']) && isset($_POST['contactnum']) && isset($_POST['address'])
    && isset($_POST['username']) && isset($_POST['password'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $contactnum = $_POST['contactnum'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $encrypted = password_hash($password, PASSWORD_DEFAULT);

        $check_username = "SELECT username FROM user_account WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_username);
        
        if($check_result && mysqli_num_rows($check_result) > 0) {
          // sweetalert exist
          echo "<script>
                  Swal.fire({
                      text: 'Username Already Exist',
                      icon: 'warning',
                      confirmButtonColor: '#3085d6',
                  });
                </script>";
      } else {
          $sql = "INSERT INTO user_info (firstname, lastname, gender, contact, address) VALUES ('$firstname', '$lastname', '$gender', '$contactnum', '$address')";
    
          if($conn->query($sql) === TRUE){
              $info_id = $conn->insert_id;
              $sql = "INSERT INTO user_level (level) VALUES (2)";
  
              if($conn->query($sql) === TRUE){
                  $level_id = $conn->insert_id;
                  $sql = "INSERT INTO user_account (username, password, level_id, info_id, status) VALUES ('$username', '$encrypted', '$level_id', '$info_id', 1)";
  
                  if($conn->query($sql) === TRUE){
                    // sweetalert success
                    echo "<script>Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Account Created Successfully',
                      showConfirmButton: false
                  });</script>";
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
    <form action="" method="POST">
        <div class="user-box">
            <input type="text" name="firstname" required>
            <label>First Name</label>
        </div>
        <div class="user-box">
            <input type="text" name="lastname" required>
            <label>Last Name</label>
        </div>
        <div class="user-box">
            <input type="text" name="gender" required>
            <label>Gender</label>
        </div>
        <div class="user-box">
            <input type="text" name="contactnum" required>
            <label>Contact Number</label>
        </div>
        <div class="user-box">
            <input type="text" name="address" required>
            <label>Address</label>
        </div>
        <div class="user-box">
            <input type="text" name="username" required>
            <label>Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" pattern=".{8,16}" title="Password must be 8-16 characters" required>
            <label>Password</label>
        </div>
            <button type="submit" name="submit">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Create Account
        </button>
    </form>
    <a href="login.php"> <button> Login </button> </a>
</div>

</body>
</html>
