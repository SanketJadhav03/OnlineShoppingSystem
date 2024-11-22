<?php
$title = "About Us";
include "config/connection.php";
include("component/header.php"); 
?>

<div class="content-wrapper ">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5  bg-primary text-white">
        <h1 class="p-3 font-weight-bold mb-3">Welcome to Online Shopping</h1>
        <p class="lead">We are dedicated to bringing you the best shopping experience with top-notch products and exceptional service.</p>
    </section>

    <!-- Our Mission -->
    <section class="mission-section py-5">
        <div class="container">
            <div class="row text-center p-3">
                <div class="col-md-6">
                    <h2 class="font-weight-bold text-primary">Our Mission</h2>
                    <p class="text-muted p-3">Our mission is to provide customers with a seamless and reliable shopping experience. We believe in quality, affordability, and innovation, making sure every product meets your needs and expectations.</p>
                </div>
                <div class="col-md-6">
                    <h2 class="font-weight-bold text-primary">Our Vision</h2>
                    <p class="text-muted p-3">To become the leading online marketplace known for delivering outstanding products at the best prices, while providing excellent customer service and creating a trustworthy shopping platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="values-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center font-weight-bold text-primary mb-4">Our Core Values</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title p-3">Integrity</h5>
                            <p class="card-text">We prioritize honesty and transparency in everything we do, building trust with our customers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title p-3">Customer-Centric</h5>
                            <p class="card-text">Our customers' satisfaction is our top priority. We strive to exceed their expectations in every way possible.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title p-3">Innovation</h5>
                            <p class="card-text">We are constantly innovating to offer the best products and services, keeping up with the latest trends.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section py-5">
        <div class="container">
            <h2 class="text-center font-weight-bold text-primary mb-4">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <p class="text-muted p-3">"The best shopping experience I've had online. Fast delivery and excellent customer service!"</p>
                            <p class="font-weight-bold">- John Doe</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <p class="text-muted p-3">"Amazing product quality at affordable prices. Highly recommend this store!"</p>
                            <p class="font-weight-bold">- Jane Smith</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <p class="text-muted p-3">"I found everything I needed, and the customer support was incredibly helpful."</p>
                            <p class="font-weight-bold">- Mark Wilson</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us -->
    <section class="contact-us-section py-5 bg-light">
        <div class="container text-center">
            <h2 class="font-weight-bold text-primary mb-4">Get in Touch</h2>
            <p class="text-muted mb-4">Have any questions? We’d love to hear from you. Feel free to reach out to us, and we’ll get back to you as soon as possible!</p>
            <a href="contact-us.php" class="btn btn-primary">Contact Us</a>
        </div>
    </section>
</div>

<?php
include("component/footer.php"); 
?>
