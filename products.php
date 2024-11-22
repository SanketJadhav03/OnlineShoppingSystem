<?php
$title = "Products Page";
include "config/connection.php";
include "component/header.php";

// Fetch category ID from query string
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Fetch products grouped by category when no specific category ID is provided
if ($categoryId === null) {
    $productQuery = "
        SELECT p.*, c.category_name 
        FROM tbl_product p 
        LEFT JOIN tbl_category c ON p.category_id = c.category_id 
        ORDER BY c.category_name ASC, p.created_at DESC";
} else {
    // Fetch products for a specific category
    $productQuery = "
        SELECT p.*, c.category_name 
        FROM tbl_product p 
        LEFT JOIN tbl_category c ON p.category_id = c.category_id 
        WHERE p.category_id = $categoryId 
        ORDER BY p.created_at DESC";
}

// Execute the query
$productResult = mysqli_query($conn, $productQuery);

// Prepare products grouped by category
$productsByCategory = [];
while ($product = mysqli_fetch_assoc($productResult)) {
    $categoryName = $product['category_name'] ?: "Uncategorized";
    $productsByCategory[$categoryName][] = $product;
}
?>

<div class="content-wrapper">
    <div class="card border-0">
        <div class="card-header pt-4 text-center pb-4">
            <h3 class="font-weight-bold text-primary">
                <?= $categoryId ? htmlspecialchars($productsByCategory[array_key_first($productsByCategory)][0]['category_name']) : "All Products" ?>
            </h3>
            <p class="text-muted">
                <?= $categoryId ? "Browse products under the \"" . htmlspecialchars($productsByCategory[array_key_first($productsByCategory)][0]['category_name']) . "\" category." : "Explore our complete product range." ?>
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 px-3"> 
                    <?php if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['message']); ?> 
                    <?php } elseif (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php } ?>
                </div>
            </div>

            <?php if (!empty($productsByCategory)) { ?>
                <?php foreach ($productsByCategory as $categoryName => $products) { ?>
                    <div class="mb-4">
                        <div class="category-heading text-center py-3 mb-4" style="
    background: linear-gradient(45deg, #e0f2ff, #d9e4ff);
    color: #333;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
">
                            <h4 class="m-0 fw-bold">
                                <i class="bi bi-tags-fill me-2"></i>
                                <?= htmlspecialchars($categoryName) ?>
                            </h4>
                        </div>

                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                            <?php foreach ($products as $product) { ?>
                                <div class="col">
                                    <div class="product-item card shadow-sm border-0 rounded-lg overflow-hidden">
                                        <figure class="position-relative m-0">
                                            <a href="products-view.php?product_id=<?= $product['product_id'] ?>">
                                                <img src="admin/uploads/products/<?= $product['product_image'] == null ? 'no_img.png' : $product['product_image'] ?>"
                                                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                    class="w-100" style="height: 210px; object-fit: cover;">
                                            </a>
                                            <?php if ($product['product_dis'] && $product['product_dis_value'] > 0) { ?>
                                                <span class="position-absolute top-0 end-0 badge bg-success text-white px-3 py-1 rounded-start">
                                                    <?= $product['product_dis'] ?>% OFF
                                                </span>
                                            <?php } ?>
                                        </figure>
                                        <div class="card-body text-center p-3">
                                            <h5 class="fs-6 fw-bold mb-2 text-truncate">
                                                <a href="products-view.php?product_id=<?= $product['product_id'] ?>"
                                                    class="text-dark text-decoration-none"><?= htmlspecialchars($product['product_name']) ?></a>
                                            </h5>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <?php if ($product['product_dis_value'] > 0) { ?>
                                                    <del class="text-muted">₹<?= number_format($product['product_price'], 2) ?></del>
                                                <?php } ?>
                                                <span class="text-dark fw-semibold">
                                                    ₹<?= number_format($product['product_price'] - $product['product_dis_value'], 2) ?>
                                                </span>
                                            </div>
                                            <div class="meta-stock mt-2 <?= $product['product_stock'] > 0 ? 'text-success' : 'text-danger' ?> fw-bold">
                                                <?= $product['product_stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                                            </div>
                                            <div class="row g-1 mt-2">
                                                <div class="col-8">
                                                    <a href="add_to_cart.php?product_id=<?= $product['product_id'] ?>" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#cart"></use>
                                                        </svg> Add to Cart
                                                    </a>
                                                </div>
                                                <div class="col-4">
                                                    <a href="add_wish_list.php?product_id=<?= $product['product_id'] ?>" class="btn btn-outline-dark rounded-1 fs-6">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#heart"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-info text-center">No products found.</div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include "component/footer.php"; ?>