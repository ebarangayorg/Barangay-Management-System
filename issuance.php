<?php 
session_start();
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
        <h3>Issuance</h3>
    </div>
    <img src="assets/img/barangaygusalogo.png" class="right-logo" alt="right logo">
</section>

<div class="container" style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-bottom:50px; margin-top: 50px">
    
    <!-- CARD 1 -->
    <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
        <img src="assets/img/clearance.png">
        <h5>Barangay Clearance</h5>
        <p>Lorem Ipsum is simply dummy text...</p>
        <p><strong>Price: ₱50</strong></p>

        <?php if (isset($_SESSION['email'])): ?>
            <button class="btn btn-success openRequestModal" data-doc="Barangay Clearance">
                Request Now
            </button>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">Request Now</a>
        <?php endif; ?>
    </div>

    <!-- CARD 2 -->
    <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
        <img src="assets/img/indigency.png">
        <h5>Certificate of Indigency</h5>
        <p>Lorem Ipsum is simply dummy text...</p>
        <p><strong>Price: ₱50</strong></p>

        <?php if (isset($_SESSION['email'])): ?>
            <button class="btn btn-success openRequestModal" data-doc="Certificate of Indigency">
                Request Now
            </button>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">Request Now</a>
        <?php endif; ?>
    </div>

    <!-- CARD 3 -->
    <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
        <img src="assets/img/residency.png">
        <h5>Certificate of Residency</h5>
        <p>Lorem Ipsum is simply dummy text...</p>
        <p><strong>Price: ₱50</strong></p>

        <?php if (isset($_SESSION['email'])): ?>
            <button class="btn btn-success openRequestModal" data-doc="Certificate of Residency">
                Request Now
            </button>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">Request Now</a>
        <?php endif; ?>
    </div>

    <!-- CARD 4 -->
    <div class="card-custom announcement-card" style="width:250px; text-align:center; padding:20px; background:#fff;">
        <img src="assets/img/business.png">
        <h5>Barangay Business Clearance</h5>
        <p>Lorem Ipsum is simply dummy text...</p>
        <p><strong>Price: ₱50</strong></p>

        <?php if (isset($_SESSION['email'])): ?>
            <button class="btn btn-success openRequestModal" data-doc="Barangay Business Clearance">
                Request Now
            </button>
        <?php else: ?>
            <a href="resident_login.php" class="btn btn-success">Request Now</a>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="requestModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="border-radius: 12px; overflow:hidden;">

      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">Request Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="pages/resident/resident_rqs_service.php" method="POST">
        <div class="modal-body px-4">

          <p><strong>Full Name:</strong> <?= $_SESSION['fullname'] ?? 'Resident' ?></p>
          <p><strong>Email:</strong> <?= $_SESSION['email'] ?? 'N/A' ?></p>
          <p><strong>Document Type:</strong> <span id="docPreview"></span></p>

          <label class="form-label mt-3 fw-semibold">Purpose of Request:</label>
          <textarea class="form-control" name="purpose" rows="3" required
                    placeholder="Enter your purpose here..."></textarea>

          <input type="hidden" id="docType" name="document_type">

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success w-100 mt-2">Proceed</button>
        </div>

      </form>

    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.openRequestModal').forEach(btn => {
    btn.addEventListener('click', function () {
        const docType = this.dataset.doc;

        document.getElementById('docType').value = docType;
        document.getElementById('docPreview').innerText = docType;

        let modal = new bootstrap.Modal(document.getElementById('requestModal'));
        modal.show();
    });
});
</script>

</body>
</html>
