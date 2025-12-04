<?php 
// Path to auth_admin.php is correct: ../../backend/auth_admin.php
require_once '../../backend/auth_admin.php'; 
?>

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
    <style>
        /* Basic status styling if not defined in dashboard.css */
        .status {
            display: inline-block;
            padding: 0.25em 0.5em;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.75em;
            color: white;
        }
        /* Status classes for consistency */
        .status.pending { background-color: #ffc107; color: #333; }
        .status.approved { background-color: #198754; }
        .status.rejected { background-color: #dc3545; }
        .status.readyforpickup { background-color: #0d6efd; }
    </style>
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

<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="main-content-wrapper" style="width:100%"> 
    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title"><span class="green">ISSUANCE</span></h1>

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
                    <th>Resident Name</th>
                    <th>Document Type</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="issuanceTable">
                <tr><td colspan="5" class="text-center">Loading requests...</td></tr>
            </tbody>
        </table>
    </div>

</div>

<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModalLabel">Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                </div>
            <div class="modal-footer" id="modalFooterButtons">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ======================= SIDEBAR/DROPDOWN LOGIC =======================
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.sidebar-overlay').classList.toggle('active'); 
}

document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        this.parentElement.classList.toggle('active');
    });
});

// ======================= SEARCH FUNCTIONALITY =======================
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('#issuanceTable tr');
    rows.forEach(row => {
        // Handle case where row might be the "No requests found" message
        if (row.cells.length < 5) return; 

        const documentType = row.cells[1]?.textContent.toLowerCase() || '';
        const residentName = row.cells[0]?.textContent.toLowerCase() || '';
        if (documentType.includes(query) || residentName.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// ======================= FUNCTIONALITY FOR BUTTONS (FIXED PATHS) =======================

// Define the base path for absolute fetching
const BASE_PATH = "/Barangay-Management-System/backend/";


/**
 * Loads the issuance requests from the backend and renders the table.
 */
function loadIssuances(){
    fetch(BASE_PATH + "admin_issuance_get.php") 
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        let table = "";
        if (Array.isArray(data) && data.length > 0) {
            
            data.forEach(req => {
                // Ensure req.id exists, which is the string representation of MongoDB _id
                if (!req.id) return;
                
                const status = req.status ? req.status.trim() : 'Pending'; 
                const normalizedStatus = status.toLowerCase().replace(/\s/g, ''); 
    
                table += `<tr>
                    <td>${req.resident_name || 'N/A'}</td>
                    <td>${req.document_type || 'N/A'}</td>
                    <td>${req.request_date || 'N/A'}</td>
                    <td><span class="status ${normalizedStatus}">${status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info me-1 text-white" title="View Details" onclick="viewRequest('${req.id}')"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-primary me-1" title="Update Status/Edit" onclick="showEditModal('${req.id}')"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger" title="Delete Request" onclick="deleteRequest('${req.id}')"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>`;
            });
            document.getElementById("issuanceTable").innerHTML = table;
        } else {
            document.getElementById("issuanceTable").innerHTML = '<tr><td colspan="5" class="text-center">No issuance requests found.</td></tr>';
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        document.getElementById("issuanceTable").innerHTML = `<tr><td colspan="5" class="text-center">Failed to load data. Check backend or network. (${error.message})</td></tr>`;
    });
}

/**
 * 1. VIEW Button: Fetches detailed data for a single request and displays it in a modal.
 */
function viewRequest(id) {
    fetch(`${BASE_PATH}admin_issuance_get_single.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
                return;
            }

            const statusClass = (data.status || 'pending').toLowerCase().replace(/\s/g, '');
            document.getElementById('requestModalLabel').innerText = `Request Details: ${data.document_type}`;
            document.getElementById('modalBodyContent').innerHTML = `
                <p><strong>Resident Name:</strong> ${data.resident_name || 'N/A'}</p>
                <p><strong>Document Type:</strong> ${data.document_type || 'N/A'}</p>
                <p><strong>Request Date:</strong> ${data.request_date || 'N/A'}</p>
                <p><strong>Purpose:</strong> ${data.purpose || 'N/A'}</p>
                <p><strong>Status:</strong> <span class="status ${statusClass}">${data.status || 'Pending'}</span></p>
                <hr>
                <p class="text-muted small">Request ID: ${data.id}</p>
            `;
            document.getElementById('modalFooterButtons').innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';

            const modal = new bootstrap.Modal(document.getElementById('requestModal'));
            modal.show();
        })
        .catch(error => console.error('View Request Error:', error));
}


/**
 * 2. EDIT Button (Part 1): Prepares the modal to allow status editing.
 */
function showEditModal(id) {
    fetch(`${BASE_PATH}admin_issuance_get_single.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
                return;
            }

            const currentStatus = data.status ? data.status.trim() : 'Pending';
            const statusOptions = ['Pending', 'Approved', 'Ready for Pickup', 'Rejected'];
            let optionsHtml = statusOptions.map(s => 
                `<option value="${s}" ${s === currentStatus ? 'selected' : ''}>${s}</option>`
            ).join('');
            
            document.getElementById('requestModalLabel').innerText = `Edit Status for: ${data.document_type}`;
            document.getElementById('modalBodyContent').innerHTML = `
                <p><strong>Resident Name:</strong> ${data.resident_name}</p>
                <p><strong>Current Status:</strong> ${currentStatus}</p>
                <div class="mb-3">
                    <label for="statusSelect" class="form-label">Update Status</label>
                    <select id="statusSelect" class="form-select">
                        ${optionsHtml}
                    </select>
                </div>
            `;
            document.getElementById('modalFooterButtons').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="updateStatus('${data.id}', document.getElementById('statusSelect').value)">Save Changes</button>
            `;

            const modal = new bootstrap.Modal(document.getElementById('requestModal'));
            modal.show();
        })
        .catch(error => console.error('Show Edit Modal Error:', error));
}


/**
 * 2. EDIT Button (Part 2): Sends the status update to the backend.
 */
function updateStatus(id, newStatus){
    if(!confirm(`Are you sure you want to change the status to '${newStatus}'?`)) return;

    fetch(BASE_PATH + "admin_issuance_update.php", { 
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({id: id, status: newStatus})
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status === "success") {
            const modal = bootstrap.Modal.getInstance(document.getElementById('requestModal'));
            if(modal) modal.hide(); 
            loadIssuances(); 
        }
    })
    .catch(error => {
        console.error('Status Update Error:', error);
        alert('An error occurred during status update. Check console.');
    });
}


/**
 * 3. DELETE Button: Deletes the request after confirmation.
 */
function deleteRequest(id) {
    if(!confirm('WARNING: Are you sure you want to delete this request permanently? This cannot be undone.')) {
        return;
    }

    fetch(BASE_PATH + "admin_issuance_delete.php", { 
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({id: id})
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status === "success") {
            loadIssuances(); 
        }
    })
    .catch(error => {
        console.error('Delete Request Error:', error);
        alert('Failed to delete request. Check network/backend.');
    });
}


// Initial data load when the page is ready
loadIssuances();
</script>

</body>
</html>