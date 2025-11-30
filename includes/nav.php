<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="index.php" class="navbar-brand">Barangay Management System</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto" style="margin-right: -95px;">

                <li class="nav-item"><a href="index.php" class="nav-link <?= ($currentPage=='index.php'?'active':'') ?>">Home</a></li>
                <li class="nav-item"><a href="announcement.php" class="nav-link <?= ($currentPage=='announcement.php'?'active':'') ?>">Announcements</a></li>
                <li class="nav-item"><a href="officials.php" class="nav-link <?= ($currentPage=='officials.php'?'active':'') ?>">Officials</a></li>
                <li class="nav-item"><a href="issuance.php" class="nav-link <?= ($currentPage=='issuance.php'?'active':'') ?>">Issuance</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link <?= ($currentPage=='contact.php'?'active':'') ?>">Contact</a></li>
                <li class="nav-item"><a href="calendar.php" class="nav-link <?= ($currentPage=='calendar.php'?'active':'') ?>">Calendar</a></li>

                <?php if (isset($_SESSION['email']) && ($_SESSION['status'] ?? '') === 'Approved'): ?>
                    <li class="nav-item">
                        <a href="pages/resident/resident_dashboard.php" class="btn btn-success ms-3">
                            My Account 
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="resident_login.php" class="btn btn-success ms-3">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>