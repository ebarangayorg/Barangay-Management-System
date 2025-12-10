<?php
session_start();
require_once 'backend/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>BMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/img/BMS.png">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php include 'includes/nav.php'; ?>

    <section class="header-banner">
        <img src="assets/img/cdologo.png" class="left-logo" alt="left logo">
        <div class="header-text">
            <h1>Barangay</h1> 
            <h3>Contact</h3>
        </div>
        <img src="assets/img/barangaygusalogo.png" class="right-logo" alt="right logo">
    </section>

    <section class="registration-form">
        <h2>GET IN TOUCH WITH US</h2>
        
        <!-- Contact Details -->
        <div class="contact-details mb-4">
        <p><strong>Barangay Address:</strong> Barangay Gusa, Cagayan de Oro City</p>
        <p><strong>Email:</strong> info@brgygusacdo.com</p>
        <p><strong>Phone:</strong> 0909-000-0000</p>
        <p><strong>Office Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM</p>
        </div>

        <!-- Complaint Form -->
        <h4>Send Us Your Complaint or Concern</h4>
        <form action="backend/complaint_process.php" method="POST">
        
        <div class="form-row">
            <input type="text" name="fullname" placeholder="Your Full Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
        </div>

        <div class="form-row">
            <input type="text" name="subject" placeholder="Subject" required>
        </div>

        <div class="form-row">
            <textarea name="message" rows="6" placeholder="Type your complaint or concern here..." required></textarea>
        </div>

        <p class="note">Please be informed that your information will be checked and handle carefully. We may notify you via email regarding your concerns and complains</p>

        <button type="submit">SEND MESSAGE</button>
        </form>

        <p style="text-align:center; margin-top:20px;">
        <a href="index.php">Back to Homepage</a>
        </p>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>