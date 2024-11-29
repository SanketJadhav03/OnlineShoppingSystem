<?php
session_start();
include "config/connection.php";

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
$total = $_POST['total_price'];  // Total price passed from the checkout form

// Insert order into tbl_orders
$order_query = "INSERT INTO tbl_orders (customer_id, total_price, order_date,shipping_address,payment_method, payment_status) 
                VALUES ('$customer_id', '$total', NOW(),$address,$payment_method, '1')";
if (mysqli_query($conn, $order_query)) {
    $order_id = mysqli_insert_id($conn);

    // Insert order items into tbl_order_items
    $cart_query = "SELECT * 
                   FROM tbl_cart_masters c
                   INNER JOIN tbl_product p ON c.cart_product_id = p.product_id
                   WHERE c.customer_id = '$customer_id'";
    $cart_result = mysqli_query($conn, $cart_query);
    while ($item = mysqli_fetch_assoc($cart_result)) {
        $product_id = $item['cart_product_id'];
        $quantity = $item['cart_product_qty'];
        $price = number_format(($item['product_price'] - $item['product_dis_value']) * $item['cart_product_qty'], 2);

        $order_item_query = "INSERT INTO tbl_order_items (order_id, product_id, quantity, price) 
                             VALUES ('$order_id', '$product_id', '$quantity', '$price')";
        mysqli_query($conn, $order_item_query);
    }

    // Clear the cart after placing the order
    mysqli_query($conn, "DELETE FROM tbl_cart_masters WHERE customer_id = '$customer_id'");

    // Redirect to order confirmation or success page
    header('Location: checkout-confirmation.php?order_id=' . $order_id);
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
