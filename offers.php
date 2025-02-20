<?php
include "config/connection.php";
include "component/header.php";

// Fetch active offers from the database, along with category name, ordered by creation date
$selectQuery = "
    SELECT o.*, c.category_name
    FROM tbl_offer o
    LEFT JOIN tbl_category c ON o.offer_category = c.category_id
    WHERE o.offer_status = 1
";
$result = mysqli_query($conn, $selectQuery);
?>

<div class="content-wrapper  ">
    <div class="card border-0">
        <div class="card-header text-center p-4">
            <h3 class="font-weight-bold text-primary">All Active Offers</h3>
            <p class="text-muted">Grab the latest offers and discounts</p>
        </div>
        <div class="card-body">
            <div class="row">
                <?php while ($data = mysqli_fetch_array($result)) { ?>
                    <div class="col-md-3 mb-4">
                        <article class="offer-item card border-0 shadow-sm p-3 rounded-lg hover-zoom">
                            <div class="image-holder position-relative overflow-hidden rounded-lg">
                                <a href="view_offer.php?offer_id=<?= $data['offer_id'] ?>">
                                    <img src="admin/uploads/offers/<?= $data['offer_image'] == null ? 'no_img.png' : $data['offer_image'] ?>" alt="offer" class="card-img-top w-100">
                                </a> 
                            </div>
                            <div class="card-body p-4">
                                <div class="offer-meta d-flex justify-content-between text-uppercase gap-2 my-2">
                                    <div class="meta-date text-muted">
                                        <?= date('d M Y', strtotime($data['offer_created_at'])) ?>
                                    </div>
                                    <div class="meta-category text-muted fw-bold">
                                       <?= $data['category_name']   ?>
                                    </div>
                                </div>
                                <div class="offer-header">
                                
                                    <p class="fw-bold text-primary"><?= strip_tags($data['offer_description']) ?></p>
                                    <span class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary"><?= number_format($data['offer_dis']) ?>% OFF</span>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
include "component/footer.php";
?>