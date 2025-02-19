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
                        $total_price = number_format($order['total_price'], 2);
                        $payment_status = $order['payment_status'];

                        // Order status logic
                        switch ($order['order_status']) {
                            case 1:
                                $order_status = "Pending";
                                $badge_class = "bg-warning text-dark";
                                break;
                            case 2:
                                $order_status = "Out For Delivery";
                                $badge_class = "bg-info text-white";
                                break;
                            case 3:
                                $order_status = "Delivered";
                                $badge_class = "bg-success text-white";
                                break;
                            default:
                                $order_status = "Unknown";
                                $badge_class = "bg-secondary text-white";
                        }
                ?>
                        <div class="col-md-6">
                            <div class="p-4 border rounded shadow mb-4" style="background-color: #f9f9f9; border-left: 5px solid #007bff;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="text-primary">Order #<?php echo $order_id; ?></h5>
                                    <span class="badge <?php echo $badge_class; ?>"><?php echo $order_status; ?></span>
                                </div>
                                <p class="mb-1"><strong>Date:</strong> <?php echo $order_date; ?></p>
                                <p class="mb-1"><strong>Total:</strong> ₹<?php echo $total_price; ?></p>
             
                                <p class="mb-1 text-start">

                                    <strong>Payment Status:</strong>
                                    <span class="badge <?php echo $payment_status == '0' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $payment_status == '0' ? 'Paid' : 'Pending'; ?>
                                    </span>
                                </p>
                                <div class="text-end">
                                    <a href="order-track.php?order_id=<?php echo $order_id; ?>" class="btn btn-outline-primary btn-sm">Track Order</a>
                                </div>
                            </div> <!-- End of order card -->
                        </div>
                <?php
                    }
                } else {
                    echo "<p class='text-center text-muted'>You have no orders yet.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>