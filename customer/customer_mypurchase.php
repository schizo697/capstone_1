<?php
include('includes/header.php');
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

        .logo {
            max-height: 120px;
            width: auto;
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="customer_profile.php">Profile</a>
        <a class="nav-link" href="customer_mypurchase.php">My Purchases</a>
        <a class="nav-link" href="#">Chats</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-15">
            <!-- Table Start -->
            <div class="container-fluid about pt-5">
                <div class="container">
                    <div class="row gx-9">
                        <div class="card">
                            <h1> My Purchase </h1>
                            <div class="card-header">
                                <p>- query to be change-</p>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Date of Order</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include "../conn.php";
                                        $uid = $_SESSION['user_id'];

                                        $sql = "SELECT * FROM product JOIN pcategory ON pcategory.catid = product.catid WHERE product.status = 'Not Available'";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr class="data-row">
                                                <td><?php echo $row['pname']; ?></td>
                                                <td><?php echo $row['category']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo date('F d, Y', strtotime($row['dateadded'])); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->
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
