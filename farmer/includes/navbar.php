<nav class="navbar navbar-expand-lg bg-primary navbar-dark shadow-sm py-3 py-lg-0 px-3 px-lg-5">
        <a href="index.html" class="navbar-brand d-flex d-lg-none">
            <h1 class="m-0 display-4 text-secondary"><span class="text-white">Farm</span>Fresh</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="farmer_dashboard.php" class="nav-item nav-link">Dashboard</a>
                <a href="forecast.php" class="nav-item nav-link">Forecast</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-controls="sidebarproduct">Manage Products</a>
                    <div class="dropdown-menu m-0">
                        <a href="product.php" class="dropdown-item dropdown-toggle" id="sidebarproduct">Products</a>
                        <a href="orders.php" class="dropdown-item">Orders</a>
                    </div>
                </div>
                <a href="selling.php" class="nav-item nav-link">Selling</a>
                <a href="sales.php" class="nav-item nav-link">Sales</a>
                <a href="#" class="nav-item nav-link">Reports</a>
                <a href="report.php" class="nav-item nav-link">Archive</a>
            </div>
        </div>
    </nav>
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