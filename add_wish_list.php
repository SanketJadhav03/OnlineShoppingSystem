<?php
session_start();
// Include necessary files for database connection and session management
include "config/connection.php"; // Include the database connection file

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the product ID from the request (e.g., from URL or form)
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $customer_id = $_SESSION['customer_id']; // Get customer ID from session

    // Check if the product already exists in the wishlist
    $query = "SELECT * FROM tbl_wishlist_masters WHERE wishlist_product_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $product_id, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the product is already in the wishlist, show a message
        $_SESSION['message'] = 'Product already in your wishlist!';
    } else {
        // Insert the product into the wishlist
        $insert_query = "INSERT INTO tbl_wishlist_masters (wishlist_product_id, customer_id, wishlist_status) VALUES (?, ?, 'active')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $product_id, $customer_id);

        if ($stmt->execute()) {
            // If insertion is successful, show a success message
            $_SESSION['message'] = 'Product added to your wishlist!';
        } else {
            // If there is an error, show an error message
            $_SESSION['message'] = 'Error adding product to wishlist.';
        }
    }

    // Redirect back to the product page or wishlist page
    header("Location: products.php");
    exit();
} else {
    // If no product ID is provided, redirect to the products page
    header("Location: products.php");
    exit();
}
?>
