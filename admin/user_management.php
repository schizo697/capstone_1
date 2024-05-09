<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">    
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- modal add account-->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAccountModal">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <?php
    include 'conn.php';

    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['accountlevel'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $account_level = $_POST['accountlevel'];
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

        $check_username = "SELECT username FROM user_account WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_username);

        if($check_result && mysqli_num_rows($check_result) > 0) {
            // Redirect to user_management.php with exist=true parameter
            $url = "user_management.php?exist=true";
            echo '<script>window.location.href = "' . $url . '";</script>';
            exit(); // Exiting to prevent further execution
        } else {
            $sql = "INSERT INTO user_info (firstname, lastname) VALUES ('$firstname', '$lastname')";
            if(mysqli_query($conn, $sql)) {
                $info_id = mysqli_insert_id($conn);
            
                $sql = "INSERT INTO user_level (level) VALUES ('$account_level')";
                if(mysqli_query($conn, $sql)){
                    $level_id = mysqli_insert_id($conn);
                    $sql = "INSERT INTO user_account (username, password, level_id, info_id, status) VALUES ('$username', '$encrypted_password', $level_id, $info_id, 1)";
            
                    if(mysqli_query($conn, $sql)) {
                        $url = "user_management.php?success=true";
                        echo '<script>window.location.href= "' . $url . '";</script>';
                        exit(); 
                    } else {
                        $url = "user_management.php?error=true";
                        echo '<script>window.location.href="' . $url . '";</script';
                        exit();
                    }
                }
            }
        }
    }
    ?>
        <form action="" method="POST" id="createAccountForm">
            <div class="modal-body">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control" id="firstName" name="firstname" placeholder="Enter first name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" class="form-control" id="lastName" name="lastname" placeholder="Enter last name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" pattern=".{8,16}" title="Password must be 8-16 characters" required>
                </div>
                <div class="form-group">
                    <select name="accountlevel" class="form-select" aria-label="Account Type" required>
                        <option selected disabled>Account Type</option>
                        <option value="2">Customer</option>
                        <option value="3">Seller</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
    </div>

<!-- edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php
      if(isset($_POST['btnSave'])){
        $user_id = $_POST['userid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

        if ($password != $cpassword) {
            $url = 'user_management.php?errorpassword=true';
            echo '<script>window.location.href="' . $url . '"</script>';
            exit();
        } else {
            $infoupdate = "UPDATE user_info SET firstname = '$firstname', lastname = '$lastname', gender = '$gender', contact = '$contact', address = '$address' WHERE info_id = '$user_id'";
            $inforesult = mysqli_query($conn, $infoupdate);
    
            if($inforesult) {
                $passwordupdate = "UPDATE user_account SET password = '$encrypted_password' WHERE user_id = '$user_id'";
                $passwordresult = mysqli_query($conn, $passwordupdate);
    
                if($passwordresult){
                    $url = 'user_management.php?update=true';
                    echo '<script>window.location.href= "' . $url . '"</script>';
                    exit();
                } else {
                    $url = "user_management.php?error=true";
                    echo '<script>window.location.href="' . $url . '";</script';
                    exit();
                }
            }
        }
      }
      ?>
      <form action="" method="POST"> 
        <div class="modal-body">
            <div class="form-group">
                <label for="userID">User ID:</label>
                <input type="text" class="form-control" id="userID" name="userid" placeholder="User ID" required readonly>
            </div>
            <div class="form-group">
                <label for="editFirstName">First Name:</label>
                <input type="text" class="form-control" id="editFirstName" name="firstname" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <label for="editLastName">Last Name:</label>
                <input type="text" class="form-control" id="editLastName" name="lastname" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <label for="editGender">Gender:</label>
                <input type="text" class="form-control" id="editGender" name="gender" placeholder="Gender" required>
            </div>
            <div class="form-group">
                <label for="editContact">Contact:</label>
                <input type="text" class="form-control" id="editContact" name="contact" placeholder="Contact" required>
            </div>
            <div class="form-group">
                <label for="editAddress">Address:</label>
                <input type="text" class="form-control" id="editAddress" name="address" placeholder="Address" required>
            </div>
            <div class="form-group">
                <label for="editPassword">Password:</label>
                <input type="password" class="form-control" id="editPassword" name="password" placeholder="Password" pattern=".{8,16}" title="Password must be 8-16 characters" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" class="form-control" id="confirmPassword" name="cpassword" placeholder="Confirm Password" required>
            </div>
            <div id="passwordError" style="color: red;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="btnSave" id="validateButton" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- archive modal -->
    <div class="modal fade" id="archivemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Archive</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <?php 
            if(isset($_POST['btnArchive'])){
                $user_id = $_POST['userid'];

                $statusupdate = "UPDATE user_account SET status = 0 WHERE user_id = '$user_id'";
                $statusresult = mysqli_query($conn, $statusupdate);

                if($statusresult){
                    $url = "user_management.php?archive=true";
                    echo '<script>window.location.href="' . $url . '"</script>';
                    exit();
                } else {
                    $url = "user_management.php?error=true";
                    echo '<script>window.location.href="' . $url . '";</script';
                    exit();
                }
            }
            ?>
            <form action="" method="POST">
                <div class="modal-body">
                    Are you sure you want to archive this account?
                </div>
                <div class="form-group" style="display: none;">
                    <label for="userid">User ID</label>
                    <input type="text" class="form-control" id="userid" name="userid" required readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="btnArchive" class="btn btn-primary">Archive</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <div class="table-responsive">
            <div class="card-header">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
            Add Account
            </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT user_id, username, firstname, lastname, gender, contact, address, level, status
        FROM user_account 
        JOIN user_info ON user_account.info_id = user_info.info_id
        JOIN user_level ON user_account.level_id = user_level.level_id WHERE status = 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['user_id'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $name = $firstname . ' ' . $lastname;
                $username = $row['username'];
                $gender = $row['gender'];
                $contact = $row['contact'];
                $address = $row['address'];
                $level = $row['level'];
                $type = '';
                switch ($level) {
                    case 1:
                        $type = 'Admin';
                        break;
                    case 2:
                        $type = 'Customer';
                        break;
                    case 3:
                        $type = 'Seller';
                        break;
                    default:
                        $type = 'Unknown';
                        break;
                }
                ?> 
                <tr>
                    <td><?php echo $name ?></td>
                    <td><?php echo $gender ?></td>
                    <td><?php echo $contact ?></td>
                    <td><?php echo $address ?></td>
                    <td><?php echo $type ?></td>
                    <td>
                    <a href="#" class="btn btn-success edit-button" data-bs-toggle="modal" data-bs-target="#editmodal" data-account-id="<?php echo $user_id?>" data-account-fname="<?php echo $firstname?>" data-account-lname="<?php echo $lastname?>"
                        data-account-gender="<?php echo $gender?>" data-account-contact="<?php echo $contact?>" data-account-address="<?php echo $address?>" data-account-type="<?php echo $type?>">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                    <a href="#" class="btn btn-primary archive-button" data-bs-toggle="modal" data-bs-target="#archivemodal" data-account-id="<?php echo $user_id?>">
                        <i class="mdi mdi-archive"></i>
                    </a>
                    </td>
                    
                </tr>
                <?php
            }
        } else {
            echo "No records found";
        }
        ?>
</tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>

<script>
$(document).ready(function() {
    $('.archive-button').click(function() {
        var userid = $(this).data('account-id');
        $('#userid').val(userid);
    });
});
</script>

<script>
$(document).ready(function() {
    $('.edit-button').click(function() {
        var userID = $(this).data('account-id');
        var fname = $(this).data('account-fname');
        var lname = $(this).data('account-lname'); 
        var gender = $(this).data('account-gender');
        var contact = $(this).data('account-contact');
        var address = $(this).data('account-address');

        $('#userID').val(userID);
        $('#editFirstName').val(fname);
        $('#editLastName').val(lname);
        $('#editGender').val(gender);
        $('#editContact').val(contact);
        $('#editAddress').val(address);
    });
});
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
        if (urlParams.has('exist') && urlParams.get('exist') === 'true') {
            showAlert('warning', 'Username Already Exists');
        } else if (urlParams.has('success') && urlParams.get('success') === 'true') {
            showAlert('success', 'Account added successfully');
        } else if (urlParams.has('error') && urlParams.get('error') === 'true') {
            showAlert('error', 'Something went wrong!');
        } else if (urlParams.has('update') && urlParams.get('update') === 'true') {
            showAlert('success', 'Account updated successfully');
        } else if (urlParams.has('errorpassword') && urlParams.get('errorpassword') === 'true') {
            showAlert('error', 'Password do not match');
        } else if (urlParams.has('archive') && urlParams.get('archive') === 'true') {
            showAlert('success', 'Account archived successfully');
        }
    }

    window.onload = checkURLParams;
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
