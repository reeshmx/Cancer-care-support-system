<?php
@include 'config.php';
// Check if the user is logged in and if the user type is client
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['client_name'])) {
  $client_name = $_SESSION['client_name'];
  $user_nic = $_SESSION['user_NIC'];
} else {
  // Redirect to the login page if not logged in as client
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
        <a href="privacy_policy.php" class="nav-item nav-link">Privacy policy</a>
      </div>

      <a
        href="../logout.php"
        class="btn btn-warning rounded-0 py-4 px-lg-5 d-none d-lg-block">Logout
        <i class="fa fa-arrow-right ms-3"></i>
      </a>

    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Header Start -->
  <div class="container-fluid header bg-success p-0 mb-5">
    <div class="row g-0 align-items-center flex-column-reverse flex-lg-row">
      <div class="col-lg-6 p-5 wow fadeIn" data-wow-delay="0.1s">
        <h1 class="display-4 text-white mb-5">
          Personalized Support for Every Step of Your Cancer Journey
        </h1>
        <div class="row g-4">
          <div class="col-sm-4">
            <div class="border-start border-light ps-4">
              <h2 class="text-white mb-1" data-toggle="counter-up">20</h2>
              <p class="text-light mb-0">Expert Doctors</p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="border-start border-light ps-4">
              <h2 class="text-white mb-1" data-toggle="counter-up">50</h2>
              <p class="text-light mb-0">Our Staff</p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="border-start border-light ps-4">
              <h2 class="text-white mb-1" data-toggle="counter-up">350</h2>
              <p class="text-light mb-0">Total Patients</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
        <div class="owl-carousel header-carousel">
          <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="../img/carousel-1.jpg" alt="" />
            <div class="owl-carousel-text">
              <h1 class="display-1 text-white mb-0">Immunotherapy</h1>
            </div>
          </div>
          <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="../img/carousel-2.jpg" alt="" />
            <div class="owl-carousel-text">
              <h1 class="display-1 text-white mb-0">Counseling</h1>
            </div>
          </div>
          <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="../img/carousel-3.jpg" alt="" />
            <div class="owl-carousel-text">
              <h1 class="display-1 text-white mb-0">Oncology</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Header End -->

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
          <div class="d-flex flex-column">
            <img
              class="img-fluid rounded w-75 align-self-end"
              src="../img/about-1.jpg"
              alt="" />
            <img
              class="img-fluid rounded w-50 bg-white pt-3 pe-3"
              src="../img/about-2.jpg"
              alt=""
              style="margin-top: -25%" />
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
          <p class="d-inline-block border rounded-pill py-1 px-4">About Us</p>
          <h1 class="mb-4">Why You Should Trust Us? Get Know About Us!</h1>
          <p>
            Our website is dedicated to enhancing cancer care accessibility
            and support. We offer comprehensive resources, affordable
            medications, and a compassionate community, aiming to alleviate
            the emotional, financial, and logistical challenges faced by
            cancer patients and their families.
          </p>

          <p>
            <i class="far fa-check-circle text-success me-3"></i>Quality
            health care
          </p>
          <p>
            <i class="far fa-check-circle text-success me-3"></i>Only
            Qualified Doctors
          </p>
          <p>
            <i class="far fa-check-circle text-success me-3"></i>Medical
            Research Professionals
          </p>
          <div
            class="btn btn-success rounded-pill py-3 px-5 mt-3">We Are Here For You</div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Service Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div
        class="text-center mx-auto mb-5 wow fadeInUp"
        data-wow-delay="0.1s"
        style="max-width: 600px">
        <p class="d-inline-block border rounded-pill py-1 px-4">Services</p>
        <h1>Health Care Solutions</h1>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div
              class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
              style="width: 65px; height: 65px">
              <i class="fa fa-heartbeat text-success fs-4"></i>
            </div>
            <h4 class="mb-3">Home Visit</h4>
            <p class="mb-4">
              Our professional healthcare team provides convenient, in-home
              medical care for patients, offering quality attention in a
              familiar and comfortable setting.
            </p>
            <a class="btn" href="HomeVisit.php"><i class="fa fa-plus text-success me-3"></i>Get Service</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div
              class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
              style="width: 65px; height: 65px">
              <i class="fa fa-pills text-success fs-4"></i>
            </div>
            <h4 class="mb-3">Buy Medication</h4>
            <p class="mb-4">
              Access essential medications through our services, ensuring you
              receive affordable and reliable pharmaceutical products.
            </p>
            <a class="btn" href="Medications.php"><i class="fa fa-plus text-success me-3"></i>Get Service</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div
              class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
              style="width: 65px; height: 65px">
              <i class="fa fa-brain text-success fs-4"></i>
            </div>
            <h4 class="mb-3">Counselling Service</h4>
            <p class="mb-4">
              Our counseling service provides emotional support and guidance,
              helping patients and families navigate the challenges of medical
              treatment with professional assistance.
            </p>
            <a class="btn" href=""><i class="fa fa-plus text-success me-3"></i>Get Service</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div
              class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
              style="width: 65px; height: 65px">
              <i class="fa fa-hand-holding-usd text-success fs-4"></i>
            </div>
            <h4 class="mb-3">Loan Services</h4>
            <p class="mb-4">
              Financial assistance is available to make essential treatments
              more affordable, supporting you in accessing the care you need
              without financial strain.
            </p>
            <a class="btn" href="LoanService.php"><i class="fa fa-plus text-success me-3"></i>Get Service</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div
              class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
              style="width: 65px; height: 65px">
              <i class="fa fa-user-md text-success fs-4"></i>
            </div>
            <h4 class="mb-3">Consult Our Doctor</h4>
            <p class="mb-4">
              Connect with our skilled doctors for consultations and
              personalized health advice to address your specific healthcare
              needs.
            </p>
            <a class="btn" href="DoctorConsultation.php"><i class="fa fa-plus text-success me-3"></i>Get Service</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div
              class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
              style="width: 65px; height: 65px">
              <i class="fa fa-notes-medical text-success fs-4"></i>
            </div>
            <h4 class="mb-3">Program Updates</h4>
            <p class="mb-4">
              Stay informed about the latest advancements and clinical trials,
              as we work continuously to offer cutting-edge solutions and
              improve patient care.
            </p>
            <a class="btn" href="Programs.php"><i class="fa fa-plus text-success me-3"></i>Get Service</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Service End -->


  <!-- Feature Start -->
  <div class="container-fluid bg-success overflow-hidden my-5 px-lg-0">
    <div class="container feature px-lg-0">
      <div class="row g-0 mx-lg-0">
        <div
          class="col-lg-6 feature-text py-5 wow fadeIn"
          data-wow-delay="0.1s">
          <div class="p-lg-5 ps-lg-0">
            <p
              class="d-inline-block border rounded-pill text-light py-1 px-4">
              Features
            </p>
            <h1 class="text-white mb-4">Why Choose Us</h1>
            <p class="text-white mb-4 pb-2">
              We provide comprehensive support for cancer patients and
              families with tailored services, including comfortable
              accommodations, nutritious meals, professional counselling, home
              visits, temporary foster care, and affordable medications. Our
              awareness programs also empower communities. Trust us for
              compassionate, efficient care and commitment.
            </p>
            <div class="row g-4">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div
                    class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light"
                    style="width: 55px; height: 55px">
                    <i class="fa fa-user-md text-success"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Experience</p>
                    <h5 class="text-white mb-0">Doctors</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div
                    class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light"
                    style="width: 55px; height: 55px">
                    <i class="fa fa-check text-success"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Quality</p>
                    <h5 class="text-white mb-0">Services</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div
                    class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light"
                    style="width: 55px; height: 55px">
                    <i class="fa fa-comment-medical text-success"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Positive</p>
                    <h5 class="text-white mb-0">Consultation</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div
                    class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light"
                    style="width: 55px; height: 55px">
                    <i class="fa fa-headphones text-success"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">24 Hours</p>
                    <h5 class="text-white mb-0">Support</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="col-lg-6 pe-lg-0 wow fadeIn"
          data-wow-delay="0.5s"
          style="min-height: 400px">
          <div class="position-relative h-100">
            <img
              class="position-absolute img-fluid w-100 h-100"
              src="../img/feature.jpg"
              style="object-fit: cover"
              alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Feature End -->



  <!-- Testimonial Start -->

  <!-- Testimonial End -->

  <!-- Footer Start -->
  <?php
  include 'footer.php';
  ?>
  <!-- Footer End -->

</body>

</html>