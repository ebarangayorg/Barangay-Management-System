<?php require_once '../../backend/auth_admin.php'; ?>
<?php
require_once "../../backend/config.php";

$searchQuery = $_GET["search"] ?? "";

/* ALWAYS HIDE ARCHIVED RECORDS */
$filter = ["status" => ['$ne' => "archived"]];

if (!empty($searchQuery)) {
    $filter['$or'] = [
        ["respondent" => ['$regex' => $searchQuery, '$options' => 'i']],
        ["complainant" => ['$regex' => $searchQuery, '$options' => 'i']],
        ["subject" => ['$regex' => $searchQuery, '$options' => 'i']],
        ["case_no" => ['$regex' => $searchQuery, '$options' => 'i']],
    ];
}

$incidents = $incidentsCollection->find($filter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Admin Records Blotter</title>
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
              <a href="admin_rec_complaints.php">Complaints</a>
              <a href="admin_rec_blotter.php" class="active">Blotter</a>
          </div>
      </div>

        <a href="../../backend/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>

<div style="width:100%">

    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title">RECORD <span class="green">BLOTTER</span></h1>

        <div class="header-logos">
            <img src="../../assets/img/barangaygusalogo.png">
            <img src="../../assets/img/cdologo.png">
        </div>
    </div>

    <div class="content">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

            <!-- Search Bar -->
            <form method="GET" class="search-box d-flex">
                <input type="text" name="search" class="form-control" 
                    placeholder="Search for Case No., Respondent, Complainant..."
                    value="<?= htmlspecialchars($searchQuery) ?>">
                <button class="search-btn"><i class="bi bi-search"></i></button>
            </form>



            <div class="mt-2 mt-md-0">
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-circle"></i> Add New
                </button>
                <a href="admin_rec_blotter_archive.php" class="btn btn-secondary">
                    <i class="bi bi-archive"></i> Archive
                </a>
            </div>

        </div>

        <table>
            <tr>
                <th>Case No.</th>
                <th>Respondent</th>
                <th>Complainant</th>
                <th>Date Filed</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php foreach ($incidents as $incident): ?>
                <tr>
                    <td><?= $incident->case_no ?></td>
                    <td><?= $incident->respondent ?></td>
                    <td><?= $incident->complainant ?></td>
                    <td>
                        <?= !empty($incident->date_filed) 
                            ? date("m/d/Y", strtotime($incident->date_filed)) 
                            : "—" ?>
                    </td>

                    <td><?= $incident->subject ?></td>
                    <td>
                        <span class="status <?= strtolower($incident->status) ?>">
                            <?= ucfirst($incident->status) ?>
                        </span>
                    </td>
                    <td>

                        <!-- VIEW -->
                        <button class="btn btn-sm btn-info me-1 text-white"
                                onclick='openViewModal(<?= json_encode($incident) ?>)'>
                            <i class="bi bi-eye"></i>
                        </button>

                        <!-- EDIT -->
                        <button class="btn btn-sm btn-primary me-1"
                                onclick='openEditModal(<?= json_encode($incident) ?>)'>
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <!-- ARCHIVE -->
                        <button class="btn btn-sm btn-warning me-1 text-white"
                                onclick="openArchiveModal('<?= $incident->_id ?>')">
                            <i class="bi bi-archive"></i>
                        </button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

</div>

<!-- ========== VIEW MODAL ========== -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
        <h4>Blotter Details</h4>

        <p><b>Case No:</b> <span id="v_case"></span></p>
        <p><b>Respondent:</b> <span id="v_res"></span></p>
        <p><b>Complainant:</b> <span id="v_comp"></span></p>
        <p><b>Date Filed:</b> <span id="v_date"></span></p>
        <p><b>Subject:</b> <span id="v_subject"></span></p>
        <p><b>Description:</b></p>
        <p id="v_desc" class="border p-2"></p>

        <button class="btn btn-secondary mt-2" data-bs-dismiss="modal">Close</button>
    </div>
  </div>
</div>

<!-- ========== ADD MODAL ========== -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
      <h4>Add New Blotter</h4>

      <form action="../../backend/blotter_add.php" method="POST">

        <div class="row">
          <div class="col-md-6">
            <label>Case No.</label>
            <input type="text" name="case_no" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label>Date Filed</label>
            <input type="date" name="date_filed" class="form-control" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <label>Complainant</label>
            <input type="text" name="complainant" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label>Respondent</label>
            <input type="text" name="respondent" class="form-control" required>
          </div>
        </div>

        <div class="mt-3">
          <label>Subject</label>
          <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mt-3">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mt-3 text-end">
          <button class="btn btn-success" type="submit">Save</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ========== EDIT MODAL ========== -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
      <h4>Edit Blotter Record</h4>

      <form action="../../backend/blotter_update.php" method="POST">

        <input type="hidden" name="blotter_id" id="e_id">

        <div class="row">
          <div class="col-md-6">
            <label>Case No.</label>
            <input type="text" name="case_no" id="e_case" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label>Date Filed</label>
            <input type="date" name="date_filed" id="e_date" class="form-control" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <label>Complainant</label>
            <input type="text" name="complainant" id="e_comp" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label>Respondent</label>
            <input type="text" name="respondent" id="e_res" class="form-control" required>
          </div>
        </div>

        <div class="mt-3">
          <label>Subject</label>
          <input type="text" name="subject" id="e_subject" class="form-control" required>
        </div>

        <div class="mt-3">
          <label>Description</label>
          <textarea name="description" id="e_desc" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mt-3">
          <label>Status</label>
          <select name="status" id="e_status" class="form-select">
            <option value="active">Active</option>
            <option value="settled">Settled</option>
          </select>
        </div>

        <div class="mt-3 text-end">
          <button class="btn btn-success" type="submit">Save Changes</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ========== ARCHIVE MODAL ========== -->
<div class="modal fade" id="archiveModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <h4>Archive Record</h4>
      <p>Are you sure you want to archive this blotter record?</p>

      <form action="../../backend/blotter_update.php" method="POST">
        <input type="hidden" name="blotter_id" id="archive_id">
        <input type="hidden" name="status" value="archived">
        <button type="submit" class="btn btn-warning">Yes, Archive</button>
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
    document.getElementById('v_case').textContent = data.case_no;
    document.getElementById('v_res').textContent = data.respondent;
    document.getElementById('v_comp').textContent = data.complainant;
    document.getElementById('v_date').textContent = data.date_filed;
    document.getElementById('v_subject').textContent = data.subject;
    document.getElementById('v_desc').textContent = data.description;

    new bootstrap.Modal(document.getElementById('viewModal')).show();
}

function openEditModal(data) {

    document.getElementById('e_id').value = data._id.$oid;

    document.getElementById('e_case').value = data.case_no;
    document.getElementById('e_date').value = data.date_filed;
    document.getElementById('e_comp').value = data.complainant;
    document.getElementById('e_res').value = data.respondent;
    document.getElementById('e_subject').value = data.subject;
    document.getElementById('e_desc').value = data.description;
    document.getElementById('e_status').value = data.status;

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

function openArchiveModal(data) {

    document.getElementById('archive_id').value = data.$oid ?? data;
    new bootstrap.Modal(document.getElementById('archiveModal')).show();
}

</script>

</body>
</html>
