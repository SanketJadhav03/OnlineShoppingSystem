<?php
include("config/connection.php");
include("component/header.php");
?>

<div class="content-wrapper">
    <!-- FAQ Section -->
    <section class="faq-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-4">Frequently Asked Questions</h2>

                    <!-- FAQ 1 -->
                    <div class="faq-item mb-3">
                        <h5 class="faq-question">
                            What payment methods are accepted?
                        </h5>
                        <div class="faq-answer">
                            <For>Currently, we accept payments via <strong>Cash on Delivery</strong> and <strong>Pay by QR Code</strong> only.
                                <br>
                                For <strong>Cash on Delivery</strong>, you can pay the exact amount in cash when the delivery arrives at your doorstep.
                                <br>
                                For <strong>Pay by QR Code</strong>, simply scan the QR code provided at the checkout page to make an online payment.
                                <br>
                                We are continuously improving our services and will be adding more payment methods in the next update. Stay tuned!</p>
                        </div>
                    </div>


                    <!-- FAQ 2 -->
                    <div class="faq-item mb-3">
                        <h5 class="faq-question">
                            How can I track my order?
                        </h5>
                        <div class="faq-answer">
                            <p>You can track your order by visiting the <strong>Order History</strong> section, which is available in the footer under the "Quick Links" group. Here, you will find both your past and current orders.</p>
                            <p>Simply click on the order you want to track, and you'll be able to view its status and track it in real-time.</p>
                        </div>
                    </div>


                    <!-- FAQ 3 -->
                    <div class="faq-item mb-3">
                        <h5 class="faq-question">
                            Can I change my order after placing it?
                        </h5>
                        <div class="faq-answer">
                            <p>Unfortunately, we cannot modify orders once they have been placed. Please review your order before confirming.</p>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="faq-item mb-3">
                        <h5 class="faq-question">
                            How do I return a product?
                        </h5>
                        <div class="faq-answer">
                            <p>Currently, we do not have a return policy in place. Please ensure that you review your order carefully before completing the purchase.
                                <br>
                                <i>If you have any issues with the product, please contact our customer support team for assistance.</i>
                            </p>
                        </div>
                    </div>


                    <!-- FAQ 5 -->
                    <div class="faq-item mb-3">
                        <h5 class="faq-question">
                            How do I contact customer support?
                        </h5>
                        <div class="faq-answer">
                            <p>You can reach our customer support team by visiting the 'Contact Us' page on our website, where you can find our email address, phone number, and a contact form. We're happy to assist you with any inquiries.</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

<?php
include("component/footer.php");
?>

<style>
    .faq-section {
        background-color: #f8f9fa;
    }

    .faq-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .faq-question {
        font-size: 18px;
        cursor: pointer;
        font-weight: bold;
    }

    .faq-answer {
        margin-top: 10px;
        padding-left: 20px;
        font-size: 16px;
        color: #555;
        display: block;
        /* Ensures the answer is always visible */
    }

    .faq-question:hover {
        color: #007bff;
    }
</style>