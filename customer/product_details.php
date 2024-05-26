<?php
// Check if productId is provided and valid
if (isset($_GET['productId']) && !empty($_GET['productId'])) {
    include "../conn.php"; // Assuming you have a database connection established already

    // Sanitize productId to prevent SQL injection
    $productId = mysqli_real_escape_string($conn, $_GET['productId']);

    // Query to fetch product details from the database
    $query = "SELECT product.prodid, product.pname, product.quantity, product.price, listing.listid, listing.details, listing.imgid 
              FROM product 
              JOIN listing ON product.prodid = listing.prodid 
              WHERE product.prodid = '$productId'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if product exists
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
?>
        <!-- Display product details -->
        <div class="product-modal-content">
            <h5><?php echo htmlspecialchars($product['pname']); ?></h5>
            <img src="../img/products/<?php echo htmlspecialchars($product['imgid']); ?>" alt="Product Image" class="img-fluid product-image">
            <p class="product-price">Price: ₱ <?php echo htmlspecialchars($product['price']); ?></p>
            <p class="product-details">Details: <?php echo htmlspecialchars($product['details']); ?></p>
        </div>
<?php
    } else {
        // Product not found
        echo "<p>Product not found.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // No productId provided
    echo "<p>No product ID provided.</p>";
}
?>
