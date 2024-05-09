<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="assets/dist/img/bp.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Web-Based Farmer’s <br>Market with Supply-Demand <br>Forecasting</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
      <?php
// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    // Include connection file if not already included
    include 'conn.php';

    // Fetch user information using the user_id from session
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT firstname, lastname FROM user_info WHERE info_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $name = $firstname . ' ' . $lastname;
        // Display the username
        echo '<a href="#" class="d-block">' . $name . '</a>';
    } else {
        echo '<a href="#" class="d-block">Error fetching username</a>';
    }
} else {
    echo '<a href="#" class="d-block">User not logged in</a>';
}
?>

      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
          <a href="admin_dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="user_management.php" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              User Management
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="chat_module.php" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Chat Module
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="trend_forecast.php" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Trend Forecast
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="product_management.php" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
              Product Management
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var currentPath = window.location.pathname;
    var navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(function(navLink) {
      var href = navLink.getAttribute("href");
      // Check if the current path contains the href (to handle cases where the href has more details)
      if (currentPath.includes(href)) {
        navLink.classList.add("active");
      }
    });
  });
</script>
