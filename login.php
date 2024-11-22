<?php
// Include database connection
include "config/connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if customer exists in the database
    $sql = "SELECT * FROM tbl_customer WHERE customer_email = '$email' AND customer_status = 1";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // User found, verify password
        $data = mysqli_fetch_assoc($result);
        if (password_verify($password, $data['customer_password'])) {
            $_SESSION['customer_id'] = $data['customer_id'];
            $_SESSION['customer_name'] = $data['customer_name'];
            header("Location: index.php"); // Redirect to customer dashboard
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No customer found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('cart-transformed.jpeg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-form {
            background-color: rgba(255, 228, 196, 0.9); /* Skin-like peachy color with 80% opacity */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .error {
            color: red;
        }
        .btn-primary {
            background-color: #007bff;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2 class="text-center fw-bold text-primary">Login</h2>
    
    <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" name="email" id="email" class="form-control fw-bold" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input type="password" name="password" id="password" class="form-control fw-bold" placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    
    <p class="text-center mt-3"><a href="forgot_password.php">Forgot Password?</a></p>
    <p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
