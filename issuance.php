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

  <section class="header-banner" style="display: flex; align-items: center; justify-content: center;">
        <div class="overlay" style="display: flex; align-items: center; gap: 20px;">
            <h1>Barangay</h1> 
            <h3>Issuance</h3>
        </div>
    </section>

<!-- Issuance Cards -->
    <div class="container" style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-bottom:50px; margin-top: 50px">
        
        <!-- Card 1 -->
        <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
            <img src="assets/img/clearance.png" alt="Barangay Clearance">
            <h5>Barangay Clearance</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
            <p><strong>Price: ₱50</strong></p>
            <?php if (isset($_SESSION['email'])): ?>
            <a href="pages/resident/resident_rqs_service.php" class="btn btn-success">
                Request Now
            </a>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">
                Request Now
            </a>
        <?php endif; ?>
        </div>

        <!-- Card 2 -->
        <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
            <img src="assets/img/indigency.png" alt="Certificate of Indigency">
            <h5>Certificate of Indigency</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
            <p><strong>Price: ₱50</strong></p>
            <?php if (isset($_SESSION['email'])): ?>
            <a href="pages/resident/resident_rqs_service.php" class="btn btn-success">
                Request Now
            </a>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">
                Request Now
            </a>
        <?php endif; ?>
        </div>

        <!-- Card 3 -->
        <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
            <img src="assets/img/residency.png" alt="Certificate of Residency">
            <h5>Certificate of Residency</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
            <p><strong>Price: ₱50</strong></p>
            <?php if (isset($_SESSION['email'])): ?>
            <a href="pages/resident/resident_rqs_service.php" class="btn btn-success">
                Request Now
            </a>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">
                Request Now
            </a>
        <?php endif; ?>
        </div>

        <!-- Card 4 -->
        <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
            <img src="assets/img/business.png" alt="Business Clearance">
            <h5>Barangay Business Clearance</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
            <p><strong>Price: ₱50</strong></p>
            <?php if (isset($_SESSION['email'])): ?>
            <a href="pages/resident/resident_rqs_service.php" class="btn btn-success">
                Request Now
            </a>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">
                Request Now
            </a>
        <?php endif; ?>
        </div>
    </div>


  <!-- Footer -->
  <?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>