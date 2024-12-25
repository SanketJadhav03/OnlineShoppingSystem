<?php
session_start();
include "config/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $customer_id = $_SESSION['customer_id'];

    // Check if the rating already exists
    $check_query = "SELECT * FROM tbl_ratings WHERE product_id = ? AND order_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("iii", $product_id, $order_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing rating
        $update_query = "UPDATE tbl_ratings SET rating = ?, description = ?, created_at = NOW() WHERE product_id = ? AND order_id = ? AND customer_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("issii", $rating, $description, $product_id, $order_id, $customer_id);
        if ($update_stmt->execute()) {
            echo "Rating updated successfully!";
        } else {
            echo "Failed to update rating.";
        }
    } else {
        // Insert new rating
        $insert_query = "INSERT INTO tbl_ratings (product_id, order_id, customer_id, rating, description, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iiiis", $product_id, $order_id, $customer_id, $rating, $description);
        if ($insert_stmt->execute()) {
            echo "Rating added successfully!";
        } else {
            echo "Failed to add rating.";
        }
    }
}
?>
