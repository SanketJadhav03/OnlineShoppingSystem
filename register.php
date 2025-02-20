<?php
// Include database connection
include "config/connection.php";
session_start();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));

    // Server-side validation
    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match('/^\d{10}$/', $phone)) {
        $error = "Phone number must be exactly 10 digits.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM tbl_customer WHERE customer_email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $error = "Email is already taken.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new customer into the database
            $insertSql = "INSERT INTO tbl_customer (customer_name, customer_email, customer_password, customer_phone, customer_address, customer_status, created_at)
                          VALUES ('$name', '$email', '$hashed_password', '$phone', '$address', 1, NOW())";

            if (mysqli_query($conn, $insertSql)) {
                $success = "Registration successful. You can now login.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('cart-transformed.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-form {
            background-color: rgba(255, 228, 196, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
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

    <div class="register-form">
        <h2 class="text-center text-primary fw-bold"> Register</h2>

        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <?php if (!empty($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>

        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input placeholder="Name" type="text" name="name" id="name" class="form-control fw-bold" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input placeholder="Email" type="email" name="email" id="email" class="form-control fw-bold" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input placeholder="Password" type="password" name="password" id="password" class="form-control fw-bold" required>
                <small class="text-muted">Password must be at least 6 characters long.</small>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Phone</label>
                <input placeholder="Phone" type="text" maxlength="10" name="phone" id="phone" class="form-control fw-bold" required>
                <small class="text-muted">Phone number must be exactly 10 digits.</small>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Address</label>
                <textarea placeholder="Address" name="address" id="address" class="form-control fw-bold" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script>
        function validateForm() {
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let address = document.getElementById("address").value.trim();

            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let phoneRegex = /^\d{10}$/;

            if (name === "" || email === "" || password === "" || phone === "" || address === "") {
                alert("All fields are required.");
                return false;
            }

            if (!emailRegex.test(email)) {
                alert("Invalid email format.");
                return false;
            }

            if (!phoneRegex.test(phone)) {
                alert("Phone number must be exactly 10 digits(Only).");
                return false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

            return true;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
