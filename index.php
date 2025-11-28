<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/img/BMS.png">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <h5>WELCOME TO</h5>
    <h1 class="fw-bold">BARANGAY <span class="text-success">GUSA</span></h1>
    <p>Gusa, Cagayan de Oro City</p>
    <div class="mt-3">
        <a href="contact.php" class="btn btn-light me-2">Contact Us</a>
        
        <?php if (isset($_SESSION['email'])): ?>
            <a href="pages/resident/resident_dashboard.php" class="btn btn-success">
                My Account
            </a>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">
                Login Now
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 text-center">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <img src="assets/img/home1.png" class="mx-auto mb-3" width="50" />
                    <h5>Barangay Officials</h5>
                    <a href="officials.php" class="btn btn-success mt-3">Learn More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <img src="assets/img/home2.png" class="mx-auto mb-3" width="50" />
                    <h5>Announcements</h5>
                    <a href="announcement.php" class="btn btn-success mt-3">Learn More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <img src="assets/img/home3.png" class="mx-auto mb-3" width="50" />
                    <h5>Issuance</h5>
                    <a href="issuance.php" class="btn btn-success mt-3">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Announcements Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4">Recent <span class="text-success">Announcements</span></h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card announcement-card p-3">
                    <img src="assets/img/announcement1.png" class="mb-3 w-100" />
                    <div>
                        <span class="badge bg-success">25 August</span>
                        <h6 class="mt-2">National Heroes Day</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing...</p>
                        <a href="#" class="text-success">See More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card announcement-card p-3">
                    <img src="assets/img/announcement2.png" class="mb-3 w-100" />
                    <div>
                        <span class="badge bg-success">28 August</span>
                        <h6 class="mt-2">Higalaay Fiestival 2025</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing...</p>
                        <a href="#" class="text-success">See More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card announcement-card p-3">
                    <img src="assets/img/announcement3.png" class="mb-3 w-100" />
                    <div>
                        <span class="badge bg-success">1 September</span>
                        <h6 class="mt-2">Pamaskong Handog</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing...</p>
                        <a href="#" class="text-success">See More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="announcement.php" class="btn btn-success">View All Announcements</a>
        </div>
    </div>
</section>

    <?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>