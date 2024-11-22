<?php
$title = "Contact Us";
include "config/connection.php";
include("component/header.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]); // New phone field
    $message = mysqli_real_escape_string($conn, $_POST["message"]);
    $created_at = date("Y-m-d H:i:s");
    $insertQuery = "INSERT INTO tbl_contact (contact_name, contact_email, contact_phone, contact_message, created_at) 
                    VALUES ('$name', '$email', '$phone', '$message', '$created_at')";
    if (mysqli_query($conn, $insertQuery)) {
        $successMessage = "Your message has been sent successfully!";
    } else {
        $errorMessage = "There was an error sending your message. Please try again.";
    }
}

?>

<div class="content-wrapper">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 bg-primary text-white">
        <h1 class="font-weight-bold mb-3">Get in Touch with Us</h1>
        <p class="lead">Have any questions or need assistance? We're here to help! Feel free to reach out, and we'll get back to you in no time.</p>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section py-5">
        <div class="container">
            <div class="row ">
                <!-- Contact Form -->
                <div class="col-md-6 ">
                    <h3 class="text-primary mb-4">Contact Form</h3>
                    <p class="text-muted mb-4 p-3">Your feedback is important to us. Whether you have a question, suggestion, or inquiry, please fill out the form below, and our team will respond promptly.</p>

                    <!-- Display Success or Error Messages -->
                    <?php if (isset($successMessage)) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $successMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php $successMessage = "";
                    } elseif (isset($errorMessage)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $errorMessage ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <form action="" method="POST" class="card p-5 shadow ">
                        <div class="mb-3 ">
                            <label for="name" class="form-label fw-bold">Your Name <span class="text-danger fw-bold">*</span> </label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Your Phone <span class="text-danger fw-bold">*</span> </label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="Enter your phone number">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Your Email <span class="text-danger fw-bold">*</span> </label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email address">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-bold">Your Message <span class="text-danger fw-bold">*</span> </label>
                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Write your message here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="col-md-6 ">
                    <h3 class="text-primary mb-4">Our Contact Information</h3>
                    <p class="text-muted pb-4 pl-4 pr-4">
                        We are here to assist you! Whether you need support, have queries, or just want to say hello, feel free to reach out using the details below.
                        Our dedicated team is always ready to provide you with prompt and professional assistance.
                        Don’t hesitate to connect with us for inquiries, feedback, or any information you may need.
                        Your satisfaction is our priority, and we strive to ensure every interaction with us is helpful and meaningful.
                        Let us know how we can serve you better!
                    </p>

                    <div class="contact-info">
                        <p><strong>Phone:</strong> 7304767697</p>
                        <p><strong>Email:</strong> jadhavsanket1303@gmail.com</p>
                        <p><strong>Address:</strong> Indapur road, Baramati, 413133</p>
                    </div>
                    <div class="map-section mt-4">
                        <h4 class="text-primary">Find Us Here</h4>
                        <p class="text-muted">We're easy to find! Just click on the map to get directions to our location.</p>
                        <!-- Embed Google Maps -->
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=YOUR_GOOGLE_MAPS_EMBED_URL_HERE" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Thank You Section (optional) -->
    <section class="thank-you-section py-5 bg-light text-center">
        <h3 class="font-weight-bold text-primary p-3">We Appreciate Your Message!</h3>
        <p class="text-muted">Thank you for reaching out to us. Your message is important, and our team will get back to you as soon as possible. We appreciate your time!</p>
        <p class="lead">Your inquiry is important to us, and we promise to respond promptly to address any questions or requests you may have.</p>
    </section>
</div>

<?php
include("component/footer.php");
?>