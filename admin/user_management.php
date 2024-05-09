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
<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        z-index: 1000;
        overflow: auto;
        animation: fadeIn 0.3s ease; /* Fade-in animation */
    }

    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    /* Fade-in animation keyframes */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>


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
    <div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Create Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
    </div>

    <!-- modal edit account -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
            <div class="card-header">
            <button type="submit" name="submit" class="btn btn-success" id="openModalBtn">Add Account</button>
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
        $sql = "SELECT firstname, lastname, gender, contact, address, level
        FROM user_account 
        JOIN user_info ON user_account.info_id = user_info.info_id
        JOIN user_level ON user_account.level_id = user_level.level_id";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
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
                    <td><?php echo $firstname . ' ' . $lastname?></td>
                    <td><?php echo $gender ?></td>
                    <td><?php echo $contact ?></td>
                    <td><?php echo $address ?></td>
                    <td><?php echo $type ?></td>
                    <td>
                        <a href=#>
                            <button type="button" class="btn btn-success"><i class="mdi mdi-pencil"></i></button>
                        </a>
                        <a href=#>
                            <button type="button" class="btn btn-warning"><i class="mdi mdi-archive"></i></button>
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
            showAlert('success', 'User added successfully');
        } else if (urlParams.has('error') && urlParams.get('error') === 'true') {
            showAlert('error', 'Something went wrong!');
        }
    }

    window.onload = checkURLParams;
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

<script>
    document.addEventListener("DOMContentLoaded", function(){
        var openModalbtn = document.getElementById('openEditModalBtn')
    })
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
