<?php
require_once '../../backend/auth_admin.php';
require __DIR__ . '/../../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->bms_db;

    $residentsCollection = $database->residents;

    $totalPopulation = $residentsCollection->countDocuments([]);

    $totalHouseholds = $residentsCollection->countDocuments([
        'family_head' => 'Yes'
    ]);

} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../../assets/img/BMS.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/dashboard.css" />
</head>

<body>

<div class="sidebar">
    <div class="sidebar-header">
        <img src="../../assets/img/profile.jpg" alt="">
        <div>
            <h3>Anonymous 1</h3>
            <small>admin@email.com</small>
            <div class="dept">IT Department</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="admin_dashboard.php" class="active"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="admin_announcement.php"><i class="bi bi-megaphone"></i> Announcement</a>
        <a href="admin_officials.php"><i class="bi bi-people"></i> Officials</a>
        <a href="admin_issuance.php"><i class="bi bi-bookmark"></i> Issuance</a>

        <div class="dropdown-container">
            <button class="dropdown-btn">
                <i class="bi bi-file-earmark-text"></i> Records
                <i class="bi bi-caret-down-fill dropdown-arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="admin_rec_residents.php">Residents</a>
                <a href="admin_rec_complaints.php">Complaints</a>
                <a href="admin_rec_blotter.php">Blotter</a>
            </div>
        </div>

        <a href="../../backend/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>


<div style="width:100%">

    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title">ADMIN <span class="green">DASHBOARD</span></h1>

        <div class="header-logos">
            <img src="../../assets/img/barangaygusalogo.png">
            <img src="../../assets/img/cdologo.png">
        </div>
    </div>

    <div class="content">

        <section class="top-info">
            <section class="left-column">
                <div class="stats-boxes">
                    <article class="stats-box">
                        <i class="bi bi-people-fill"></i>
                        <div class="details">
                            <div class="info"><?php echo number_format($totalPopulation); ?></div>
                            <div class="label">Total Population</div>
                        </div>
                    </article>

                    <article class="stats-box">
                        <i class="bi bi-house-door-fill"></i>
                        <div class="details">
                            <div class="info"><?php echo number_format($totalHouseholds); ?></div>
                            <div class="label">Households</div>
                        </div>
                    </article>
                </div>

                <div class="red-banner">Total Issuances Pending Release: 477</div>

                <div class="issuances-grid">
                    <div class="issuance-tile"><i class="bi bi-file-earmark-text"></i><div class="label">Barangay Clearance</div><div class="count">112</div></div>
                    <div class="issuance-tile"><i class="bi bi-award"></i><div class="label">Certificate of Residency</div><div class="count">168</div></div>
                    <div class="issuance-tile"><i class="bi bi-cash-coin"></i><div class="label">Certificate of Indigency</div><div class="count">89</div></div>
                    <div class="issuance-tile"><i class="bi bi-briefcase"></i><div class="label">Business Permit</div><div class="count">67</div></div>
                    <div class="issuance-tile"><i class="bi bi-wrench"></i><div class="label">Building Permit</div><div class="count">22</div></div>
                    <div class="issuance-tile"><i class="bi bi-envelope"></i><div class="label">Solicitations</div><div class="count">6</div></div>
                    <div class="issuance-tile"><i class="bi bi-hourglass-split"></i><div class="label">Lupon</div><div class="count">13</div></div>
                    <div class="issuance-tile"><i class="bi bi-plus-lg"></i><div class="label">Others</div></div>
                </div>
            </section>

            <section class="right-column">

                <!-- Calendar -->
                <section class="calendar-container">
                    <div>
                        <h3 class="calendar-header">BARANGAY <span class="green">CALENDAR</span></h3>
                    </div>
                    <div class="calendar-header">
                        <button id="prev-month">&lt;</button>
                        <h2 id="month-year"></h2>
                        <button id="next-month">&gt;</button>
                    </div>

                    <div class="calendar-grid" id="calendar-grid"></div>
                </section>


                <article class="timeline" id="timeline-events">
                    <p>Loading events...</p>
                </article>

            </section>
        </section>
    </div>
</div>

<script src="../../assets/js/calendar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

fetch("../../backend/announcement_get_dashboard.php")
    .then(res => res.json())
    .then(data => {
        let timelineHTML = "";

        data.forEach(event => {
            timelineHTML += `
                <div class="timeline-event mb-3">
                    <strong class="event-title">${event.title}</strong><br>
                    <span class="event-location"><i class="bi bi-geo-alt-fill me-1"></i>${event.location}</span><br>
                    <span class="event-datetime"><i class="bi bi-calendar-event me-1"></i>${event.time} | ${event.date}</span>
                </div>
            `;
        });

        document.getElementById("timeline-events").innerHTML =
            timelineHTML || "<p>No upcoming announcements.</p>";
    });

</script>
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
