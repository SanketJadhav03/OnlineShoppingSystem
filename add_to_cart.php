<?php
session_start();
include "config/connection.php"; // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Get the product ID and customer ID
$product_id = intval($_GET['product_id']);
$customer_id = intval($_SESSION['customer_id']);
$product_qty = 1; // Default quantity for the cart
$cart_status = 'active'; // Default cart status

// Check if the product is already in the cart
$sql_check = "SELECT * FROM tbl_cart_masters WHERE cart_product_id = ? AND customer_id = ? AND cart_status = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("iis", $product_id, $customer_id, $cart_status);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // If product already exists in the cart, update the quantity
    $sql_update = "UPDATE tbl_cart_masters SET cart_product_qty = cart_product_qty + 1 WHERE cart_product_id = ? AND customer_id = ? AND cart_status = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iis", $product_id, $customer_id, $cart_status);
    if ($stmt_update->execute()) {
        $_SESSION["message"] = "Product updated in cart!";
        header("Location: products.php");
    } else {
        $_SESSION["message"] = "Failed to update cart!";
        header("Location: products.php");
    }
} else {
    // If product is not in the cart, add it
    $sql_insert = "INSERT INTO tbl_cart_masters (cart_product_id, cart_product_qty, customer_id, cart_status) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiis", $product_id, $product_qty, $customer_id, $cart_status);
    if ($stmt_insert->execute()) {
        $_SESSION["message"] = "Product updated in cart!";
        header("Location: products.php");
    } else {
        $_SESSION["message"] = "Failed to update cart!";
        header("Location: products.php");
    }
}
?>
