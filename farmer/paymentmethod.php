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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Payment Setting</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">    
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    <!-- /.content-header -->

    <div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="profile.php">Profile</a>
        <a class="nav-link" href="paymentmethod.php">Payment Method</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-8">
            <!-- modal edit account -->
            <div class="modal fade" id="editAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payment Credentials</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php
                            include '../conn.php';

                            if(isset($_POST['btnSubmit'])) {
                                $name = $_POST['name'];
                                $number = $_POST['number'];
                                $uid = $_SESSION['user_id'];

                                $sql = "INSERT INTO paymentmethod (accname, accnumber, uid, status) VALUES (?, ?, ?, 'Active')";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sss", $name, $number, $uid);
                                if($stmt->execute()) {
                                    $url = "paymentmethod.php?success=true";
                                    echo '<script>window.location.href= "' . $url . '";</script>'; 
                                } else {
                                    echo "<script>Swal.fire({
                                        icon: 'error',
                                        text: 'Something went wrong!',
                                    });
                                    </script>";
                                } 
                                        
                            }
                            ?>
                            <form action="" method="POST">
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="name">Account name <span style = "color:red;">*</span></label>
                                        <input class="form-control" type="text" name = "name" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="number">Account number <span style = "color:red;">*</span></label>
                                        <input class="form-control" type="text" name = "number" placeholder="Enter your number" maxlength="11" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="btnSubmit">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Account details card-->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAccount" style="margin-left: 0px"> Add Payment Method </button>
            <br>
            <br>
            <div class="card mb-4">
                <div class="card-header">Account Information</div>
                    <div class="card-body">
                    <?php 
                        include "../conn.php";
                                        
                        $uid = $_SESSION['user_id'];
                            
                        $farmer = "SELECT * FROM paymentmethod WHERE uid = '$uid'";
                        $fetch = $conn->query($farmer);
                    ?>               
                    <?php 
                        while($row = mysqli_fetch_assoc($fetch)){ 
                    ?>
                    <!-- Payment method-->
                        <div class="d-flex align-items-center justify-content-between px-4">
                            <div class="d-flex align-items-center">
                                <i class="fab fa-cc-mastercard fa-2x cc-color-mastercard"></i>
                                    <div class="ms-4">
                                        <div class="small">Gcash</div>
                                        <div class="text-xs text-muted">Last added on <?php echo $row['dateadded'];?> | Status: <?php echo $row['status'];?></div>
                                        <div class="text-xs text-muted">Status: 
                                            <?php 
                                                if ($row['status'] == 'Active') {
                                                    echo '<p class="badge bg-success" style = "color:white;">Active</p>';
                                                } else {
                                                    echo '<p class="badge bg-danger" style = "color:white;">Inactive</p>';
                                                }
                                            ?>   
                                        </div>
                                    </div>
                            </div>
                            <div class="ms-4 small">
                                <a href="#" class="edit" data-id='<?php echo $row['pmethod_ID']; ?>'>Edit</a>
                                <label>
                                    <p> <a href="adminstatus.php?id='.$row['user_ID'].'&status=Inactive" class="btn btn-success">Active</a></p>
                                </label>
                            </div>
                        </div>
                        <?php } ?>
                        <form action="" method="POST">
                        </form>
                    </div>
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
            showAlert('success', 'Account added successfully!');
        } else if (urlParams.has('error') && urlParams.get('error') === 'true') {
            showAlert('warning', 'Password do not match!');
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
