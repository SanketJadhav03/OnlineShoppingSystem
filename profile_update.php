<?php
$title = "Profile Update";
include "config/connection.php";
include("component/header.php");

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the user's current details
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM tbl_customer WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    // Check if password fields are filled
    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update the user's profile with the new password
            $update_sql = "UPDATE tbl_customer SET customer_name = ?, customer_phone = ?, customer_email = ?, customer_address = ?, customer_password = ? WHERE customer_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sssssi", $name, $phone, $email, $address, $hashed_password, $customer_id);
        } else {
            $errorMessage = "Passwords do not match.";
        }
    } else {
        // Update the user's profile without changing the password
        $update_sql = "UPDATE tbl_customer SET customer_name = ?, customer_phone = ?, customer_email = ?, customer_address = ? WHERE customer_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $name, $phone, $email, $address, $customer_id);
    }

    if (isset($update_stmt) && $update_stmt->execute()) {
        $successMessage = "Profile updated successfully.";
        // Update session data
        $_SESSION['customer_name'] = $name;
    } else {
        $errorMessage = isset($errorMessage) ? $errorMessage : "Error updating profile. Please try again.";
    }
}
?>

<div class="content-wrapper">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 bg-primary text-white">
        <h1 class="font-weight-bold mb-3">Update Your Profile</h1>
        <p class="lead">Keep your profile up-to-date for a personalized experience.</p>
    </section>

    <!-- Profile Update Form Section -->
    <section class="contact-form-section py-5">
        <div class="container">
            <div class="row align-center justify-content-center">
                <!-- Profile Update Form -->
                <div class="col-md-6">
                    <h3 class="text-primary mb-4">Update Profile</h3>
                    <p class="text-muted mb-4">You can update your personal information below. Fields marked with <span class="text-danger">*</span> are required.</p>

                    <!-- Display Success or Error Messages -->
                    <?php if (isset($successMessage)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $successMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } elseif (isset($errorMessage)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $errorMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <form action="" method="POST" class="card p-5 shadow">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Your Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['customer_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Your Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['customer_phone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Your Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['customer_email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Your Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="5" required><?= htmlspecialchars($user['customer_address']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password (optional)">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="col-md-12 mt-5">
                    <h3 class="text-primary mb-4">Need Help?</h3>
                    <p class="text-muted pb-4">
                        If you face any issues updating your profile, feel free to contact our support team for assistance. We're here to help!
                    </p>
                    <div class="contact-info">
                        <p><strong>Customer Care:</strong> 7304767697</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>
