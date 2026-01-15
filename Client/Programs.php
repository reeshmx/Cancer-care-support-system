<?php
@include '../config.php';
// Check if the user is logged in and if the user type is client_name
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['client_name'])) {
    $client_name = $_SESSION['client_name'];
    $user_nic = $_SESSION['user_NIC'];
} else {
    // Redirect to the login page if not logged in as client_name
    header('location: ../Login.php');
    exit();
}


// Fetch support programs
$sql = "SELECT * FROM support_programs";
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
                Support Programs
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item text-success active" aria-current="page">
                        Programs
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    </div>
    </div>
    <!-- Programs Section Start -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-4 text-success">Support Programs for Cancer Patients</h2>
            <p class="lead">Explore programs designed to provide assistance, support, and resources for cancer patients and their families.</p>
        </div>

        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-success">
                        <div class="card-body text-center">
                            <h4 class="card-title text-success"><?php echo htmlspecialchars($row['title']); ?></h4>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#programModal<?php echo $row['id']; ?>">Learn More</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Programs Section End -->

    <!-- Program Modals -->
    <?php
    $result->data_seek(0); // Reset result pointer to start again for modals
    while ($row = $result->fetch_assoc()) {
    ?>
        <div class="modal fade" id="programModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="programModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="programModalLabel<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo htmlspecialchars($row['modal_content']); ?></p>
                        <p><strong><?php echo htmlspecialchars($row['session_info']); ?></strong></p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo htmlspecialchars($row['button_link']); ?>" target="_blank" class="btn btn-success">
                            <?php echo htmlspecialchars($row['button_text']); ?>
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>


                </div>
            </div>
        </div>
    <?php } ?>

    <?php $conn->close(); ?>


    <!-- Footer Start -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer End -->

</body>

</html>