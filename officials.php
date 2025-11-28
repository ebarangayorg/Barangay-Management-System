<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Officials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/img/BMS.png">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php include 'includes/nav.php'; ?>

<section class="header-banner" style="display: flex; align-items: center; justify-content: center;">
    <div class="overlay" style="display: flex; align-items: center; gap: 20px;">
        <h1>Barangay</h1> 
        <h3>Officials</h3>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4">Elected <span class="text-success">Officials</span></h3>
        <div class="row g-4" id="officialsContainer">
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
fetch('backend/officials_get.php')
.then(res => res.json())
.then(data => {
    const container = document.getElementById('officialsContainer');
    container.innerHTML = '';

    if(data.length === 0){
        container.innerHTML = '<p class="text-center">No officials found.</p>';
        return;
    }

    data.forEach(official => {
        container.innerHTML += `
        <div class="col-md-4">
            <div class="card announcement-card p-3 text-center">
                <img src="assets/officials/${official.image}" style="width:100%; height:auto; border-radius:5px;">
                <div>
                    <h6 class="mt-2 fw-bold">${official.name}</h6>
                    <p class="mt-2" style="font-size:1px">${official.position}</p>
                </div>
            </div>
        </div>
        `;
    });
});
</script>
</body>
</html>