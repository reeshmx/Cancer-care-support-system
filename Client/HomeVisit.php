<?php
@include '../config.php';
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

// Fetch doctor details from the database
$sql = "SELECT * FROM doctor_details";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Klinik - Clinic Website Template</title>
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

<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
  echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
          🎉 Appointment request placed successfully! We will contact you soon.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

if (isset($_GET['error']) && $_GET['error'] == 1) {
  echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
          ❌ Something went wrong. Please try again.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
?>

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
        Home Visit Appoinment
      </h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb text-uppercase mb-0">
          <li class="breadcrumb-item">
            <a class="text-white" href="index.php">Home</a>
          </li>
          <li class="breadcrumb-item text-success active" aria-current="page">
            Home Visit
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->

  <!-- Appointment Start -->

  <div class="container">

    <h1 class="mb-4">Schedule a Home Visit Appointment with a Doctor</h1>

    <div class="bg-light rounded d-flex align-items-center p-5 mb-4">
      <p class="mb-4">
        Here, you can select a doctor based on their specialization and profile description. After choosing a doctor, please complete the form with your details and submit it. We will contact you as soon as possible to confirm your appointment.
      </p>
    </div>

    <!-- Centering the button with Bootstrap classes and adjusting width -->
    <div class="text-center mb-3">
      <button class="btn btn-success" style="width: 200px;" data-bs-toggle="modal" data-bs-target="#requestModal">+ Send Request</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">Home Visit Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="homeVisitRequestForm" method="POST" action="submit_request.php">
              <div class="mb-3">
                <label for="patientName" class="form-label">Patient Name</label>
                <input type="text" class="form-control" id="patientName" name="patientName" required>
              </div>
              <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" required>
              </div>
              <div class="mb-3">
                <label for="phoneNo" class="form-label">Phone No</label>
                <input type="tel" class="form-control" id="phoneNo" name="phoneNo" required>
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
              </div>
              <div class="mb-3">
  <label for="doctor" class="form-label">Select Doctor</label>
  <select class="form-control" id="doctor" name="doctor" required>
    <option value="">-- Choose a Doctor --</option>
    <?php
    // Fetch doctor names from database
    $doctorQuery = "SELECT Doctor_ID, Doctor_Name, Specification FROM doctor_details";
    $doctorResult = $conn->query($doctorQuery);

    if ($doctorResult && $doctorResult->num_rows > 0) {
      while ($doctorRow = $doctorResult->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($doctorRow['Doctor_Name']) . '">'
          . htmlspecialchars($doctorRow['Doctor_Name']) . ' (' . htmlspecialchars($doctorRow['Specification']) . ')</option>';
      }
    } else {
      echo '<option value="">No doctors available</option>';
    }
    ?>
  </select>
</div>
              <button type="submit" class="btn btn-success">Submit Request</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <p class="d-inline-block border rounded-pill py-1 px-4">
      Our Doctors
    </p>

    <!-- Doctors -->
    <div class="row g-4">
      <?php
      if ($result->num_rows > 0) {
        // Loop through each doctor and display their details
        while ($row = $result->fetch_assoc()) {
          $doctor_image = htmlspecialchars($row['Photo']); // Assume 'photo' is the column name for the image path
          $doctor_name = htmlspecialchars($row['Doctor_Name']); // Assume 'doctor_name' is the column name
          $specialization = htmlspecialchars($row['Specification']); // Assume 'specialization' is the column name

          // Output the doctor card
          echo '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">';
          echo '<div class="doctor-item bg-light rounded h-100 p-4 text-center">';
          echo '<img src="' . $doctor_image . '" alt="Doctor Image" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px;">';
          echo '<h5 class="mb-1">' . $doctor_name . '</h5>';
          echo '<p class="text-muted mb-3">' . $specialization . '</p>';
          echo '</div>'; // Close doctor-item
          echo '</div>'; // Close col
        }
      } else {
        echo '<div class="col-12 text-center"><p>No doctors available at the moment.</p></div>';
      }
      ?>
    </div>

  </div>

  </div>

  <!-- Appointment End -->

  <!-- Footer Start -->
  <?php
  include 'footer.php';
  ?>
  <!-- Footer End -->
<script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
      alert.classList.remove('show');
      alert.classList.add('fade');
    }
  }, 4000); // alert disappears after 4 seconds
</script>

</body>

</html>