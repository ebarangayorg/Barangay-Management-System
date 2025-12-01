<?php require_once '../../backend/auth_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Admin Issuance</title>
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
        <a href="admin_dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="admin_announcement.php"><i class="bi bi-megaphone"></i> Announcement</a>
        <a href="admin_officials.php"><i class="bi bi-people"></i> Officials</a>
        <a href="admin_issuance.php" class="active"><i class="bi bi-bookmark"></i> Issuance</a>

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
        <h1 class="header-title"><span class="green">ISSUANCE</span></h1>

        <div class="header-logos">
            <img src="../../assets/img/barangaygusalogo.png">
            <img src="../../assets/img/cdologo.png">
        </div>
    </div>

    <div class="content">
        <div class="search-box">
        <input type="text" placeholder="Search for Document Type...">
        <button><i class="bi bi-search"></i></button>
    </div>

    <!-- TABLE -->
    <table>
        <tr>
            <th>Resident Name</th>
            <th>Document Type</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <tr>
            <td>Resident 1</td>
            <td>Barangay Clearance</td>
            <td>08/02/2025</td>
            <td><span class="status pending">Pending</span></td>
            <td>
                <button class="btn btn-sm btn-info me-1 text-white"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>

        <tr>
            <td>Resident 2</td>
            <td>Certificate of Indigency</td>
            <td>08/02/2025</td>
            <td><span class="status ready">Ready to Pick Up</span></td>
            <td>
                <button class="btn btn-sm btn-info me-1 text-white"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>

        <tr>
            <td>Resident 3</td>
            <td>Certificate of Residency</td>
            <td>08/04/2025</td>
            <td><span class="status decline">Decline</span></td>
            <td>
                <button class="btn btn-sm btn-info me-1 text-white"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>

        <tr>
            <td>Resident 4</td>
            <td>Certificate of Residency</td>
            <td>08/06/2025</td>
            <td><span class="status ready">Ready to Pick Up</span></td>
            <td>
                <button class="btn btn-sm btn-info me-1 text-white"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    </table>
    </div>

</div>
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

</body>
</html>