<?php
include "config/connection.php";
include "component/header.php"; 

// Fetch categories from the database
$selectQuery = "SELECT * FROM `tbl_category` WHERE `category_status` = 1 ORDER BY `created_at` DESC"; 
$result = mysqli_query($conn, $selectQuery);
?>

<div class="content-wrapper p-4">
    <div class="card border-0 text-center p-4">
        <h3 class="font-weight-bold text-primary">All Categories</h3>
        <p class="text-muted">Explore various product categories available</p>
    </div>
    <div class="card-body">
        <div class="row">
            <?php while ($category = mysqli_fetch_array($result)) { ?>
                <div class="col-md-4 mb-4">
                    <div class="category-item card border-0 shadow-sm p-3 rounded-lg hover-zoom">
                        <div class="image-holder position-relative overflow-hidden rounded-lg">
                            <a href="products.php?category_id=<?= $category['category_id'] ?>">
                                <img src="admin/uploads/categories/<?= $category['category_image'] == null ? 'no_img.png' : $category['category_image'] ?>" 
                                     alt="<?= htmlspecialchars($category['category_name']) ?>" 
                                     class="card-img-top w-100">
                            </a>
                        </div>
                        <div class="card-body p-4 text-center">
                            <h4 class="category-title">
                                <a href="products.php?category_id=<?= $category['category_id'] ?>" 
                                   class="text-decoration-none text-dark fw-bold"><?= htmlspecialchars($category['category_name']) ?></a>
                            </h4>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
include "component/footer.php";
?>
