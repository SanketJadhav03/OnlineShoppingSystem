<?php
$title = "Online Shop";
include "config/connection.php";
include("component/header.php");
?>

<section style="background-image: url('<?= $base_url ?>assets/images/banner-1.png');background-repeat: no-repeat;background-size: cover;">
  <div class="container-lg">
    <div class="row">
      <div class="col-lg-6 pt-5 mt-5">
        <h2 class="display-1 ls-1"><span class="fw-bold text-primary">Streamline Shop </span> <span class="fw-bold">Elevate Experience.</span></h2>
        <p class="fs-4"> " Where Shopping Meets Simplicity "</p>
        <div class="d-flex gap-3   pb-5">
          <a href="products.php" class="mt-5 btn btn-primary  fs-6 rounded-pill px-4 py-3 mt-3"><i class="fas fa-shopping-cart"></i> &nbsp;Start Shopping
          </a>

        </div>

      </div>
    </div>

    <div class="row p-4 row-cols-1 row-cols-sm-3 row-cols-lg-3 g-4 justify-content-center">
      <div class="col">
        <div class="card shadow h-100 text-center" style="background-color: rgba(255, 255, 255, 0.8); border: none;">
          <div class="card-body p-5">
            <h5 class="card-title fw-bold">Fast Delivery</h5>
            <p class="card-text">Get your orders delivered quickly with our optimized shipping system.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow h-100 text-center" style="background-color: rgba(255, 255, 255, 0.8); border: none;">
          <div class="card-body p-5">
            <h5 class="card-title fw-bold">Secure Payments</h5>
            <p class="card-text">Shop confidently with our highly secure payment gateway.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow h-100 text-center" style="background-color: rgba(255, 255, 255, 0.8); border: none;">
          <div class="card-body p-5">
            <h5 class="card-title fw-bold">Top Quality Products</h5>
            <p class="card-text">Browse through our collection of the finest quality items for all your needs.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<section class="py-5 overflow-hidden">
  <div class="container-lg">
    <div class="row">
      <div class="col-md-12">
        <div class="section-header d-flex flex-wrap justify-content-between mb-5">
          <h2 class="section-title">Category</h2>
          <div class="d-flex align-items-center">
            <a href="#" class="btn btn-primary me-2">View All</a>
            <div class="swiper-buttons">
              <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
              <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="category-carousel swiper">
          <div class="swiper-wrapper">
            <?php

            $query = "SELECT * FROM tbl_category";
            $result = mysqli_query($conn, $query);

            // Check if there are categories to display
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                // Assign variables for easy access
                $category_id = $row['category_id'];
                $category_name = $row['category_name'];
                $category_image = $row['category_image'];
            ?>
                <a href="products.php?category_id=<?= $category_id ?>" class="nav-link swiper-slide text-center">
                  <img height="170" width="170" src="<?= $base_url ?>admin/uploads/categories/<?= $category_image == "" ? "no_img.png" : $category_image  ?>" class="rounded-circle" alt="<?= $category_name ?> Thumbnail">
                  <h4 class="fs-6 mt-3 fw-normal category-title"><?= htmlspecialchars($category_name) ?></h4>
                </a>
            <?php
              }
            } else {
              echo "<p>No categories available</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="latest-products" class="products-carousel">
  <div class="container-lg overflow-hidden pb-5">
    <div class="row">
      <div class="col-md-12">

        <div class="section-header d-flex justify-content-between my-4">

          <h2 class="section-title">Just arrived</h2>

          <div class="d-flex align-items-center">
            <a href="products.php" class="btn btn-primary me-2">View All</a>
            <div class="swiper-buttons">
              <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
              <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">

        <div class="swiper">
          <div class="swiper-wrapper">
            <?php
            // Fetch product details along with average rating from tbl_ratings
            $sql = "
            SELECT 
                p.product_id, 
                p.product_name, 
                p.product_image, 
                p.product_price, 
                p.product_dis_value, 
                p.product_dis, 
                IFNULL(AVG(r.rating), 0) AS avg_rating 
            FROM 
                tbl_product p
            LEFT JOIN 
                tbl_ratings r 
            ON 
                p.product_id = r.product_id
            GROUP BY 
                p.product_id
            ORDER BY 
                p.created_at DESC 
            LIMIT 10";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()):
              // Calculate the number of filled and empty stars based on avg_rating
              $avg_rating = round($row['avg_rating']); // Rounded to the nearest whole number
              $filledStars = $avg_rating;
              $emptyStars = 5 - $filledStars;
            ?>
              <div class="product-item swiper-slide">
                <figure>
                  <a href="products-view.php?product_id=<?= $row['product_id'] ?>" title="<?= htmlspecialchars($row['product_name']) ?>">
                    <img style="height: 210px;" width="210" src="admin/uploads/products/<?= htmlspecialchars($row['product_image'] == "" ? "no_img.png" : $row['product_image']) ?>" alt="<?= htmlspecialchars($row['product_image']) ?>" class="tab-image">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal"><?= htmlspecialchars($row['product_name']) ?></h3>

                  <!-- Star Rating Section -->
                  <div class="d-flex justify-content-center align-items-center mb-2">
                    <?php for ($i = 0; $i < $filledStars; $i++): ?>
                      <i class="bi bi-star-fill text-warning"></i> <!-- Filled star -->
                    <?php endfor; ?>
                    <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                      <i class="bi bi-star text-muted"></i> <!-- Empty star -->
                    <?php endfor; ?>
                  </div>

                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <?php if ($row['product_price'] > 20): ?>
                      <del>&#8377;
                        <?= number_format($row['product_price'], 2) ?></del>
                    <?php endif; ?>
                    <span class="text-dark fw-semibold"> &#8377;
                      <?= number_format($row['product_price'] - $row['product_dis_value'], 2) ?></span>
                    <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary"><?= number_format($row['product_dis']) ?>% OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-8">
                        <a href="add_to_cart.php?product_id=<?= $row['product_id'] ?>" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart">
                          <svg width="18" height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart
                        </a>
                      </div>
                      <div class="col-4">
                        <a href="add_wish_list.php?product_id=<?= $row['product_id'] ?>" class="btn btn-outline-dark rounded-1 p-2 fs-6">
                          <svg width="18" height="18">
                            <use xlink:href="#heart"></use>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>


        <!-- / products-carousel -->

      </div>
    </div>
  </div>
</section>


<section class="py-3">
  <div class="container-lg">
    <?php
    // Fetch active offers from the database, ordered by creation date, limited to 6 offers
    $sql = "SELECT * FROM tbl_offer INNER JOIN tbl_category ON tbl_category.category_id = tbl_offer.offer_category WHERE offer_status = 1 LIMIT 6"; // Fetch only active offers
    $stmt = $conn->query($sql);
    $offers = $stmt->fetch_all(MYSQLI_ASSOC);  // Fetch all rows as an associative array
    ?>
    <div class="row">
      <?php
      // Loop through the offers and display them dynamically

      foreach ($offers as $offer) {

        // Responsive column classes (col-12 for extra small screens, col-md-4 for medium screens, col-lg-3 for large screens)
        echo  '<div class="col-12 col-md-4 col-lg-4 mt-4">';
        echo '<div class="banner-ad d-flex align-items-center" style="background: url(\'admin/uploads/offers/' . htmlspecialchars($offer['offer_image'] ? $offer['offer_image'] : "no_img.png") . '\') no-repeat; background-size: cover; height: 350px; width: 100%;">';
        echo '<div class="banner-content p-5">';
        echo '<div class="content-wrapper text-light">';
        echo '<h3 class="banner-title text-light">' . htmlspecialchars($offer['category_name']) . '</h3>';
        echo '<p>' . htmlspecialchars($offer['offer_description']) . '</p>';
        echo '<p>Discounts up to ' . htmlspecialchars($offer['offer_dis']) . '%</p>';
        echo '<a href="offers.php" class="btn-link text-white">Explore All Offers</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
  </div>
</section>



<section id="latest-blog" class="pb-4">
  <div class="container-lg">
    <div class="row">
      <div class="section-header d-flex align-items-center justify-content-between my-4">
        <h2 class="section-title">Our Recent Blog</h2>
        <a href="blogs.php" class="btn btn-primary">View All</a>
      </div>
    </div>
    <?php
    $selectQuery = "SELECT * FROM `tbl_blog` ORDER BY `blog_created_at` DESC LIMIT 3";
    $result = mysqli_query($conn, $selectQuery);
    ?>

    <div class="row">
      <?php while ($data = mysqli_fetch_array($result)) { ?>
        <div class="col-md-4">
          <article class="post-item card border-0 shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="view.php?blog_id=<?= $data['blog_id'] ?>">
                <img src="admin/uploads/blogs/<?= $data['blog_image_path'] == null ? 'no_img.png' : $data['blog_image_path'] ?>" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date">
                  <svg width="16" height="16">
                    <use xlink:href="#calendar"></use>
                  </svg><?= date('d M Y', strtotime($data['blog_created_at'])) ?>
                </div>
                <div class="meta-categories">
                  <svg width="16" height="16">
                    <use xlink:href="#category"></use>
                  </svg> <?= $data['blog_category'] ? $data['blog_category'] : 'General' ?>
                </div>
              </div>
              <div class="post-header">
                <h3 class="post-title">
                  <a href="blog_view.php?blog_id=<?= $data['blog_id'] ?>" class="text-decoration-none"><?= htmlspecialchars($data['blog_title']) ?></a>
                </h3>
                <p><?= substr(strip_tags($data['blog_content']), 0, 100) . '...' ?></p>
              </div>
            </div>
          </article>
        </div>
      <?php } ?>
    </div>

  </div>
</section>


<!-- <section class="py-4">
  <div class="container-lg">
    <h2 class="my-4">People are also looking for</h2>
    <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Blue diamon almonds</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Angie’s Boomchickapop Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Salty kettle Corn</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chobani Greek Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Sweet Vanilla Yogurt</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Foster Farms Takeout Crispy wings</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Warrior Blend Organic</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chao Cheese Creamy</a>
    <a href="#" class="btn btn-warning me-2 mb-2">Chicken meatballs</a>
  </div>
</section> -->

<section class="py-5">
  <div class="container-lg">
    <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
      <div class="col">
        <div class="card mb-3 border border-dark-subtle p-3">
          <div class="text-dark mb-3">
            <svg width="32" height="32">
              <use xlink:href="#package"></use>
            </svg>
          </div>
          <div class="card-body p-0">
            <h5>Free Delivery</h5>
            <p class="card-text">Enjoy complimentary delivery on all your orders. No hidden charges, just pure convenience.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 border border-dark-subtle p-3">
          <div class="text-dark mb-3">
            <svg width="32" height="32">
              <use xlink:href="#secure"></use>
            </svg>
          </div>
          <div class="card-body p-0">
            <h5>100% Secure Payment</h5>
            <p class="card-text">We ensure the highest security standards to protect your payment details. </p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 border border-dark-subtle p-3">
          <div class="text-dark mb-3">
            <svg width="32" height="32">
              <use xlink:href="#quality"></use>
            </svg>
          </div>
          <div class="card-body p-0">
            <h5>Quality Guarantee</h5>
            <p class="card-text">We stand behind the quality of our products. Rest assured, you'll receive only the best.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 border border-dark-subtle p-3">
          <div class="text-dark mb-3">
            <svg width="32" height="32">
              <use xlink:href="#savings"></use>
            </svg>
          </div>
          <div class="card-body p-0">
            <h5>Guaranteed Savings</h5>
            <p class="card-text">Enjoy great savings every time. We guarantee the best deals for your purchases.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 border border-dark-subtle p-3">
          <div class="text-dark mb-3">
            <svg width="32" height="32">
              <use xlink:href="#offers"></use>
            </svg>
          </div>
          <div class="card-body p-0">
            <h5>Daily Offers</h5>
            <p class="card-text">Take advantage of our special daily offers! There's always new for you to discover.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php
include("component/footer.php");
?>