<?php
session_start();
session_destroy();
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/OnlineShoppingSystem/admin/authentication/'; 
header("Location: $base_url");
?>