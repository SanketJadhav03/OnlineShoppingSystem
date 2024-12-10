<?php
$title = "Order Confirmation";
include("config/connection.php");
include("component/header.php");
 
// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$order_id = $_GET['order_id']; // Order ID passed via URL

// Fetch order details
$order_query = "SELECT * FROM tbl_orders WHERE order_id = ? AND customer_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
    $order_status = $order['order_status'];
    $total_amount = $order['total_price'];
    $shipping_address = $order['shipping_address'];
    $payment_method = $order['payment_method'];
    $payment_status = $order['payment_status'];
    $order_date = $order['order_date'];
} else {
    // If the order doesn't exist or the user doesn't have access, redirect to the home page
    header("Location: index.php");
    exit();
}

// Fetch order items
$order_items_query = "SELECT oi.*, p.* FROM tbl_order_items oi
                      JOIN tbl_product p ON oi.product_id = p.product_id
                      WHERE oi.order_id = ?";
$order_items_stmt = $conn->prepare($order_items_query);
$order_items_stmt->bind_param("i", $order_id);
$order_items_stmt->execute();
$order_items_result = $order_items_stmt->get_result();
?>

<div class="content-wrapper">
<section class="hero-section text-center py-5 bg-primary text-white">
        <h1 class="fw-bold mb-3">Order Confirmation</h1>
        <p class="lead">View your past orders and track their status.</p>
    </section>
    <section class="order-confirmation py-5">
        <div class="container">
            <div class="row"> 

                <!-- Order Summary -->
                <div class="col-md-6">
                    <h4>Order Summary</h4>
                    <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
                    <p><strong>Status:</strong> <?= ucfirst($order_status) ?></p>
                    <p><strong>Order Date:</strong> <?= date("d/m/Y", strtotime($order_date)) ?></p>
                    <p><strong>Total Amount:</strong> ₹ <?= number_format($total_amount, 2) ?></p>
                    <p class=""><strong>Payment Method:</strong> <?= ucfirst($payment_method) == 1 ?"Cash On Delivery":"Online" ?></p>
                    <p><strong>Payment Status:</strong> <?= ucfirst($payment_status) == 1 ?"Pending":"Completed" ?></p>
                </div>

                <!-- Shipping Address -->
                <div class="col-md-6">
                    <h4>Shipping Address</h4>
                    <p><?= htmlspecialchars($shipping_address) ?></p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Items Ordered</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($item = $order_items_result->fetch_assoc()) {
                                $total_item_price = ($item['product_price'] - $item['product_dis']) * $item['quantity'];
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>₹ <?= number_format($item['product_price'] - $item['product_dis'], 2) ?></td>
                                    <td>₹ <?= number_format($total_item_price, 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">Go to Home</a>
            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>
