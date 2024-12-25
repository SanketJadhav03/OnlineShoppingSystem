
<?php
// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    $cartItems = []; // Empty cart for guests
} else {
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
}
?>
<li class="nav-item mt-2 position-relative">
    <a href="#" class="nav-link  mx-1 d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
        <svg width="24" height="24" class="shopping-bag-icon">
            <use xlink:href="#shopping-bag"></use>
        </svg>
    </a>
    <!-- Notification Badge -->
    <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-2">
    <?= count($cartItems) ?>
        <span class="visually-hidden">Unread cart items</span>
    </span>
</li>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your Cart</span>
                <span class="badge bg-primary rounded-pill"><span> <i class="fas fa-shopping-cart"></i>
                    </span><?= count($cartItems) ?></span>
            </h4>
            <ul class="list-group shadow p-2 mb-3">
                <?php
                $total = 0;
                if (!empty($cartItems)) {
                    foreach ($cartItems as $item) {
                        $total += ($item['product_price'] - $item['product_dis_value']) * $item['cart_product_qty'];
                ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <a class="nav-link" href="products-view.php?product_id=<?= $item['product_id'] ?>">
                                    <h6 class="my-0"><?= htmlspecialchars($item['product_name']) ?></h6>
                                </a>
                                <small class="text-body-secondary">Quantity: <?= $item['cart_product_qty'] ?></small>
                            </div>
                            <span class="text-body-secondary">
                                ₹ <?= number_format(($item['product_price'] - $item['product_dis_value']) * $item['cart_product_qty'], 2) ?>
                                <a href="remove_from_cart.php?product_id=<?=$item['product_id']?>" class="btn btn-sm fw-bold"> <i class="fas fa-trash text-danger "></i></a>
                            </span>
                        </li>
                    <?php
                    }
                } else {
                    ?>
                    <li class="list-group-item d-flex justify-content-center lh-sm">
                        <div>
                            <h6 class="my-0 text-muted">Your cart is empty</h6>
                        </div>
                    </li>
                <?php } ?>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total ( ₹ )</span>
                    <strong>₹ <?= number_format($total, 2) ?></strong>
                </li>
            </ul>

            <?php if (!empty($cartItems)) { ?>
                <a href="checkout.php" class="w-100 btn btn-primary btn-lg">Continue to checkout</a>
            <?php } else { ?>
                <button class="w-100 btn btn-secondary btn-lg" disabled>Checkout</button>
            <?php } ?>
        </div>
    </div>
</div>