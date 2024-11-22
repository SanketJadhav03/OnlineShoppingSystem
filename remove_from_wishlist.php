<?php
include "config/connection.php";
if (isset($_GET['wishlist_id'])) {
    $wishlist_id = $_GET['wishlist_id'];
    
    // Delete the product from wishlist
    $remove_query = "DELETE FROM tbl_wishlist_masters WHERE wishlist_id = ?";
    $stmt = $conn->prepare($remove_query);
    $stmt->bind_param("i", $wishlist_id);
    $stmt->execute();
    
    // Redirect back to the wishlist page
    header("Location: products.php");
    exit;
}
?>
