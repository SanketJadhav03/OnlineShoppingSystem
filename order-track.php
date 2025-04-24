<?php
include "config/connection.php";
include("component/header.php");

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$customer_id = $_SESSION['customer_id'];
$error_message = null;
$order = null;

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
        $payment_method = $order['payment_method'];
        $payment_status = $order['payment_status'];
        $order_status = (int)$order['order_status']; // Ensure it is an integer
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
        <p class="lead">Order ID: <?= isset($order_id) ? htmlspecialchars($order_id) : 'Not Found' ?></p>
        <a href="order-history.php" class="btn btn-light mt-3"> <i class="fas fa-home "></i> Back to Home</a>
    </section>

    <!-- Order Tracking Section -->
    <section class="order-track-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($error_message) {
                        echo "<div class='alert alert-danger'>$error_message</div>";
                    }
                    $current_month_number = date('n');

                    if ($order) {
                    ?>
                        <div class="order-card p-4 border shadow-sm">
                            <h5>Order ID: <?= htmlspecialchars($order_id) ?></h5>
                            <p><strong>Date:</strong> <?= $order_date ?></p>
                            <p><strong>Total Price:</strong> ₹<?= $total_price ?></p>
                            <p><strong>Payment Method:</strong> <?= ucfirst($payment_method) == 1 ? "Cash On delivery" : "Online" ?></p>
                            <p><strong>Payment Status:</strong> <?= ucfirst($payment_status) == 0 ? "<span class='text-success fw-bold'>Paid</span>" : "<span class='text-danger fw-bold'>Unpaid</span>" ?></p>

                            <!-- Display Order Status as a Map -->
                            <h6>Order Status:</h6>
                            <div class="order-status-map">
                                <ul class="list-unstyled d-flex justify-content-around">
                                    <li class="status-step <?= $order_status == 1 ? 'active' : ''; ?>">
                                        <i class="bi bi-hourglass-split"></i>
                                        <span>Pending</span>
                                    </li>
                                    <li class="status-step <?= $order_status == 2 ? 'active' : ''; ?>">
                                        <i class="bi bi-truck"></i>
                                        <span>Out for Delivery</span>
                                    </li>
                                    <li class="status-step <?= $order_status == 3 ? 'active' : ''; ?>">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Delivered</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Order Items -->
                            <h6>Order Items:</h6>
                            <ul class="list-group mb-3">
                                <?php
                                $grand_total = 0;
                                $item_query = "SELECT oi.*, p.*, 
                   (SELECT rating FROM tbl_ratings WHERE product_id = oi.product_id AND order_id = oi.order_id AND customer_id = ?) AS user_rating,
                   (SELECT description FROM tbl_ratings WHERE product_id = oi.product_id AND order_id = oi.order_id AND customer_id = ?) AS user_description
                   FROM tbl_order_items oi
                   JOIN tbl_product p ON oi.product_id = p.product_id
                   WHERE oi.order_id = ?";
                                $item_stmt = $conn->prepare($item_query);
                                $item_stmt->bind_param("iii", $customer_id, $customer_id, $order_id);
                                $item_stmt->execute();
                                $item_result = $item_stmt->get_result();

                                while ($item = $item_result->fetch_assoc()) {
                                    $product_name = htmlspecialchars($item['product_name']);
                                    $quantity = $item['quantity'];
                                    $price = number_format($item['product_price'] - $item['product_dis_value'], 2);
                                    $total_item_price = number_format($item['quantity'] * ($item['product_price'] - $item['product_dis_value']), 2);
                                    $grand_total += ($item['quantity'] * ($item['product_price'] - $item['product_dis_value']));
                                    $user_rating = $item['user_rating'] ?? 0;
                                    $user_description = htmlspecialchars($item['user_description'] ?? 'No description provided.');
                                ?>
                                    <li class="list-group-item">
                                        <div class="row d-flex justify-content-between align-items-center">
                                            <div class="col-6">
                                                <strong><?= $product_name ?> (x<?= $quantity ?>)</strong>
                                                <p>₹<?= $total_item_price ?></p>
                                                <p><em><?= $user_description ?></em></p>
                                            </div>
                                            <div class="col-6">
                                                <!-- Rating Section -->
                                                <form class="rating-form" data-product-id="<?= $item['product_id'] ?>" data-order-id="<?= $order_id ?>">
                                                    <div class="rating-stars">
                                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                            <i class="bi <?= $i <= $user_rating ? 'bi-star-fill text-warning' : 'bi-star'; ?>" data-rating="<?= $i ?>"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <textarea class="form-control mt-2" name="description" placeholder="Write your review here..."><?= htmlspecialchars($item['user_description'] ?? '') ?></textarea>
                                                    <input type="hidden" name="rating" value="<?= $user_rating ?>">

                                                    <button type="button" class="btn btn-primary btn-sm mt-2 save-rating">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>

                                <?php } ?>
                            </ul>

                            <div class="d-flex justify-content-center align-items-center">
                                <h5 class="text-right"><strong>Grand Total:</strong> ₹<?= number_format($grand_total, 2) ?></h5>
                            </div>

                            <!-- Rate Order Button -->
                            <!-- Print Receipt Button -->

                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-info mt-3" onclick="printReceipt()"> <i class="fas fa-print"></i> Print Receipt</button>
                </div>

                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn- btn-success mt-3"> <i class="fas fa-home "></i> Back to Home</a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add Bootstrap Icons for the status steps -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script>
    function printReceipt() {
        const printContent = document.querySelector('.order-card').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = `<div class="order-card">${printContent}</div>`;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // Reload the page to restore the original content
    }
</script>

<style>
    .order-status-map ul {
        display: flex;
        justify-content: space-between;
        padding: 0;
    }

    .status-step {
        text-align: center;
        font-size: 18px;
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.rating-stars i').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                const stars = this.parentElement.querySelectorAll('i');
                stars.forEach((s, index) => {
                    s.classList.toggle('bi-star-fill', index < rating);
                    s.classList.toggle('bi-star', index >= rating);
                });
                this.closest('.rating-form').querySelector('input[name="rating"]').value = rating;
            });
        });

        document.querySelectorAll('.save-rating').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.rating-form');
                const productId = form.getAttribute('data-product-id');
                const orderId = form.getAttribute('data-order-id');
                const rating = form.querySelector('input[name="rating"]').value;
                const description = form.querySelector('textarea[name="description"]').value;

                fetch('save-rating.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `product_id=${productId}&order_id=${orderId}&rating=${rating}&description=${encodeURIComponent(description)}`
                    }).then(response => response.text())
                    .then(data => alert(data))
                    .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

<?php include("component/footer.php"); ?>