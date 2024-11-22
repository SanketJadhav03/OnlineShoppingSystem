<?php
session_start();
include "config/connection.php"; // Include your database connection file

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['error'] = 'You must be logged in to remove items from the cart.';
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id']; // Get the logged-in customer ID
$product_id = $_GET['product_id']; // Get the product ID from the URL

// Validate the product ID
if (empty($product_id) || !is_numeric($product_id)) {
    $_SESSION['error'] = 'Invalid product ID.';
    header('Location: products.php'); // Redirect back to cart
    exit();
}

// Prepare the SQL statement to remove the product from the cart
$remove_query = "DELETE FROM tbl_cart_masters WHERE cart_product_id = ? AND customer_id = ?";
$stmt = $conn->prepare($remove_query);
$stmt->bind_param("ii", $product_id, $customer_id);

if ($stmt->execute()) {
    $_SESSION['message'] = 'Product removed from your cart successfully.';
} else {
    $_SESSION['error'] = 'There was an error removing the product from your cart.';
}

header('Location: products.php'); // Redirect to the cart page
exit();
?>
