<?php
$title = "Checkout";
include "config/connection.php";
include("component/header.php");

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch cart details for the logged-in user
$cart_query = "SELECT c.cart_id, p.*, c.cart_product_qty 
               FROM tbl_cart_masters c
               INNER JOIN tbl_product p ON c.cart_product_id = p.product_id
               WHERE c.customer_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total price
$total = 0;
foreach ($cartItems as $item) {
    $total += ($item['product_price'] - $item['product_dis_value']) * $item['cart_product_qty'];
}
?>

<div class="content-wrapper">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 bg-primary text-white">
        <h1 class="font-weight-bold mb-3">Checkout</h1>
        <p class="lead">Review your order and provide your details for delivery.</p>
    </section>

    <!-- Checkout Form Section -->
    <section class="checkout-form-section py-5">
        <div class="container">
            <div class="row">
                <!-- Order Summary -->
                <div class="col-md-6">
                    <h3 class="text-primary mb-4">Your Order</h3>
                    <ul class="list-group shadow p-2 mb-3">
                        <?php
                        if (!empty($cartItems)) {
                            foreach ($cartItems as $item) {
                                $itemTotal = ($item['product_price'] - $item['product_dis_value']) * $item['cart_product_qty'];
                        ?>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?= htmlspecialchars($item['product_name']) ?></h6>
                                        <small class="text-body-secondary">Quantity: <?= $item['cart_product_qty'] ?></small>
                                    </div>
                                    <span class="text-body-secondary">₹ <?= number_format($itemTotal, 2) ?></span>
                                </li>
                            <?php
                            }
                        } else {
                            echo "<li class='list-group-item d-flex justify-content-center lh-sm'>Your cart is empty</li>";
                        }
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total ( ₹ )</span>
                            <strong>₹ <?= number_format($total, 2) ?></strong>
                        </li>
                    </ul>
                </div>

                <!-- User Information and Payment -->
                <div class="col-md-6">
                    <h3 class="text-primary mb-4">Your Information</h3>
                    <form action="checkout-process.php" method="POST" class="card p-5 shadow">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Your Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Your Phone <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Your Email <span class="text-danger fw-bold">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email address">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Delivery Address <span class="text-danger fw-bold">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="5" required placeholder="Enter your delivery address..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-bold">Payment Method <span class="text-danger fw-bold">*</span></label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="1">Cash on Delivery</option>
                                <option value="2">Online Payment</option>
                            </select>
                        </div>
                        <!-- Hidden Field to Send Total Price -->
                        <input type="hidden" name="total_price" value="<?= $total ?>">
                        <button type="submit" class="btn btn-primary w-100">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>
