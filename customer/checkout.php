<?php 
include 'includes/header.php';
include '../conn.php';
include 'includes/checkout.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="container-fluid bg-green text-white py-4">
        <div class="container text-center">
            <p class="mb-0"><a class="text-secondary fw-bold" ></a></p>
        </div>
    </div>
    <br><br>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="container">

    <div class="row">
        <div class="col-xl-8">

            <div class="card">
                <div class="card-body">
                    <ol class="activity-checkout mb-0 px-4 mt-3">
                        <li class="checkout-item">
                            <div class="avatar checkout-icon p-1">
                                <div class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bxs-receipt text-white font-size-20"></i>
                                </div>
                            </div>
                            <div class="feed-item-list">
                                <div>
                                    <h5 class="font-size-16 mb-1">Address Info</h5>
                                    <p class="text-muted text-truncate mb-4">Set your address</p>
                                    <div class="mb-3">
                                        <?php 
                                        if(isset($_SESSION['user_id'])){
                                            $user_id = $_SESSION['user_id'];

                                            if(isset($_GET['prodid'])){
                                                $prodid = $_GET['prodid'];
                                            } 

                                            $profile = "SELECT * FROM user_info WHERE info_id = '$user_id'";
                                            $profileres = mysqli_query($conn, $profile);
    
                                            if($profileres && mysqli_num_rows($profileres) > 0){
                                                $profilerow = mysqli_fetch_assoc($profileres);
                                            }
                                            ?>
                                            <form action="" method="POST" id="address-info">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="billing-name">Name</label>
                                                                <input type="hidden" class="form-control" id="firstname" name="firstname" value="<?php echo $profilerow['firstname']?>">
                                                                <input type="hidden" class="form-control" id="lastname" name="lastname" value="<?php echo $profilerow['lastname']?>">
                                                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $profilerow['firstname'] . ' ' . $profilerow['lastname']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="billing-phone">Phone</label>
                                                                <input type="text" class="form-control" id="billing-phone" name="phone" value="<?php echo $profilerow['contact']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="billing-address">Address</label>
                                                        <input class="form-control" id="billing-address" name="address" rows="3" value="<?php echo $profilerow['address']; ?>">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-0">
                                                                <label class="form-label" for="zip-code">Postal code</label>
                                                                <input type="text" class="form-control" id="postal-code" name="postal" value="<?php echo $profilerow['postal_code']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="checkout-item">
                            <div class="avatar checkout-icon p-1">
                                
                            </div>
                           
                        <li class="checkout-item">
                            <div class="avatar checkout-icon p-1">
                                <div class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                </div>
                            </div>
                            <div class="feed-item-list">
                                <div>
                                    <h5 class="font-size-16 mb-1">Payment method</h5>
                                    <p class="text-muted text-truncate mb-4">Choose payment method</p>
                                </div>
                                <div>
                                    <h5 class="font-size-14 mb-3">Payment method :</h5>
                                    <form action="" method="POST" id="payment-method">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                                <div data-bs-toggle="collapse">
                                                    <label class="card-radio-label">
                                                        <input type="radio" name="pay-method" id="pay-methodoption1" class="card-radio-input">
                                                        <span class="card-radio py-3 text-center text-truncate">
                                                        <i class="bx bx-wallet d-block h2 mb-3"></i>
                                                            Gcash
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label class="card-radio-label">
                                                        <input type="radio" name="pay-method" id="pay-methodoption3" class="card-radio-input" checked="">
                                                        <span class="card-radio py-3 text-center text-truncate">
                                                            <i class="bx bx-money d-block h2 mb-3"></i>
                                                            <span>Cash on Delivery</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row my-4">
                <div class="col">
                    <a href="customer_dashboard.php" class="btn btn-link text-muted">
                        <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping </a>
                </div> <!-- end col -->
                <div class="col">
                    <?php 
                    
                    ?>
                    <form action="" methos="POST">
                        <div class="text-end mt-2 mt-sm-0">
                            <button  type="submit" id="placeorder" name="placeorder" class="btn btn-success">
                                <i class="mdi mdi-cart-outline me-1"></i> Place Order </button>
                        </div>
                    </form>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div>
        <div class="col-xl-4">
    <div class="card checkout-order-summary" style="width: 500px;">
        <div class="card-body">
            <div class="p-3 bg-light mb-3">
                <h5 class="font-size-16 mb-0">Order Summary</h5>
            </div>
                <div class="table-responsive">
                    <table class="table table-centered mb-0 table-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-top-0" style="width: 110px;" scope="col">Product</th>
                                    <th class="border-top-0" scope="col">Product Desc</th>
                                    <th class="border-top-0" scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($_SESSION['user_id'])){
                                    $user_id = $_SESSION['user_id'];

                                    if(isset($_GET['selected_prodids'])){
                                        $prodid = $_GET['selected_prodids'];

                                        if(empty($prodid)){
                                            $url = "customer_cart.php";
                                            echo "<script>window.location.href= ' $url '</script>";
                                            exit();
                                        }

                                        $cart = "SELECT cart.pname, cart.quantity, product.price, listing.imgid FROM cart 
                                        JOIN product ON cart.prodid = product.prodid
                                        JOIN listing ON cart.prodid = listing.prodid
                                        WHERE user_id = '$user_id' AND cart.prodid IN ($prodid)";
                                        $cartres = mysqli_query($conn, $cart);

                                        // Initialize total outside the loop
                                        $total = 0;

                                        if($cartres && mysqli_num_rows($cartres) > 0){
                                            while($cartrow = mysqli_fetch_assoc($cartres)){
                                                $pname = $cartrow['pname'];
                                                $quantity = $cartrow['quantity'];
                                                $price = $cartrow['price'];
                                                $img = $cartrow['imgid'];
                                                $subtotal = $price * $quantity; // Calculate subtotal for each item
                                                $total += $subtotal; // Add subtotal to total

                                                ?>
                                                <tr>
                                                    <th scope="row"><img src="../img/products/<?php echo $img; ?>" alt="product-img" title="product-img" class="avatar-lg rounded"></th>
                                                    <td>
                                                        <h5 class="font-size-16 text-truncate"><a href="#" class="text-dark"><?php echo $pname; ?></a></h5>
                                                        <p class="text-muted mb-0 mt-1">₱ <?php echo $price; ?> x <?php echo $quantity; ?></p>
                                                    </td>
                                                    <td>₱ <?php echo $subtotal; ?></td> <!-- Display subtotal for each item -->
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <h5 class="font-size-14 m-0">Sub Total :</h5>
                                    </td>
                                    <td>
                                        <?php echo '₱' . $total; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h5 class="font-size-14 m-0">Shipping Charge :</h5>
                                    </td>
                                    <td>
                                        ₱100
                                    </td>
                                </tr>                           
                                <tr class="bg-light">
                                    <td colspan="2">
                                        <h5 class="font-size-14 m-0">Total:</h5>
                                    </td>
                                    <td>
                                        <?php echo '₱' . $total + 100; ?>
                                    </td>
                                </tr>
                                <form action="" method="POST" id="order-summary">
                                    <input type="hidden" name="prodid" value="<?php echo $prodid; ?>">
                                    <input type="hidden" name="userid" value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="total" value="<?php echo $total + 100; ?>">
                                    <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    
</div>
   <!-- Footer -->
   <div class="container-fluid bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <a class="text-secondary fw-bold" href="#">Farmer's Market 2024</a></p>
        </div>
    </div>
    <!-- Footer End -->
    <script>
    document.getElementById('placeorder').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Gather input values from the address-info form
        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var phone = document.getElementById('billing-phone').value;
        var address = document.getElementById('billing-address').value;
        var postal = document.getElementById('postal-code').value;

        // Gather input values from the payment-method form
        var payMethod = document.querySelector('input[name="pay-method"]:checked').value;

        // Gather input values from the order-summary form
        var prodid = document.querySelector('input[name="prodid"]').value;
        var userid = document.querySelector('input[name="userid"]').value;
        var quantity = document.querySelector('input[name="quantity"]').value;
        var total = document.querySelector('input[name="total"]').value;

        // Create a new form to submit the data
        var formData = document.createElement('form');
        formData.method = 'POST';
        formData.action = 'placeorder.php'; // Replace with your PHP script URL

        // Create hidden input fields and set their values
        var inputs = [
            { name: 'firstname', value: firstname },
            { name: 'lastname', value: lastname },
            { name: 'phone', value: phone },
            { name: 'address', value: address },
            { name: 'postal', value: postal },
            { name: 'payMethod', value: payMethod },
            { name: 'prodid', value: prodid },
            { name: 'userid', value: userid },
            { name: 'quantity', value: quantity },
            { name: 'total', value: total }
        ];

        // Append hidden input fields to the form
        inputs.forEach(function(input) {
            var inputField = document.createElement('input');
            inputField.type = 'hidden';
            inputField.name = input.name;
            inputField.value = input.value;
            formData.appendChild(inputField);
        });

        // Append the form to the document body and submit it
        document.body.appendChild(formData);
        formData.submit();
    });
</script>






</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict'

      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation')

        // Loop over them and prevent submission
        Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
      }, false)
    }())
</script>
 <!-- Back to Top -->
 <a href="#" class="btn btn-secondary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../lib/easing/easing.min.js"></script>
<script src="../lib/waypoints/waypoints.min.js"></script>
<script src="../lib/counterup/counterup.min.js"></script>
<script src="../lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="../main/js/main.js"></script>
</body>
</html>
