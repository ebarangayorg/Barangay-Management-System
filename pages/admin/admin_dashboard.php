<?php require_once '../../backend/auth_admin.php'; ?>

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
    <link rel="stylesheet" href="../../css/toast.css">

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

      <!-- Dropdown Menu -->
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
        <section class="left-column" aria-label="Statistics and issuances summary">
          <div class="stats-boxes" aria-label="Summary statistics">
            <article
              class="stats-box"
              aria-labelledby="pop-label pop-count"
              role="region"
              tabindex="0">
              <i class="bi bi-people-fill" aria-hidden="true"></i>
              <div class="details">
                <div id="pop-count" class="info">28,974</div>
                <div id="pop-label" class="label">Total Population</div>
              </div>
            </article>
            <article
              class="stats-box"
              aria-labelledby="house-label house-count"
              role="region"
              tabindex="0">
              <i class="bi bi-house-door-fill" aria-hidden="true"></i>
              <div class="details">
                <div id="house-count" class="info">6,798</div>
                <div id="house-label" class="label">Households</div>
              </div>
            </article>
          </div>

          <div
            class="red-banner"
            role="alert"
            aria-live="assertive"
            aria-atomic="true">
            Total Issuances Pending Release: 477
          </div>

          <div
            class="issuances-grid"
            role="list"
            aria-label="Barangay issuance categories and counts">
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Barangay Clearance 112"
              tabindex="0">
              <i class="bi bi-file-earmark-text"></i>
              <div class="label">Barangay Clearance</div>
              <div class="count">112</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Certificate of Residency 168"
              tabindex="0">
              <i class="bi bi-award"></i>
              <div class="label">Certificate of Residency</div>
              <div class="count">168</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Certificate of Indigency 89"
              tabindex="0">
              <i class="bi bi-cash-coin"></i>
              <div class="label">Certificate of Indigency</div>
              <div class="count">89</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Barangay Business Permit 67"
              tabindex="0">
              <i class="bi bi-briefcase"></i>
              <div class="label">BRGY Business Permit</div>
              <div class="count">67</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Barangay Building Permit 22"
              tabindex="0">
              <i class="bi bi-wrench"></i>
              <div class="label">BRGY Building Permit</div>
              <div class="count">22</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Solicitations 6"
              tabindex="0">
              <i class="bi bi-envelope"></i>
              <div class="label">Solicitations</div>
              <div class="count">6</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Lupon 13"
              tabindex="0">
              <i class="bi bi-hourglass-split"></i>
              <div class="label">Lupon</div>
              <div class="count">13</div>
            </div>
            <div
              class="issuance-tile"
              role="listitem"
              aria-label="Others"
              tabindex="0">
              <i class="bi bi-plus-lg"></i>
              <div class="count">&nbsp;</div>
              <div class="label">Others</div>
            </div>
          </div>
        </section>

        <section
          class="right-column"
          aria-label="Barangay calendar, timeline and event actions">
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

          <article
            class="timeline"
            aria-label="Timeline of barangay events"
            tabindex="0"
            id="timeline-events"
          >
            <p>
              <strong>Barangay Clean-Up Drive</strong> – Coastal & Riverside
              Areas<br /><em>(7:00 AM – 11:00 AM) OCTOBER 3, 2025</em>
            </p>
            <p>
              <strong>Barangay Health Check-Up</strong> – Covered Court<br /><em
                >(Free BP check, Blood Sugar Testing) OCTOBER 6, 2025</em
              >
            </p>
            <p>
              <strong>Senior Citizens’ General Assembly</strong> – Barangay Hall<br
              /><em>(1:00 PM – 4:00 PM) OCTOBER 9, 2025</em>
            </p>
            <p>
              <strong>Youth Sports League Opening</strong> – Gusa Covered Court
              (Basketball & Volleyball)<br /><em>OCTOBER 12, 2025</em>
            </p>
            <p>
              <strong>PWD Assistance Payout</strong> – Barangay Hall<br /><em
                >(10:00 AM – 3:00 PM) OCTOBER 21, 2025</em
              >
            </p>
            <p>
              <strong>Tree Planting Activity</strong> – Near Coastal Highway Area<br
              /><em>(6:00 AM – 10:00 AM) OCTOBER 24, 2025</em>
            </p>
            <p>
              <strong>Barangay Halloween Kids’ Party</strong> – Covered Court<br
              /><em>(3:00 PM – 6:00 PM) OCTOBER 31, 2025</em>
            </p>
          </article>

          <nav class="action-buttons" role="region" aria-label="Event actions">
            <button type="button" aria-label="Add event">
              <i class="bi bi-plus-lg"></i> ADD EVENT
            </button>
            <button type="button" aria-label="Edit event">
              <i class="bi bi-pencil-square"></i> EDIT EVENT
            </button>
            <button type="button" aria-label="Delete event">
              <i class="bi bi-trash"></i> DELETE EVENT
            </button>
          </nav>
        </section>
      </section>
    </main>
  </div>
<script src="../../assets/js/calendar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}
document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        this.parentElement.classList.toggle('active');
    });
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
