<?php
include "config/connection.php";
include("component/header.php");

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch all orders of the logged-in user
$order_query = "SELECT * FROM tbl_orders WHERE customer_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$order_result = $stmt->get_result();
?>

<div class="content-wrapper">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 bg-primary text-white">
        <h1 class="fw-bold mb-3">My Orders</h1>
        <p class="lead">View your past orders and track their status.</p>
    </section>

    <!-- Order History Section -->
    <section class="order-history-section py-5">
        <div class="container">
            <div class="row">
                <?php
                if ($order_result->num_rows > 0) {
                    // Loop through each order
                    while ($order = $order_result->fetch_assoc()) {
                        $order_id = $order['order_id'];
                        $order_date = date("d/m/Y h:i A", strtotime($order['order_date']));

                        $order_status = $order['order_status'] == 1 ? "Pending" : ($order['order_status'] == 2 ? "Out For Delivery" : "Delivered");
                        $total_price = number_format($order['total_price'], 2);
                        $payment_status = $order['payment_status'];
                ?>
                        <div class="col-md-6 ">
                            <div class="row  mb-4 p-4  border  rounded shadow-sm">
                                <div class="col-6">
                                    <h5 class="mb-2  text-primary">ID: <span class="text-muted"><?php echo $order_id; ?></span></h5>
                                    <p><strong>Date:</strong> <?php echo $order_date; ?></p>
                                </div>
                                <div class="col-3">
                                    <p><strong>Status:</strong> <span class="badge bg-info  text-dark"><?php echo $order_status; ?></span></p>
                                </div>
                                <div class="col-3 ">
                                    <a href="order-track.php?order_id=<?php echo $order_id; ?>" class="btn btn-outline-primary mt-3 w-100">More Details</a>
                                </div>
                            </div> <!-- End of order-card -->
                        </div>
                <?php
                    }
                } else {
                    echo "<p class='text-center'>No orders found.</p>";
                }
                ?>

            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>