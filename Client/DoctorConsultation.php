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


// Fetch doctor details
$doctorsQuery = "SELECT Doctor_ID, Doctor_Name, Qualification, Specification FROM doctor_details";
$doctorsResult = mysqli_query($conn, $doctorsQuery);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $patientName = $_POST['patient_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phoneNo = $_POST['phone_no'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $doctorID = $_POST['doctor'];

    // Get doctor details based on Doctor_ID
    $doctorQuery = "SELECT Doctor_Name FROM Doctor_Details WHERE Doctor_ID = ?";
    $stmt = $conn->prepare($doctorQuery);
    $stmt->bind_param("i", $doctorID);
    $stmt->execute();
    $doctorResult = $stmt->get_result();
    $doctorRow = $doctorResult->fetch_assoc();
    $doctorName = $doctorRow['Doctor_Name'];

    // Insert into consult_appointment table
    $query = "INSERT INTO consult_appointment (PatientName, NIC, Age, Gender, PhoneNo, Address, Description, Doctor_ID, Doctor_Name)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siissssis", $patientName,  $user_nic, $age, $gender, $phoneNo, $address, $description, $doctorID, $doctorName);

    if ($stmt->execute()) {
    $_SESSION['success_message'] = "Your appointment has been successfully booked!";
    header("Location: DoctorConsultation.php");
    exit();
} else {
    $_SESSION['error_message'] = "Something went wrong. Please try again.";
    header("Location: DoctorConsultation.php");
    exit();
}

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
                Doctor Consultation Appointment
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item text-success active" aria-current="page">
                        Doctor Consultation
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Appointment Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success text-center" role="alert">'
        . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger text-center" role="alert">'
        . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>

                    <a href="PatientAppointmentDetails.php">
                        <p class="d-inline-block border rounded-pill py-1 px-4">My Appointment Details</p>
                    </a>
                    <h1 class="mb-4">Make An Appointment To Consult with our Doctor</h1>
                    <p class="mb-4">To schedule a consultation with one of our doctors, simply browse through the list of available specialists below and select the doctor that best meets your needs. Complete the form with your details and submit your appointment request. Once confirmed, the doctor will reach out to discuss your symptoms, provide a personalized treatment plan, and guide you on the next steps in your care journey.</p>

                    <!-- Scrollable container for doctor list -->
                    <div class="doctor-list-container" style="max-height: 400px; overflow-y: auto;">
                        <?php
                        // Fetch doctors' details from the Doctor_Details table
                        $query = "SELECT Doctor_Name, Qualification, Specification, Self_Description, Photo FROM Doctor_Details";
                        $result = $conn->query($query);

                        if ($result) {
                            while ($doctor = $result->fetch_assoc()) {
                                // Construct the full path for the doctor's photo
                                $photoPath = '' . $doctor['Photo'];

                                // Display each doctor's details
                                echo '
                <div class="bg-light rounded d-flex align-items-center p-4 mb-4">
                    <!-- Doctor Photo -->
                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white rounded" style="width: 80px; height: 80px; overflow: hidden;">
                        <img src="' . $photoPath . '" alt="Doctor Photo" style="width: 100%; height: auto; object-fit: cover;">
                    </div>
                    
                    <!-- Doctor Details -->
                    <div class="ms-4">
                        <h5 class="mb-1">' . $doctor['Doctor_Name'] . ' - ' . $doctor['Qualification'] . '</h5>
                        <p class="text-primary mb-1">' . $doctor['Specification'] . '</p>
                        <p class="mb-0">' . $doctor['Self_Description'] . '</p>
                    </div>
                </div>
                ';
                            }
                        } else {
                            echo "Error fetching doctors: " . $conn->error;
                        }

                        // Close the connection after all queries are done
                        $conn->close();
                        ?>
                    </div>
                </div>


                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                        <form method="POST" action="">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <input type="text" name="patient_name" class="form-control border-0" placeholder="Patient Name" style="height: 55px;" required>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="number" name="age" class="form-control border-0" placeholder="Age" style="height: 55px;" required>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <select name="gender" class="form-select border-0" style="height: 55px;" required>
                                        <option selected disabled>Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="text" name="phone_no" class="form-control border-0" placeholder="Phone No" style="height: 55px;" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="address" class="form-control border-0" placeholder="Address" style="height: 55px;" required>
                                </div>
                                <div class="col-12">
                                    <select class="form-select border-0" name="doctor" style="height: 55px;" required>
                                        <option selected disabled>Choose Doctor</option>
                                        <?php while ($doctor = mysqli_fetch_assoc($doctorsResult)) { ?>
                                            <option value="<?php echo $doctor['Doctor_ID']; ?>">
                                                <?php echo $doctor['Doctor_Name'] . " - " . $doctor['Qualification'] . " (" . $doctor['Specification'] . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea name="description" class="form-control border-0" rows="5" placeholder="Describe your problem"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success w-100 py-3" type="submit">Consult Doctor Now</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appointment End -->

    <!-- Footer Start -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer End -->

</body>

</html>