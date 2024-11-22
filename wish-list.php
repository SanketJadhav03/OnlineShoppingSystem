<li>
    <a href="#" class="mt-1 mx-1 nav-link " data-bs-toggle="offcanvas" data-bs-target="#offcanvasWish" aria-controls="offcanvasWish">
        <svg width="24" height="24">
            <use xlink:href="#wishlist"></use>
        </svg>
    </a>
</li>

<?php
// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    $wishlistItems = []; // Empty wishlist for guests
} else {
    $customer_id = $_SESSION['customer_id'];

    // Fetch wishlist details for the logged-in user
    $wishlist_query = "SELECT w.wishlist_id, p.* 
                       FROM tbl_wishlist_masters w
                       INNER JOIN tbl_product p ON w.wishlist_product_id = p.product_id
                       WHERE w.customer_id = ? AND w.wishlist_status = 'active'";
    $stmt = $conn->prepare($wishlist_query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $wishlistItems = $result->fetch_all(MYSQLI_ASSOC);
}

// Calculate the total wishlist price
$totalPrice = 0;
foreach ($wishlistItems as $item) {
    $totalPrice += ($item['product_price'] - $item['product_dis_value']);
}
?>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWish">
    <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary"> Wishlist</span>
                <span class="badge bg-primary rounded-pill"> <span style="font-size: 25px;">&hearts;</span> <?= count($wishlistItems) ?></span>
            </h4>
            <ul class="list-group shadow p-2 mb-3">
                <?php
                if (!empty($wishlistItems)) {
                    foreach ($wishlistItems as $item) {
                        echo '<li class="list-group-item d-flex justify-content-between lh-sm">';
                        echo '<div>';
                ?>
                        <a class="nav-link" href="products-view.php?product_id=<?= $item['product_id'] ?>">
                            <h6 class="my-0"><?= htmlspecialchars($item['product_name']) ?></h6>
                        </a>
                        <small class="text-body-secondary">
                            <?= htmlspecialchars(strlen($item['product_description']) > 15 ? substr($item['product_description'], 0, 15) . '...' : $item['product_description']) ?>
                        </small>
                <?php
                        echo '</div>';

                        // Remove from wishlist button

                        echo '<span class="text-body-secondary">₹' . number_format($item['product_price'] - $item['product_dis_value'], 2) . '<a href="remove_from_wishlist.php?wishlist_id=' . $item['wishlist_id'] . '" class="btn btn-sm fw-bold">    <i class="fas fa-trash text-danger "></i></a>' . '</span>';
                        echo '</li>';
                    }
                } else {
                    echo '<li class="list-group-item d-flex justify-content-center fw-bold text-center lh-sm"><div>No items in wishlist.</div></li>';
                }
                ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total ( ₹ )</span>
                    <strong> ₹ <?= number_format($totalPrice, 2) ?></strong>
                </li>
            </ul>

            <a href="products.php" class="w-100 btn btn-primary btn-lg">Continue Shopping</a>
        </div>
    </div>
</div>