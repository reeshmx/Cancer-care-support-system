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

    <style>
        /* Ensure all service boxes have the same fixed height */
        .service-box {
            min-height: 300px;
            /* Adjust height as needed */
            max-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Limit image size within the box for uniformity */
        .service-img {
            max-height: 150px;
            /* Adjust image height as needed */
            object-fit: contain;
        }
    </style>
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
                Loan Services
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item text-success active" aria-current="page">
                        Loan Service
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
     <!-- ✅ Display Loan Application Success Message -->
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center w-75 mx-auto mt-4" role="alert">
        <?php echo htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>
    
    <div class="container py-5 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loanServiceModal">Apply for Loan Service</button>
    </div>

    </div>
    </div>
    <!-- Load Services Section Start -->
    <div class="container py-5">
        <div class="row g-4">
            <?php
            @include '../config.php';

            // Fetch loan services
            $sql = "SELECT * FROM loan_services";
            $result = $conn->query($sql);
            ?>

            <!-- Load Services Section Start -->
            <div class="container py-5">
                <div class="row g-4">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-lg-4 col-md-6">';
                            echo '    <div class="service-box text-center border p-3">';
                            echo '        <img src="' . htmlspecialchars($row['service_image']) . '" alt="' . htmlspecialchars($row['service_name']) . '" class="img-fluid service-img mb-3" />';
                            echo '        <h5>' . htmlspecialchars($row['service_name']) . '</h5>';
                            echo '        <p>' . htmlspecialchars($row['description']) . '</p>'; // Added description here
                            echo '    </div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-12 text-center">No services available</div>';
                    }
                    ?>
                </div>
            </div>
            <!-- Load Services Section End -->
        </div>
        <!-- Load Services Section End -->


        <!-- Loan Service Modal Start -->
        <div class="modal fade" id="loanServiceModal" tabindex="-1" aria-labelledby="loanServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loanServiceModalLabel">Apply for Loan Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

        <?php
            // Fetch all available loan services from the admin's table
            $serviceQuery = "SELECT * FROM loan_services";
            $serviceResult = $conn->query($serviceQuery);
        ?>

        <form action="submit_loan_application.php" method="POST">


                            <!-- 1st Row: Patient Name, NIC, and Gender -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="patientName" class="form-label">Patient Name</label>
                                    <input type="text" class="form-control" id="patientName" name="patient_name" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="nic" class="form-label">NIC</label>
                                    <input type="text" class="form-control" id="nic" name="nic" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 2nd Row: Address -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required />
                                </div>
                            </div>

                            <!-- 3rd Row: Phone Number 1, Phone Number 2, Suffering Duration -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="phone1" class="form-label">Phone Number 1</label>
                                    <input type="text" class="form-control" id="phone1" name="phone1" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="phone2" class="form-label">Phone Number 2</label>
                                    <input type="text" class="form-control" id="phone2" name="phone2" />
                                </div>
                                <div class="col-md-4">
                                    <label for="sufferingDuration" class="form-label">How long suffering with cancer</label>
                                    <input type="text" class="form-control" id="sufferingDuration" name="suffering_duration" required />
                                </div>
                            </div>

                            <!-- New Row: Select Loan Service -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="loanService" class="form-label">Select a Loan Service</label>
                                    <select class="form-select" id="loanService" name="loan_service" required>
    <option value="" disabled selected>Select a loan service</option>
    <?php
    if ($serviceResult && $serviceResult->num_rows > 0) {
        while ($service = $serviceResult->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($service['service_name']) . '">' 
                . htmlspecialchars($service['service_name']) . 
                '</option>';
        }
    } else {
        echo '<option value="" disabled>No loan services available</option>';
    }
    ?>
</select>

                                </div>
                            </div>

                            <!-- 4th Row: How can we help you? -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="help" class="form-label">How can we help you?</label>
                                    <textarea class="form-control" id="help" name="help" rows="3" required></textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success">Submit Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Loan Service Modal End -->


        <!-- Footer Start -->
        <?php
        include 'footer.php';
        ?>
        <!-- Footer End -->
         <script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000); // fades after 4 seconds
</script>


</body>

</html>