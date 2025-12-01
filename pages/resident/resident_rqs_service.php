<?php require_once '../../backend/auth_resident.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Request Service</title>
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
            <h3>Lorebina C. Carrasco II</h3>
            <small>carrasco.lorebina85@gmail.com</small>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="resident_dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="resident_rqs_service.php" class="active"><i class="bi bi-newspaper"></i> Request Service</a>
        <a href="../../index.php"><i class="bi bi-arrow-down-left"></i> Return to Homepage</a>
    </div>

    <div class="sidebar-bottom">
        <a href="../../backend/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>

<div style="width:100%">

    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title">REQUEST <span class="green">SERVICE</span></h1>

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

    <table class="table table-bordered">
        <tr>
            <th>Document Type</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <tr>
            <td>Barangay Clearance</td>
            <td>08/02/2025</td>
            <td><span class="status pending">Pending</span></td>
            <td>

                <!-- VIEW -->
                <button class="btn btn-sm btn-info me-1 text-white"
                        onclick="openViewModal('Barangay Clearance')">
                    <i class="bi bi-eye"></i>
                </button>

                <!-- EDIT -->
                <button class="btn btn-sm btn-primary me-1"
                        onclick="openEditModal('Barangay Clearance')">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <!-- CANCEL -->
                <button class="btn btn-sm btn-danger me-1 text-white"
                        onclick="openCancelModal(1)">
                    <i class="bi bi-x-circle"></i>
                </button>

            </td>
        </tr>

        <tr>
            <td>Certificate of Indigency</td>
            <td>08/02/2025</td>
            <td><span class="status ready">Ready to Pick Up</span></td>
            <td>

                <button class="btn btn-sm btn-info me-1 text-white"
                        onclick="openViewModal('Certificate of Indigency')">
                    <i class="bi bi-eye"></i>
                </button>

                <button class="btn btn-sm btn-primary me-1"
                        onclick="openEditModal('Certificate of Indigency')">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <button class="btn btn-sm btn-danger me-1 text-white"
                        onclick="openCancelModal(2)">
                    <i class="bi bi-x-circle"></i>
                </button>

            </td>
        </tr>

        <tr>
            <td>Certificate of Residency</td>
            <td>08/04/2025</td>
            <td><span class="status decline">Decline</span></td>
            <td>

                <button class="btn btn-sm btn-info me-1 text-white"
                        onclick="openViewModal('Certificate of Residency')">
                    <i class="bi bi-eye"></i>
                </button>

                <button class="btn btn-sm btn-primary me-1"
                        onclick="openEditModal('Certificate of Residency')">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <button class="btn btn-sm btn-danger me-1 text-white"
                        onclick="openCancelModal(3)">
                    <i class="bi bi-x-circle"></i>
                </button>

            </td>
        </tr>

    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

function openViewModal(data) {
    alert("VIEW REQUEST: " + data);
}

function openEditModal(data) {
    alert("EDIT REQUEST: " + data);
}

function openCancelModal(id) {
    if (confirm("Are you sure you want to cancel this request?")) {
        alert("CANCELLED REQUEST ID: " + id);
    }
}
</script>

</body>
</html>
