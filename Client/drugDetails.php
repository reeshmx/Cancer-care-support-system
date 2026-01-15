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



// Get the drug ID from the URL
$drugID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch drug details from the database
$sql = "SELECT Name, Price, Type, Description, Image FROM drugs WHERE drugID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $drugID);
$stmt->execute();
$result = $stmt->get_result();

// Check if a drug was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Drug not found.</p>";
    exit;
}

// Close the database connection
$stmt->close();
$conn->close();
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
        .details-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .details-container img {
            max-width: 100%;
            border-radius: 5px;
        }

        .details-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .details-container p {
            font-size: 18px;
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
        <div><?php echo 'We are here for you, <span style="color:Blue; font-weight:bold;">' . $client_name . '</span> 💪💖✨'; ?></div>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <<a href="Medications.php" class="dropdown-item">Medications</a>
                    <a href="DoctorConsultation.php" class="dropdown-item">Doctor Consultation</a>
                    <a href="HomeVisit.php" class="dropdown-item">Home Visit</a>
                    <a href="LoanService.php" class="dropdown-item">Loan Service</a>
                    <a href="Programs.php" class="dropdown-item">Programs</a>
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
                Medication
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-white" href="Medications.php">Medications</a>
                    </li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">
                        Drug Details
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->




    <div class="details-container container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $row['Image']; ?>" alt="<?php echo $row['Name']; ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1><?php echo $row['Name']; ?></h1>
                <p><strong>Price:</strong> <?php echo "$" . number_format($row['Price'], 2); ?></p>
                <p><strong>Type:</strong> <?php echo $row['Type']; ?></p>
                <p><strong>Description:</strong> <?php echo $row['Description']; ?></p>
                <a href="Medications.php" class="btn btn-success">Back to Medications</a> <!-- Link back to the medications page -->
            </div>
        </div>
    </div>














    <!-- Footer Start -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer End -->

</body>

</html>