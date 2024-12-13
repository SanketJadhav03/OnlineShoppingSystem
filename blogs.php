<?php
include "config/connection.php";
include "component/header.php";  
$selectQuery = "SELECT * FROM `tbl_blog` ORDER BY `blog_created_at` DESC"; 
$result = mysqli_query($conn, $selectQuery);
?>

<div class="content-wrapper p-4">
    <div class="card border-0  ">
        <div class="card-  text-center p-4">
            <h3 class="font-weight-bold text-primary">All Blog Posts</h3>
            <p class="text-muted">Discover the latest insights, tips, and trends</p>
        </div>
        <div class="card-body">
            <div class="row">
                <?php while ($data = mysqli_fetch_array($result)) { ?>
                    <div class="col-md-4 mb-4">
                        <article class="post-item card border-0 shadow-sm p-3 rounded-lg hover-zoom">
                            <div class="image-holder position-relative overflow-hidden rounded-lg">
                                <a href="blog_view.php?blog_id=<?= $data['blog_id'] ?>">
                                    <img src="admin/uploads/blogs/<?= $data['blog_image_path'] == null ? 'no_img.png' : $data['blog_image_path'] ?>" alt="post" class="card-img-top w-100">
                                </a>
                                <div class="hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
                                    <!-- <span class="text-white fs-3">Read More</span> -->
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="post-meta d-flex justify-content-between text-uppercase gap-2 my-2">
                                    <div class="meta-date text-muted">
                                        <svg width="16" height="16">
                                            <use xlink:href="#calendar"></use>
                                        </svg><?= date('d M Y', strtotime($data['blog_created_at'])) ?>
                                    </div>
                                    <div class="meta-categories text-muted">
                                        <svg width="16" height="16">
                                            <use xlink:href="#category"></use>
                                        </svg> <?= $data['blog_category'] ? $data['blog_category'] : 'General' ?>
                                    </div>
                                </div>
                                <div class="post-header">
                                    <h4 class="post-title">
                                        <a href="blog_view.php?blog_id=<?= $data['blog_id'] ?>" class="text-decoration-none text-dark fw-bold"><?= htmlspecialchars($data['blog_title']) ?></a>
                                    </h4>
                                    <p class="text-muted"><?= strip_tags($data['blog_content']) ?></p>
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
