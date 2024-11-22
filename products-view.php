<?php
// Set the page title
$title = "Product View";

// Include the database connection file
include("config/connection.php");

// Include the header file
include("component/header.php");

// Assuming you are getting the product ID from the URL (e.g., view.php?id=1)
$product_id = $_GET['product_id'];

// Fetch product details from the database
$query = "SELECT * FROM tbl_product WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();

if (!$product) {
    // If no product found, redirect to the homepage or show an error message
    header('Location: index.php');
    exit;
}
?>

<div class="container">
    <div class="row mt-4">
        <div class="col-md-6">
            <figure>
                <img src="admin/uploads/products/<?= htmlspecialchars($product['product_image'] == "" ? "no_img.png" : $product['product_image']) ?>" alt="<?= htmlspecialchars($similar_product['product_image']) ?>" alt="<?= $similar_product['product_name']; ?>" class="img-fluid">
            </figure>
        </div>
        <div class="col-md-6">
            <h1 class="product-title"><?= $product['product_name']; ?></h1>
            <p class="product-description"><?= $product['product_description']; ?></p>

            <div class="product-price">
                <del>$<?= number_format($product['product_price'], 2); ?></del>
                <span class="text-dark fw-semibold">$<?= number_format($product['product_price'] - $product['product_dis_value'], 2); ?></span>
                <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary"><?= $product['product_dis'] ?>% OFF</span>
            </div>


            <div class="product-quantity">
                <input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1">
            </div>

            <div class="button-area mt-3">
                <a href="cart.php?product_id=<?= $product['product_id']; ?>&quantity=1" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                    <svg width="18" height="18">
                        <use xlink:href="#cart"></use>
                    </svg> Add to Cart
                </a>
                <a href="wishlist.php?product_id=<?= $product['product_id']; ?>" class="btn btn-outline-dark rounded-1 p-2 fs-6">
                    <svg width="18" height="18">
                        <use xlink:href="#heart"></use>
                    </svg> Add to Wishlist
                </a>
            </div>
        </div>
    </div>
</div>


<section id="latest-products" class="products-carousel">
    <div class="container-lg overflow-hidden ">
        <div class="row">
            <div class="col-md-12">

                <div class="section-header d-flex justify-content-between my-4">

                    <h2 class="section-title">Similar Products</h2>

                    <div class="d-flex align-items-center">
                        <a href="products.php" class="btn btn-primary mx-3 ">View All</a>
                        <div class="swiper-buttons">
                            <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                            <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row  ">
            <div class="col-md-12">

                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php
                        // Example: Fetch similar products based on the same category
                        $category_id = $product['category_id'];
                        $similar_query = "SELECT * FROM tbl_product WHERE category_id = ? AND product_id != ?";
                        $stmt = $conn->prepare($similar_query);
                        $stmt->bind_param('ii', $category_id, $product_id);
                        $stmt->execute();
                        $similar_result = $stmt->get_result();

                        while ($similar_product = $similar_result->fetch_assoc()) {
                        ?>
                            <div class="product-item swiper-slide">
                                <figure>
                                    <a href="products-view.php?product_id=<?= $similar_product['product_id']; ?>" title="<?= $similar_product['product_name']; ?>">
                                        <img src="admin/uploads/products/<?= htmlspecialchars($similar_product['product_image'] == "" ? "no_img.png" : $similar_product['product_image']) ?>" alt="<?= htmlspecialchars($similar_product['product_image']) ?>" alt="<?= $similar_product['product_name']; ?>" class="img-fluid">
                                    </a>
                                </figure>
                                <h4 class="fs-6"><?= $similar_product['product_name']; ?></h4>
                                <dic class="d-flex justify-content-between">
                                <div class="product-price">
                                    <span>&#8377;
                                        <?= number_format($similar_product["product_price"] - $similar_product['product_dis_value'], 2); ?></span>
                                </div>
                                <div>
                                    <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary"><?= $product['product_dis'] ?>% OFF</span>

                                </div>
                                </dic>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include the footer file
include("component/footer.php");
?>