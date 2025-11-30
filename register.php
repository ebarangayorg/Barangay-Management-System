<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>BMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/img/BMS.png">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/toast.css">
</head>
<body>

<?php include 'includes/nav.php'; ?>

  <section class="header-banner">
    <img src="assets/img/cdologo.png" class="left-logo" alt="left logo">
    <div class="header-text">
        <h1>Resident</h1> 
        <h3>Registration</h3>
    </div>
    <img src="assets/img/barangaygusalogo.png" class="right-logo" alt="right logo">
</section>

  <section class="registration-form">
    <h2>FILL OUT THE REGISTRATION FORM</h2>
    <form action="backend/register_resident.php" method="POST">
      
      <div class="form-row">
        <input type="text" name="fname" placeholder="First Name" required>
        <input type="text" name="mname" placeholder="Middle Name">
        <input type="text" name="lname" placeholder="Last Name" required>
        <input type="text" name="sname" placeholder="Suffix Name">
      </div>

      <div class="form-row">
        <select name="gender" required>
          <option value="">Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>

        <input type="date" name="bdate" placeholder="Birth Date" required>
        <input type="text" name="bplace" placeholder="Birth Place" required>
      </div>

      <div class="form-row">
        <input type="text" name="occupation" placeholder="Occupation">
        <select name="voter" required>
          <option value="">Active Voter</option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
        <select name="purok" required>
          <option value="">Select Purok</option>
          <option value="Purok 1">Purok 1</option>
          <option value="Purok 2">Purok 2</option>
          <option value="Purok 3">Purok 3</option>
        </select>
        <input type="text" name="resident_since" placeholder="Resident Since">
      </div>

      <div class="form-row">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <div class="form-row">
        <select name="income" required>
          <option value="">Family Income</option>
          <option value="Below PHP 10,000">Below PHP 10,000</option>
          <option value="PHP 10,000 - 20,000">PHP 10,000 - 20,000</option>
          <option value="PHP 20,000+">PHP 20,000+</option>
        </select>
        <select name="family_head" required>
          <option value="">Family Head</option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
      </div>

      <p class="note">Please be informed that your registration to Barangay Gusa portal will be reviewed. We will notify you via email regarding your account status.</p>

      <button type="submit">REGISTER NOW</button>
    </form>
    <p style="text-align:center; margin-top:20px;">
      <a href="resident_login.php">Back to Login</a>
    </p>
  </section>

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>

<div id="toast" class="toast"></div>

<script>
function showToast(message, type = "error") {
    const t = document.getElementById("toast");

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
