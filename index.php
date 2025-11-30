<?php
require_once "backend/config.php"; 

$announcementFilter = ['status' => 'active'];
$announcements = $announcementCollection->find(
    ['status' => 'active'],
    [
        'limit' => 3,
        'sort' => ['date' => -1]
    ]
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>BMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="assets/img/BMS.png">
    <link rel="stylesheet" href="css/style.css?v=1" />
    <link rel="stylesheet" href="css/toast.css">
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
                    <img src="assets/img/officials.png" class="mx-auto mb-3" width="150" />
                    <h5>Barangay Officials</h5>
                    <a href="officials.php" class="btn btn-success mt-3">Learn More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <img src="assets/img/announcements.png" class="mx-auto mb-3" width="150" />
                    <h5>Announcements</h5>
                    <a href="announcement.php" class="btn btn-success mt-3">Learn More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <img src="assets/img/issuance.png" class="mx-auto mb-3" width="150" />
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
            <?php foreach ($announcements as $item): ?>
            <div class="col-md-4 d-flex">
                <div class="card home-announce-card p-3 d-flex flex-column h-100 w-100">

                    <!-- Image -->
                    <?php if (!empty($item->image)): ?>
                        <img src="uploads/announcements/<?= $item->image ?>" class="mb-3 w-100 home-announce-img" />
                    <?php else: ?>
                        <img src="assets/img/announcement_placeholder.png" class="mb-3 w-100 home-announce-img" />
                    <?php endif; ?>

                    <!-- TEXT CONTENT -->
                    <div class="d-flex flex-column flex-grow-1 text-start">

                        <!-- DATE + TIME -->
                        <span class="badge bg-success mb-2 home-date">
                            <?= date("d M Y", strtotime($item->date)) ?>
                            <?= !empty($item->time) ? " | " . date("h:i A", strtotime($item->time)) : "" ?>
                        </span>

                        <?php if (!empty($item->location)): ?>
                            <div class="mb-2 text-secondary home-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                <?= htmlspecialchars($item->location) ?>
                            </div>
                        <?php endif; ?>


                        <!-- TITLE -->
                        <h6 class="fw-bold mt-2 home-announce-title">
                            <?= htmlspecialchars($item->title) ?>
                        </h6>

                        <!-- DETAILS -->
                        <p class="home-announce-details flex-grow-1">
                            <?= strlen($item->details) > 80 ? substr($item->details, 0, 80) . "..." : htmlspecialchars($item->details) ?>
                        </p>

                        <!-- SEE MORE -->
                        <a href="see-more-announcement.php?id=<?= $item->_id ?>" class="text-success mt-auto">
                            See More
                        </a>

                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4">
            <a href="announcement.php" class="btn btn-success">View All Announcements</a>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
<div id="toast" class="toast"></div>

<script>
function showToast(message, type = "error") {
    const t = document.getElementById("toast");

    // Reset classes (VERY IMPORTANT)
    t.className = "toast";

    t.textContent = message;
    t.classList.add(type);
    t.classList.add("show");

    setTimeout(() => {
        t.classList.remove("show");
    }, 3000);
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_SESSION['toast'])): ?>
<script>
    showToast("<?= $_SESSION['toast']['msg'] ?>", "<?= $_SESSION['toast']['type'] ?>");
</script>
<?php unset($_SESSION['toast'], $_SESSION['toast_type']); endif; ?>

</body>
</html>
