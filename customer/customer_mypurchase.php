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
        <a class="nav-link" href="chats.php">Chats</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-8">
        
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
