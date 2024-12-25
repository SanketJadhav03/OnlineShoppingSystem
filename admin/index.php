<?php
$title = "Admin Dashboard";
include "config/connection.php";
include("component/header.php");
include "component/sidebar.php";

// Fetch the counts from the database
$customer_query = "SELECT COUNT(*) AS customer_count FROM tbl_customer";
$customer_result = mysqli_query($conn, $customer_query);
$customer_count = mysqli_fetch_assoc($customer_result)['customer_count'];

$product_query = "SELECT COUNT(*) AS product_count FROM tbl_product";
$product_result = mysqli_query($conn, $product_query);
$product_count = mysqli_fetch_assoc($product_result)['product_count'];

$order_query = "SELECT COUNT(*) AS order_count FROM tbl_orders";
$order_result = mysqli_query($conn, $order_query);
$order_count = mysqli_fetch_assoc($order_result)['order_count'];

$category_query = "SELECT COUNT(*) AS category_count FROM tbl_category";
$category_result = mysqli_query($conn, $category_query);
$category_count = mysqli_fetch_assoc($category_result)['category_count'];

// Weekly Orders Data
$weekly_orders_query = "SELECT DAYNAME(order_date) AS day, COUNT(order_id) AS total_orders 
                        FROM tbl_orders 
                        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        GROUP BY DAYNAME(order_date)";
$weekly_orders_result = mysqli_query($conn, $weekly_orders_query);
$weekly_orders_data = [];
while ($row = mysqli_fetch_assoc($weekly_orders_result)) {
  $weekly_orders_data[$row['day']] = $row['total_orders'];
}

// Monthly Orders Data
$monthly_orders_query = "SELECT DATE_FORMAT(order_date, '%M') AS month, COUNT(order_id) AS total_orders 
                         FROM tbl_orders 
                         WHERE YEAR(order_date) = YEAR(CURDATE())
                         GROUP BY MONTH(order_date)";
$monthly_orders_result = mysqli_query($conn, $monthly_orders_query);
$monthly_orders_data = [];
while ($row = mysqli_fetch_assoc($monthly_orders_result)) {
  $monthly_orders_data[$row['month']] = $row['total_orders'];
}

// Customer Shopping Data
$customer_shopping_query = "SELECT c.customer_name, COUNT(o.order_id) AS total_orders 
                            FROM tbl_customer c 
                            LEFT JOIN tbl_orders o ON c.customer_id = o.customer_id 
                            GROUP BY c.customer_id";
$customer_shopping_result = mysqli_query($conn, $customer_shopping_query);
$customer_names = [];
$customer_orders = [];
while ($row = mysqli_fetch_assoc($customer_shopping_result)) {
  $customer_names[] = $row['customer_name'];
  $customer_orders[] = $row['total_orders'];
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-12 text-center">
          <h1 class="h1">Admin Dashboard</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info Boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "customer/" ?>" class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-friends"></i></a>
            <div class="info-box-content">
              <span class="info-box-text">Customers</span>
              <span class="info-box-number"><?= $customer_count ?></span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <a href="<?= $base_url . "product/" ?>" class="info-box-icon bg-info elevation-1"><i class="fas fa-box-open"></i></a>
            <div class="info-box-content">
              <span class="info-box-text">Products</span>
              <span class="info-box-number"><?= $product_count ?></span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "orders/" ?>" class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></a>
            <div class="info-box-content">
              <span class="info-box-text">Orders</span>
              <span class="info-box-number"><?= $order_count ?></span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "category/" ?>" class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></a>
            <div class="info-box-content">
              <span class="info-box-text">Categories</span>
              <span class="info-box-number"><?= $category_count ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="row">
        <div class="col-md-6 col-12">
          <!-- Weekly Orders Bar Chart -->
        <div class="col-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Weekly Orders</h3>
            </div>
            <div class="card-body">
              <canvas id="weeklyOrdersChart" height="100"></canvas>
            </div>
          </div>
        </div>
        <!-- Monthly Orders Line Chart -->
        <div class="col-12 col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Monthly Orders</h3>
            </div>
            <div class="card-body">
              <canvas id="monthlyOrdersChart" height="100"></canvas>
            </div>
          </div>
        </div>
        </div>
        <!-- Customer Shopping Pie Chart -->
        <div class="col-12 col-md-6">
          <div class="card ">
            <div class="card-header">
              <h3 class="card-title">Customer Shopping Distribution</h3>
            </div>
            <div class="card-body">
              <canvas id="customerShoppingChart" height="100"></canvas>
            </div>
          </div>
        </div>


      </div>

    </div>
  </section>
</div>

<!-- Footer -->
<?php include "component/footer.php"; ?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Weekly Orders Chart Script -->
<script>
  const weeklyOrdersData = <?= json_encode($weekly_orders_data); ?>;
  const weeklyDays = Object.keys(weeklyOrdersData);
  const weeklyOrders = Object.values(weeklyOrdersData);

  const weeklyCtx = document.getElementById('weeklyOrdersChart').getContext('2d');
  new Chart(weeklyCtx, {
    type: 'bar',
    data: {
      labels: weeklyDays,
      datasets: [{
        label: 'Orders',
        data: weeklyOrders,
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true
    }
  });
</script>

<!-- Customer Shopping Pie Chart Script -->
<script>
  const customerNames = <?= json_encode($customer_names); ?>;
  const customerOrders = <?= json_encode($customer_orders); ?>;

  const customerCtx = document.getElementById('customerShoppingChart').getContext('2d');
  new Chart(customerCtx, {
    type: 'pie',
    data: {
      labels: customerNames,
      datasets: [{
        data: customerOrders,
        backgroundColor: [
          'rgba(255, 99, 132, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(255, 206, 86, 0.6)',
          'rgba(75, 192, 192, 0.6)',
          'rgba(153, 102, 255, 0.6)',
          'rgba(255, 159, 64, 0.6)',
        ]
      }]
    },
    options: {
      responsive: true
    }
  });
</script>

<!-- Monthly Orders Line Chart Script -->
<script>
  const monthlyOrdersData = <?= json_encode($monthly_orders_data); ?>;
  const monthlyLabels = Object.keys(monthlyOrdersData);
  const monthlyOrders = Object.values(monthlyOrdersData);

  const monthlyCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
  new Chart(monthlyCtx, {
    type: 'line',
    data: {
      labels: monthlyLabels,
      datasets: [{
        label: 'Orders',
        data: monthlyOrders,
        borderColor: 'rgba(255, 99, 132, 1)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderWidth: 2,
        fill: true
      }]
    },
    options: {
      responsive: true
    }
  });
</script>