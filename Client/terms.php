<?php
@include '../config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['client_name'])) {
  $client_name = $_SESSION['client_name'];
} else {
  header('location: ../Login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Terms & Conditions - Cancer Care Support</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link href="../img/favicon.ico" rel="icon" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="../lib/animate/animate.min.css" rel="stylesheet" />
  <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
  <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
  <link href="../css/bootstrap.min.css" rel="stylesheet" />
  <link href="../css/style.css" rel="stylesheet" />
</head>

<body>
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" style="width: 3rem; height: 3rem" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <?php include './Topbar.php'; ?>

  <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h1 class="m-0 text-success"><i class="far fa-hospital me-3"></i>CANCER CARE SUPPORT</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div><?php echo 'We are here for you, <span style="color:Green; font-weight:bold;">' . $client_name . '</span> 💪💖✨'; ?></div>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="index.php" class="nav-item nav-link">Home</a>
        <a href="contact.php" class="nav-item nav-link">Contact</a>
      </div>
      <a href="../logout.php" class="btn btn-warning rounded-0 py-4 px-lg-5 d-none d-lg-block">Logout
        <i class="fa fa-arrow-right ms-3"></i>
      </a>
    </div>
  </nav>

  <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
      <h1 class="display-3 text-white mb-3 animated slideInDown">Terms & Conditions</h1>
    </div>
  </div>

  <div class="container-xxl py-5">
    <div class="container">
      <div class="bg-light rounded p-5 shadow">
        <h4 class="text-success">1. Acceptance</h4>
        <p>By using this website, you agree to follow the terms and conditions outlined here.</p>

        <h4 class="text-success mt-4">2. Responsibilities</h4>
        <p>Users must provide accurate and truthful information when accessing any services.</p>

        <h4 class="text-success mt-4">3. Service Availability</h4>
        <p>We strive for continuous service but may pause for maintenance or updates.</p>

        <h4 class="text-success mt-4">4. Privacy</h4>
        <p>Your information is handled according to our <a href="privacy_policy.php" class="text-success">Privacy Policy</a>.</p>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>

