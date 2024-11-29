<?php
include "config/connection.php";
include("component/header.php");

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Get the order_id from the URL
if (isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

    // Fetch order details
    $order_query = "SELECT * FROM tbl_orders WHERE order_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param("ii", $order_id, $customer_id);
    $stmt->execute();
    $order_result = $stmt->get_result();

    if ($order_result->num_rows > 0) {
        // Order found
        $order = $order_result->fetch_assoc();
        $order_date = date("d/m/Y", strtotime($order['order_date']));
        $total_price = number_format($order['total_price'], 2);
        $payment_status = $order['payment_status'];
        $order_status = $order['order_status']; // e.g., 1 = Pending, 2 = Out For Delivery, 3 = Delivered
    } else {
        $error_message = "No order found with that ID.";
    }
} else {
    $error_message = "Please provide a valid Order ID.";
}

?>

<div class="content-wrapper">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 bg-primary text-white">
        <h1 class="font-weight-bold mb-3">Track Your Order</h1>
        <p class="lead">Order ID: <?= isset($order_id) ? $order_id : 'Not Found' ?></p>
    </section>

    <!-- Order Tracking Section -->
    <section class="order-track-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger'>$error_message</div>";
                    }

                    if (isset($order)) {
                    ?>
                        <div class="order-card p-4 border shadow-sm">
                            <h5>Order ID: <?= $order_id ?></h5>
                            <p><strong>Date:</strong> <?= $order_date ?></p>
                            <p><strong>Total Price:</strong> ₹<?= $total_price ?></p>
                            <p><strong>Payment Status:</strong> <?= ucfirst($payment_status) ?></p>

                            <!-- Display Order Status as a Map -->
                            <h6>Order Status:</h6>
                            <div class="order-status-map">
                                <ul class="list-unstyled p-3  border   d-flex justify-content-evenly w-50">
                                    <li class="status-step <?php echo ($order_status == 1) ? 'active' : ''; ?>">
                                        <i class="bi bi-hourglass-split"></i>
                                        <span>Pending</span>
                                    </li>
                                    <li class="status-step <?php echo ($order_status == 2) ? 'active' : ''; ?>">
                                        <i class="bi bi-truck"></i>
                                        <span>Out for Delivery</span>
                                    </li>
                                    <li class="status-step   <?php echo ($order_status == 3) ? 'active' : ''; ?>">
                                        <i class="bi bi-check-circle   "></i>
                                        <span>Delivered</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Order Items -->
                            <h6>Order Items:</h6>
                            <ul class="list-group">
                                <?php
                                $item_query = "SELECT oi.*, p.product_name, p.product_price 
                                               FROM tbl_order_items oi
                                               JOIN tbl_product p ON oi.product_id = p.product_id
                                               WHERE oi.order_id = ?";
                                $item_stmt = $conn->prepare($item_query);
                                $item_stmt->bind_param("i", $order_id);
                                $item_stmt->execute();
                                $item_result = $item_stmt->get_result();

                                while ($item = $item_result->fetch_assoc()) {
                                    $product_name = htmlspecialchars($item['product_name']);
                                    $quantity = $item['quantity'];
                                    $price = number_format($item['price'], 2);
                                    $total_item_price = number_format($item['quantity'] * $item['price'], 2);
                                    echo "<li class='list-group-item d-flex justify-content-between'>
                                              <span>$product_name (x$quantity)</span>
                                              <span>₹$total_item_price</span>
                                          </li>";
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>

<!-- Add Bootstrap Icons for the status steps -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .order-status-map {
        margin: 20px 0;
        display: flex;
        justify-content: space-between;
    }

    .status-step {
        text-align: center;
        font-size: 18px;
    }

    .status-step span {
        display: block;
        margin-top: 5px;
    }

    .status-step i {
        font-size: 30px;
        color: #ddd;
    }

    .status-step.active i {
        color: #007bff;
    }

    .status-step.active span {
        font-weight: bold;
    }
</style>