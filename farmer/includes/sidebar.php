<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="assets/dist/img/bp.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
        <a href="profile.php" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#sidebarproduct" aria-expanded="false" aria-controls="sidebarproduct" class="nav-link">
            <i class="uil-folder-plus"></i>
            <span><i class="fas fa-th"></i> Product Management</span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarproduct">
            <ul class="nav nav-second-level">
              <li class="nav-item">
                <a href="products.php" class="nav-link"><i class="far fa-circle nav-icon"></i> Products </a>
              </li>
            </ul>
            <ul class="nav nav-second-level">
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i> Inventory </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Product Selling</p>
          </a>
        </li>  

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-money-bill"></i>
            <p>Payment</p>
          </a>
        </li>  

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#sidebarreport" aria-expanded="false" aria-controls="sidebarreport" class="nav-link">
            <i class="uil-folder-plus"></i>
            <span><i class="fas fa-money-bill"></i> Reports</span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="sidebarreport">
            <ul class="nav nav-second-level">
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i> Customers </a>
              </li>
            </ul>
            <ul class="nav nav-second-level">
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i> Orders </a>
              </li>
            </ul>
            <ul class="nav nav-second-level">
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i> Sales </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<!-- Include the required JavaScript files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.4/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Enable the dropdown functionality for the sidebar
    $('.sidebar .nav-treeview').slideUp(0);
    $('.sidebar .nav-item .nav-link').on('click', function() {
      $(this).parent().siblings().find('.nav-treeview').slideUp();
      $(this).next('.nav-treeview').slideToggle();
    });
  });
</script>