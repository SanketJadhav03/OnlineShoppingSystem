<?php
// Include database connection
include "config/connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $sql = "SELECT * FROM tbl_customer WHERE customer_email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Send reset password email (for demo, we'll just show a message)
        $reset_token = bin2hex(random_bytes(50)); // Generate a random reset token
        $reset_link = "http://yourdomain.com/reset_password.php?token=$reset_token"; // Link to reset password page
        
        // Store the token in the database (for demo purposes, not implemented here)
        
        // Here, send the email (In a real-world application, use PHPMailer or another email service)
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n$reset_link";
        mail($email, $subject, $message); // Send email (configure mail settings on the server)
        
        $success = "Password reset link has been sent to your email.";
    } else {
        $error = "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .forgot-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: auto;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .btn-primary {
            background-color: #007bff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="forgot-form">
        <h2 class="text-center text-primary">Forgot Password</h2>
        
        <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
        <?php if (isset($success)) { echo '<p class="success">' . $success . '</p>'; } ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        
        <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
