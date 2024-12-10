<?php
include "config/connection.php";
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo "You must be logged in to rate.";
    exit();
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $order_id = intval($_POST['order_id']);
    $rating = intval($_POST['rating']);

    // Check if the user has already rated this product in the order
    $check_query = "SELECT * FROM tbl_ratings WHERE product_id = ? AND order_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("iii", $product_id, $order_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing rating
        $update_query = "UPDATE tbl_ratings SET rating = ?, created_at = NOW() WHERE product_id = ? AND order_id = ? AND customer_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("iiii", $rating, $product_id, $order_id, $customer_id);
        $update_stmt->execute();
        echo "Rating updated successfully!";
    } else {
        // Insert new rating
        $insert_query = "INSERT INTO tbl_ratings (order_id, product_id, customer_id, rating) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iiii", $order_id, $product_id, $customer_id, $rating);
        $insert_stmt->execute();
        echo "Rating saved successfully!";
    }
}
?>
