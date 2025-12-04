<<<<<<< Updated upstream
<?php
require_once '../../backend/auth_resident.php';
require_once '../../backend/config.php';

$email = $_SESSION['email'];
$user = $usersCollection->findOne(['email' => $email]);

if (!$user) {
    die("Error: User not found.");
}

$resident = $residentsCollection->findOne(['user_id' => $user['_id']]);

if (!$resident) {
    die("Error: Resident record not found.");
}

$userId = (string)$user['_id'];
$residentId = isset($resident['_id']) ? (string)$resident['_id'] : null;
=======
<?php 
require_once '../../backend/auth_resident.php'; 
require '../../backend/config.php'; // MongoDB connection
>>>>>>> Stashed changes
?>

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
        <?php
            $profileImg = isset($resident['profile_image']) && $resident['profile_image'] !== ""
              ? "../../uploads/residents/" . $resident['profile_image']
              : "../../assets/img/profile.jpg";
            ?>
            <img src="<?= $profileImg ?>" alt="">

        <div>
<<<<<<< Updated upstream
            <h3><?= $resident['first_name'] . " " . $resident['last_name'] ?></h3>
            <small><?= $resident['email'] ?></small>
=======
            <h3><?= $_SESSION['fullname'] ?? 'Resident' ?></h3>
            <small><?= $_SESSION['email'] ?? '' ?></small>
>>>>>>> Stashed changes
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="resident_dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="resident_rqs_services.php" class="active"><i class="bi bi-newspaper"></i> Request Service</a>
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

    <div class="search-box mb-3">
        <input type="text" id="searchInput" placeholder="Search for Document Type..." class="form-control">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Document Type</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="requestTable">
            </tbody>
    </table>
</div>

<div class="modal fade" id="requestModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="border-radius: 12px; overflow:hidden;">

      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">Submit New Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="requestForm">
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

<div class="modal fade" id="viewUpdateModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content" style="border-radius: 12px; overflow:hidden;">

      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="viewUpdateTitle">Request Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="updateForm">
        <div class="modal-body px-4">
          <input type="hidden" id="updateRequestId" name="id">
          
          <p><strong>Full Name:</strong> <?= $_SESSION['fullname'] ?? 'Resident' ?></p>
          <p><strong>Document Type:</strong> <span id="updateDocType"></span></p>
          <p><strong>Status:</strong> <span id="updateStatus"></span></p>

          <label class="form-label mt-3 fw-semibold">Purpose of Request:</label>
          <textarea class="form-control" name="purpose" id="updatePurpose" rows="3" required></textarea>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="updateSubmitBtn" class="btn btn-primary">Edit Purpose</button>
        </div>

      </form>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}

// =======================================================
// 1. EDIT (View/Update) FUNCTIONALITY
// =======================================================

function openEditModal(id, docType, encodedPurpose, status, isViewOnly = false) {
    // Decode the purpose safely before displaying
    const purpose = decodeURIComponent(encodedPurpose);

    // Populate the modal fields
    document.getElementById('viewUpdateTitle').innerText = isViewOnly ? 'View Request Details' : (status === 'Pending' ? 'Edit Request' : 'View Request');
    document.getElementById('updateRequestId').value = id;
    document.getElementById('updateDocType').innerText = docType;
    document.getElementById('updateStatus').innerText = status;
    document.getElementById('updatePurpose').value = purpose;

    // Control visibility and editability: 
    const isPending = status.trim().toLowerCase() === 'pending';
    const isEditable = isPending && !isViewOnly;
    
    document.getElementById('updatePurpose').disabled = !isEditable;
    
    // Set button text and visibility
    const submitBtn = document.getElementById('updateSubmitBtn');
    submitBtn.innerText = 'Edit Purpose'; 
    submitBtn.style.display = isEditable ? 'inline-block' : 'none';

    new bootstrap.Modal(document.getElementById('viewUpdateModal')).show();
}

document.getElementById('updateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('updateRequestId').value;
    const newPurpose = document.getElementById('updatePurpose').value;
    
    // Prevent submission if in View-Only Mode or status is not Pending
    if (document.getElementById('updatePurpose').disabled) {
        alert('This request cannot be edited.');
        return; 
    }

    // FETCH CALL to the issuance_edit.php script
    fetch("../../backend/issuance_edit.php", { 
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ id: id, purpose: newPurpose })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            new bootstrap.Modal(document.getElementById('viewUpdateModal')).hide();
            loadRequests(); // Reload the table
        }
    })
    .catch(error => {
        console.error('Edit Error:', error);
        alert('An error occurred during edit.');
    });
});


// =======================================================
// 2. DELETE (Cancel) FUNCTIONALITY
// =======================================================

function deleteRequest(id) {
    if (!confirm('Are you sure you want to cancel (delete) this request? This action cannot be undone.')) {
        return;
    }

    fetch("../../backend/issuance_delete.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            loadRequests(); // Reload the table
        }
    })
    .catch(error => {
        console.error('Deletion Error:', error);
        alert('An error occurred during deletion.');
    });
}


// =======================================================
// 3. SUBMISSION AND LOADING 
// =======================================================

// Open Request Modal (Existing code)
document.querySelectorAll('.openRequestModal').forEach(btn => {
    btn.addEventListener('click', function () {
        const docType = this.dataset.doc;
        document.getElementById('docType').value = docType;
        document.getElementById('docPreview').innerText = docType;
        new bootstrap.Modal(document.getElementById('requestModal')).show();
    });
});

// Submit Request (Refined code)
document.getElementById('requestForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = {
        // This is where the name is pulled from session and saved to the issuance record
        resident_name: "<?= trim($_SESSION['fullname'] ?? 'Resident') ?>",
        resident_email: "<?= trim($_SESSION['email'] ?? '') ?>",
        document_type: document.getElementById('docType').value,
        purpose: this.purpose.value
    };

    fetch("../../backend/issuance_request.php", {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify(formData)
    })
    .then(res=>res.json())
    .then(data=>{
        alert(data.message);
        if(data.status === "success"){
            new bootstrap.Modal(document.getElementById('requestModal')).hide();
            loadRequests(); // reload table
        }
    })
    .catch(error => {
        console.error('Submission Error:', error);
        alert('An unexpected error occurred during submission.');
    });
});

// ======================= LOAD RESIDENT REQUESTS (Final Button Logic) =======================
function loadRequests(){
    // issuance_get.php now returns resident_name via lookup
    fetch("../../backend/issuance_get.php")
    .then(res => res.json())
    .then(data => {
        const email = "<?= trim($_SESSION['email'] ?? '') ?>"; 
        let table = "";
        
        // Filter requests to show only the logged-in resident's requests
        data.filter(r => r.resident_email === email).forEach(req => {
            const requestID = req._id.$oid || req._id;
            
            // Normalize status for reliable comparison
            const status = req.status ? req.status.trim() : ''; 
            const normalizedStatus = status.toLowerCase();

            const isPending = normalizedStatus === 'pending';
            // Print is available only if status is 'Ready'
            const isFinished = (normalizedStatus === 'ready'); 
            
            const safePurpose = encodeURIComponent(req.purpose);
            
            // --- 1. VIEW Button (Always first) ---
            let actions = `
                <button class="btn btn-sm btn-info me-1 text-white" 
                    onclick="openEditModal('${requestID}', '${req.document_type}', '${safePurpose}', '${status}', true)">
                    <i class="bi bi-eye"></i> View
                </button>
            `;

            // --- 2. PRINT Button (ONLY appears if Finished/Ready) ---
            if (isFinished) {
                actions += `
                    <a href="../../backend/issuance_print.php?id=${requestID}" target="_blank" class="btn btn-sm btn-success me-1">
                        <i class="bi bi-printer"></i> Print
                    </a>
                `;
            } 

            // --- 3. EDIT/CANCEL Buttons (Active only if Pending) ---
            if (isPending) {
                actions += `
                    <button class="btn btn-sm btn-primary me-1" 
                        onclick="openEditModal('${requestID}', '${req.document_type}', '${safePurpose}', '${status}', false)">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger me-1 text-white" 
                        onclick="deleteRequest('${requestID}')">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                `;
            } else {
                 // Disabled Edit/Cancel for processed requests (Ready, Declined, etc.)
                 actions += `
                    <button class="btn btn-sm btn-secondary me-1" disabled>
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-secondary me-1 text-white" disabled>
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                `;
            }

            table += `
            <tr>
                <td>${req.document_type}</td>
                <td>${req.request_date}</td>
                <td><span class="status ${normalizedStatus}">${status}</span></td>
                <td>${actions}</td>
            </tr>`;
        });
        document.getElementById('requestTable').innerHTML = table;
    })
    .catch(error => {
        console.error('Error loading requests:', error);
        document.getElementById('requestTable').innerHTML = '<tr><td colspan="4" class="text-center">Error loading requests. Check console for details.</td></tr>';
    });
}

loadRequests();
</script>

</body>
</html>