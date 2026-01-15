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

// Query to get the count of drugs in the cart for the current user
$countQuery = "SELECT COUNT(*) AS itemCount FROM cart WHERE user_NIC = '$user_nic'";
$countResult = mysqli_query($conn, $countQuery);
$itemCount = 0; // Default value

if ($countResult) {
    $row = mysqli_fetch_assoc($countResult);
    $itemCount = $row['itemCount']; // Get the item count
}

// Free result set
mysqli_free_result($countResult);
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
                <a href="index.php" class="nav-item nav-link ">Home</a>
                <div class="nav-item dropdown">
                    <a
                        href="service.html"
                        class="nav-link dropdown-toggle active"
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
                Medication
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item text-success active" aria-current="page">
                        Medications
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Medications Section Start -->
    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-end mb-4"> <!-- Align items to the right -->
            <!-- Cart Icon that links to cart.php -->
            <a href="cart.php" class="cart-icon position-relative text-decoration-none d-flex align-items-center">

                <i class="fas fa-shopping-cart fa-2x text-primary"></i> <!-- Change color to primary -->
                <span class="badge badge-danger position-absolute" style="top: -10px; right: -10px;"><?php echo $itemCount; ?></span> <!-- Display the count here -->
            </a>
        </div>

        
        <a 
            href="my_purchases.php" 
            class="btn btn-primary rounded-0 py-1 px-lg-2">
            Medications History
            <i class="fa fa-arrow-right ms-3"></i>
        </a>



        <!-- Search Bar -->
        <div class="mb-4 text-center">
            <input type="text" id="searchInput" placeholder="Search for medications..." class="form-control w-50 mx-auto">
        </div>

        <div class="row" id="medicationsList">
            <?php
            // Fetch data from the 'drugs' table, including the Image column
            $sql = "SELECT drugID, Name, Price, Type, Image FROM drugs";
            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Use the image path directly from the database
                    $imagePath = $row['Image'];
            ?>
                    <div class="col-md-3 mb-4 medication-item">
                        <div class="card h-100">
                            <!-- Display the image from the database -->
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" class="card-img-top medication-image" alt="<?php echo htmlspecialchars($row['Name']); ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['Name']); ?></h5>
                                <p class="card-text"><?php echo "$" . number_format($row['Price'], 2); ?></p>

                                <!-- Flex container for buttons -->
                                <div class="button-group">
                                    <a href="#" class="btn btn-success add-to-cart" data-drug-id="<?php echo $row['drugID']; ?>">Add to Cart</a>
                                    <a href="drugDetails.php?id=<?php echo $row['drugID']; ?>" class="btn btn-success">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No medications available.</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>

    </div>
    <!-- Medications Section End -->

    <style>
        .cart-icon {
            color: #007bff;
            /* Bootstrap primary color */
            transition: color 0.3s ease;
            position: relative;
            /* Position relative to allow badge positioning */
        }

        .cart-icon:hover {
            color: #0056b3;
            /* Darker shade on hover */
            transform: scale(1.1);
            /* Slightly enlarge on hover */
        }

        .cart-icon i {
            position: relative;
            bottom: 2px;
            /* Adjust vertical position */
        }

        .badge {
            position: absolute;
            /* Position the badge */
            top: -5px;
            /* Adjust vertical position */
            right: -10px;
            /* Adjust horizontal position */
            background-color: red;
            /* Red background for the badge */
            color: white;
            /* White text color */
            border-radius: 50%;
            /* Make it a circle */
            padding: 5px 10px;
            /* Add padding for the circle */
            font-size: 0.8rem;
            /* Adjust font size */
            min-width: 20px;
            /* Minimum width for better appearance */
            text-align: center;
            /* Center text */
        }

        /* Ensure each card is the same height */
        .medication-item .card {
            height: 100%;
        }

        /* Set a fixed height and width for images */
        .medication-image {
            width: 100%;
            height: 200px;
            /* Adjust height as needed */
            object-fit: cover;
            /* Ensures the image fills the space without distortion */
        }

        /* Ensure card content is consistent */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }



        /* Flex container for buttons */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            /* Space between buttons */
            margin-top: 10px;
        }

        /* Smaller button styles */
        .button-group .btn {
            font-size: 1rem;
            /* Smaller font size */
            padding: 7px 12px;
            /* Adjust padding for a smaller button */
        }
    </style>













    <!-- Footer Start -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer End -->

    <script src="../js/medicationSearchFilter.js"></script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach event listeners to "Add to Cart" buttons
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Get the drugID from data attribute
                    const drugID = this.getAttribute('data-drug-id');

                    // Send AJAX request to add item to cart
                    fetch('add_to_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                drugID: drugID
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Item added to cart!");
                                location.reload();
                            } else {
                                alert("Failed to add item to cart: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert("An error occurred while adding to cart.");
                        });
                });
            });
        });
    </script>



</body>

</html>