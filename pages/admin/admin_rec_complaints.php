<?php require_once '../../backend/auth_admin.php'; ?>
<?php
require_once '../../backend/config.php';

$complaints = $contactsCollection->find([], ['sort' => ['date' => -1]]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Admin Records Complaint</title>
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
            <div class="dept">IT Department</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="admin_dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
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
                <a href="admin_rec_complaints.php" class="active">Complaints</a>
                <a href="admin_rec_blotter.php">Blotter</a>
            </div>
        </div>
        <a href="../../backend/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>

<div style="width:100%">
    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title">RECORD <span class="green">COMPLAINT</span></h1>

        <div class="header-logos">
            <img src="../../assets/img/barangaygusalogo.png">
            <img src="../../assets/img/cdologo.png">
        </div>
    </div>

    <div class="content">

        <div class="search-box">
            <input type="text" id="search-input" placeholder="Search for Subject...">
            <button id="search-btn"><i class="bi bi-search"></i></button>
        </div>

        <table id="complaintTable">
            <tr>
                <th>Respondent Name</th>
                <th>Subject</th>
                <th>Details</th>
                <th>Date Filled</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

            <?php foreach ($complaints as $c): 
                $id = (string)$c['_id'];
                $shortMessage = strlen($c['message']) > 30 ? substr($c['message'], 0, 30) . "..." : $c['message'];
            ?>
            <tr>
                <td><?= htmlspecialchars($c['fullname']) ?></td>
                <td class="subject"><?= htmlspecialchars($c['subject']) ?></td>

                <td><?= htmlspecialchars($shortMessage) ?></td>

                <td><?= $c['date']->toDateTime()->format('Y-m-d H:i'); ?></td>

                <td><?= htmlspecialchars($c['email']) ?></td>

                <td>
                    <button class="btn btn-sm btn-info text-white" 
                            onclick='openViewModal(<?= json_encode($c) ?>)'>
                        <i class="bi bi-eye"></i>
                    </button>

                    <button class="btn btn-sm btn-danger" 
                            onclick='openDeleteModal("<?= $id ?>")'>
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- ======================== VIEW MODAL ======================== -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
        <h4>Complaint Details</h4>
        <p><b>Name:</b> <span id="v_name"></span></p>
        <p><b>Email:</b> <span id="v_email"></span></p>
        <p><b>Subject:</b> <span id="v_subject"></span></p>
        <p><b>Message:</b></p>
        <p id="v_message" class="border p-2"></p>
        <button class="btn btn-secondary mt-2" data-bs-dismiss="modal">Close</button>
    </div>
  </div>
</div>

<!-- ======================== DELETE MODAL ======================== -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
        <h4>Delete Complaint</h4>
        <p>Are you sure you want to delete this record?</p>

        <form action="../../backend/complaint_delete.php" method="POST">
            <input type="hidden" name="complaint_id" id="d_id">
            <button class="btn btn-danger" type="submit">Delete</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

document.querySelectorAll('.dropdown-container').forEach(container => {
    if (container.querySelector('.dropdown-content a.active')) {
        container.classList.add('active');
    }
});

document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        this.parentElement.classList.toggle('active');
    });
});

function openViewModal(data) {
    document.getElementById('v_name').textContent = data.fullname;
    document.getElementById('v_email').textContent = data.email;
    document.getElementById('v_subject').textContent = data.subject;
    document.getElementById('v_message').textContent = data.message;

    new bootstrap.Modal(document.getElementById('viewModal')).show();
}

function openDeleteModal(id) {
    document.getElementById('d_id').value = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById("search-input").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#complaintTable tr");

    rows.forEach((row, index) => {
        if (index === 0) return; // skip header

        let subject = row.querySelector(".subject").textContent.toLowerCase();
        row.style.display = subject.includes(filter) ? "" : "none";
    });
});

</script>

</body>
</html>
