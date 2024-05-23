<?php
include("../conn.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location:../index.php");
    exit();
}

$uid = $_SESSION['user_id'];

$query = "
    SELECT DATE_FORMAT(sale_date, '%Y-%m') AS sale_month, SUM(quantity) AS total_sales
    FROM sales
    WHERE user_id = ?
    GROUP BY sale_month
    ORDER BY sale_month
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

$sales_data = [];
while ($row = $result->fetch_assoc()) {
    $sales_data[] = $row;
}

echo json_encode($sales_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing head content -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Existing body content -->

    <!-- Sales Trends Section -->
    <div class="container mt-5">
        <h2>Sales Trends</h2>
        <canvas id="salesChart" width="800" height="400"></canvas>
    </div>

    <!-- Footer and other existing content -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch sales data from the server
            fetch('get_sales_data.php')
                .then(response => response.json())
                .then(data => {
                    // Prepare the data for the chart
                    const labels = data.map(item => item.sale_month);
                    const salesData = data.map(item => item.total_sales);

                    // Create the sales trend chart
                    var ctx = document.getElementById('salesChart').getContext('2d');
                    var salesChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Sales Trend',
                                data: salesData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching sales data:', error);
                });
        });
    </script>

    <!-- Existing scripts -->
</body>
</html>
