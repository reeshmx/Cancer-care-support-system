<?php
@include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $nic = $_POST['nic'];
    $phoneno = $_POST['phoneno'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $created_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO query (name, email, nic, phoneno, subject, message, created_at)
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssssss", $name, $email, $nic, $phoneno, $subject, $message, $created_at);
        if ($stmt->execute()) {
            echo "<script>alert('Your message has been sent successfully!');</script>";
        } else {
            echo "<script>alert('Error sending message: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }
}

// Check if the user is logged in and if the user type is client_name
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['client_name'])) {
  $client_name = $_SESSION['client_name'];
} else {
  // Redirect to the login page if not logged in as client_name
  header('location: ../Login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Cancer care</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Favicon -->
  <link href="../img/favicon.ico" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap"
    rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
    rel="stylesheet" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="../lib/animate/animate.min.css" rel="stylesheet" />
  <link
    href="../lib/owlcarousel/assets/owl.carousel.min.css"
    rel="stylesheet" />
  <link
    href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
    rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="../css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="../css/style.css" rel="stylesheet" />
</head>

<body>
  <!-- Spinner Start -->
  <div
    id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div
      class="spinner-grow text-success"
      style="width: 3rem; height: 3rem"
      role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->

  <!-- Topbar Start -->
  <?php
  include './Topbar.php'
  ?>
  <!-- Topbar End -->

  <!-- Navbar Start -->
  <nav
    class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn"
    data-wow-delay="0.1s">
    <a
      href="index.php"
      class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h1 class="m-0 text-success">
        <i class="far fa-hospital me-3"></i>CANCER CARE SUPPORT
      </h1>
    </a>
    <button
      type="button"
      class="navbar-toggler me-4"
      data-bs-toggle="collapse"
      data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div><?php echo 'We are here for you, <span style="color:Green; font-weight:bold;">' . $client_name . '</span> 💪💖✨'; ?></div>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="index.php" class="nav-item nav-link active">Home</a>
        <div class="nav-item dropdown">
          <a
            href="service.html"
            class="nav-link dropdown-toggle"
            data-bs-toggle="dropdown">services</a>
          <div class="dropdown-menu rounded-0 rounded-bottom m-0">
            <a href="Medications.php" class="dropdown-item">Medications</a>
            <a href="DoctorConsultation.php" class="dropdown-item">Doctor Consultation</a>
            <a href="HomeVisit.php" class="dropdown-item">Home Visit</a>
            <a href="LoanService.php" class="dropdown-item">Loan Service</a>
            <a href="Programs.php" class="dropdown-item">Programs</a>
            <a href="404.html" class="dropdown-item"></a>
          </div>
        </div>

        <a href="contact.php" class="nav-item nav-link">Contact</a>
      </div>

      <a
        href="../logout.php"
        class="btn btn-warning rounded-0 py-4 px-lg-5 d-none d-lg-block">Logout
        <i class="fa fa-arrow-right ms-3"></i>
      </a>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Page Header Start -->
  <div
    class="container-fluid page-header py-5 mb-5 wow fadeIn"
    data-wow-delay="0.1s">
    <div class="container py-5">
      <h1 class="display-3 text-white mb-3 animated slideInDown">
        Contact Us
      </h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb text-uppercase mb-0">
          <li class="breadcrumb-item">
            <a class="text-white" href="index.php">Home</a>
          </li>

          <li class="breadcrumb-item text-success active" aria-current="page">
            Contact
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->

  <!-- Contact Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="h-100 bg-light rounded d-flex align-items-center p-5">
            <div
              class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white"
              style="width: 55px; height: 55px">
              <i class="fa fa-map-marker-alt text-success"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Address</p>
              <h5 class="mb-0">147/A Colombo</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="h-100 bg-light rounded d-flex align-items-center p-5">
            <div
              class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white"
              style="width: 55px; height: 55px">
              <i class="fa fa-phone-alt text-success"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Call Us Now</p>
              <h5 class="mb-0">7715</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="h-100 bg-light rounded d-flex align-items-center p-5">
            <div
              class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white"
              style="width: 55px; height: 55px">
              <i class="fa fa-envelope-open text-success"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Mail Us Now</p>
              <h5 class="mb-0">CCsuport4@gmail.com</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
          <div class="bg-light rounded p-5">
            <p class="d-inline-block border rounded-pill py-1 px-4">
              Contact Us
            </p>
            <h1 class="mb-4">Have Any Query? Please Contact Us!</h1>
            <p class="mb-4">
              Get in touch with us for any inquiries, support, or to learn
              more about our services. We're here to help you every step of
              the way.
            </p>
            <form action="" method="POST">
  <div class="row g-3">
    <div class="col-md-6">
      <div class="form-floating">
        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required />
        <label for="name">Your Name</label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required />
        <label for="email">Your Email</label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-floating">
        <input type="text" class="form-control" id="nic" name="nic" placeholder="Your NIC" required />
        <label for="nic">Your NIC</label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-floating">
        <input type="text" class="form-control" id="phoneno" name="phoneno" placeholder="Your Phone No" required />
        <label for="phoneno">Your Phone No</label>
      </div>
    </div>
    <div class="col-12">
      <div class="form-floating">
        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required />
        <label for="subject">Subject</label>
      </div>
    </div>
    <div class="col-12">
      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a message here" id="message" name="message" style="height: 100px" required></textarea>
        <label for="message">Message</label>
      </div>
    </div>
    <div class="col-12">
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="agree_privacy" id="agree_privacy" required>
    <label class="form-check-label" for="agree_privacy">
      I agree to the <a href="privacy_policy.php" target="_blank" class="text-success">Privacy Policy</a>.
    </label>
  </div>
</div>

<div class="col-12">
  <button class="btn btn-success w-100 py-3" type="submit" name="submit">Send Message</button>
</div>

  </div>
</form>

          </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
          <div class="h-100" style="min-height: 400px">
            <iframe
              class="rounded w-100 h-100"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
              frameborder="0"
              allowfullscreen=""
              aria-hidden="false"
              tabindex="0"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Contact End -->

  <!-- Footer Start -->
  <?php
  include 'footer.php';
  ?>
  <!-- Footer End -->

</body>

</html>