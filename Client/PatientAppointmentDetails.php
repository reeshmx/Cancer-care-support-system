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

// Fetch consultation appointments
$appointmentsQuery = "SELECT * FROM consult_appointment Where NIC = $user_nic ";
$appointmentsResult = mysqli_query($conn, $appointmentsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Klinik - Clinic Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="../img/favicon.ico" rel="icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
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
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Doctor Consultation Appointment</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="DoctorConsultation.php">Doctor Consultation</a></li>
                    <li class="breadcrumb-item text-success active" aria-current="page">Patient Appointment Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Other content above -->

    <!-- Appointment Table Start -->
    <div class="container">
        <h2 class="text-center mb-4">Appointment Details</h2>
        <table class="table table-bordered" style="text-align:center;">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient Name</th>
                    <th>NIC</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Phone No</th>
                    <th>Address</th>
                    <th>Description</th>
                    <th>Doctor ID</th>
                    <th>Doctor Name</th>
                    <th>Action</th> <!-- New Action Column -->
                </tr>
            </thead>
            <tbody>
<?php
if ($appointmentsResult && mysqli_num_rows($appointmentsResult) > 0) {
    while ($row = mysqli_fetch_assoc($appointmentsResult)) {
        // Determine status/action button
        if ($row['status'] == 5) {
            $actionButton = '<button class="btn btn-danger" disabled>Rejected</button>';
        } else {
            // Check if doctor response exists
            $responseQuery = "SELECT * FROM doctor_consultation_response WHERE CON_APP_ID = ?";
            $responseStmt = $conn->prepare($responseQuery);
            $responseStmt->bind_param("i", $row['CON_APP_ID']);
            $responseStmt->execute();
            $responseResult = $responseStmt->get_result();

            if ($responseResult->num_rows > 0) {
                $actionButton = '<button class="btn btn-success" onclick="viewResponse(' . $row['CON_APP_ID'] . ')">View Response</button>';
            } else {
                $actionButton = '<button class="btn btn-warning">Pending</button>';
            }
        }

        echo "<tr>
            <td>{$row['CON_APP_ID']}</td>
            <td>{$row['PatientName']}</td>
            <td>{$row['NIC']}</td>
            <td>{$row['Age']}</td>
            <td>{$row['Gender']}</td>
            <td>{$row['PhoneNo']}</td>
            <td>{$row['Address']}</td>
            <td>{$row['Description']}</td>
            <td>{$row['Doctor_ID']}</td>
            <td>{$row['Doctor_Name']}</td>
            <td>{$actionButton}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='11' class='text-center'>No appointments found.</td></tr>";
}
?>
</tbody>

        </table>
    </div>
    <!-- Appointment Table End -->


    <!-- Appointment Table End -->

    <!-- Modal Structure -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Increase the modal size -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Consultation Response</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="responseForm">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="doctorName" class="form-label">Doctor Name</label>
                                <input type="text" class="form-control" id="doctorName" readonly>
                            </div>
                            <div class="col">
                                <label for="patientName" class="form-label">Patient Name</label>
                                <input type="text" class="form-control" id="patientName" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="consultedDate" class="form-label">Consulted Date</label>
                                <input type="text" class="form-control" id="consultedDate" readonly>
                            </div>
                            <div class="col">
                                <label for="contactStatus" class="form-label">Contact Status</label>
                                <input type="text" class="form-control" id="contactStatus" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="medicationList" class="form-label">Medication List</label>
                                <input type="text" class="form-control" id="medicationList" readonly
                                    style="filter: blur(5px); user-select: none; pointer-events: none;">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col">
                                <label for="medicationTotalAmount" class="form-label">Medication Total Amount</label>
                                <input type="text" class="form-control" id="medicationTotalAmount" readonly>
                            </div>
                            <div class="col">
                                <label for="doctorCharge" class="form-label">Doctor Charge</label>
                                <input type="text" class="form-control" id="doctorCharge" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" readonly></textarea>
                        </div>


                        <!-- Order Now Button -->
                        <button type="button" class="btn btn-success" id="orderNowButton">Order Now</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Confirmation Modal -->
    <div class="modal fade" id="orderConfirmationModal" tabindex="-1" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="orderConfirmationModalLabel">Order Confirmation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p class="mb-1"><strong>Patient Name:</strong> <span id="orderPatientName"></span></p>
                        <p class="mb-3"><strong>NIC:</strong> <span id="orderNic"></span></p>
                    </div>

                    <div class="text-center my-4">
                        <p class="mb-0" style="font-size: 1.25rem;"><strong>Total Amount</strong></p>
                        <p id="orderMessage" class="display-4 text-success fw-bold">$<span id="totalAmount"></span></p>
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                        <button type="button" class="btn btn-secondary btn-lg px-4" onclick="showCodConfirmation()">Cash on Delivery</button>
                        <button type="button" class="btn btn-success btn-lg px-4" onclick="showOnlinePayment()">Pay Online</button>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash on Delivery Confirmation Modal -->
    <div class="modal fade" id="codConfirmationModal" tabindex="-1" aria-labelledby="codConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="codConfirmationModalLabel">Confirm Cash on Delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to place the order with Cash on Delivery?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-secondary" onclick="confirmOrder()">Yes</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Stripe Payment Modal -->
<div class="modal fade" id="stripePaymentModal" tabindex="-1" aria-labelledby="stripePaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Secure Online Payment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Enter your card details to complete payment.</p>
        <form id="stripePaymentForm">
          <div id="card-element" class="my-3"></div>
          <button id="confirmPaymentButton" class="btn btn-success w-100" type="button">Confirm Payment</button>
        </form>
      </div>
    </div>
  </div>
</div>


    <!-- Include Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>


    <!-- JavaScript Function for Fetching Response -->
    <script>
        function viewResponse(conAppId) {
            // Perform an AJAX request to fetch the response data
            fetch('fetch_response.php?con_app_id=' + conAppId)
                .then(response => response.json())
                .then(data => {
                    // Check if data is available
                    if (data) {
                        // Populate the modal fields with fetched data
                        document.getElementById('doctorName').value = data.Doctor_Name || '';
                        document.getElementById('doctorCharge').value = data.DoctorCharge || '';
                        document.getElementById('patientName').value = data.PatientName || '';
                        document.getElementById('consultedDate').value = data.ConsultedDate || '';
                        document.getElementById('contactStatus').value = data.ContactStatus || '';
                        document.getElementById('medicationList').value = data.MedicationList || '';
                        document.getElementById('medicationTotalAmount').value = data.MedicationTotalAmount || '';
                        document.getElementById('description').value = data.Description || '';

                        // Show the modal
                        var myModal = new bootstrap.Modal(document.getElementById('responseModal'));
                        myModal.show();
                    } else {
                        alert('No data found for this appointment.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching response:', error);
                });
        }


        // Function triggered by "Order Now" button
        document.getElementById('orderNowButton').addEventListener('click', function() {
            // Retrieve values from the fields
            const medicationTotalAmount = parseFloat(document.getElementById('medicationTotalAmount').value) || 0;
            const doctorCharge = parseFloat(document.getElementById('doctorCharge').value) || 0;
            const patientName = document.getElementById('patientName').value;

            // Calculate the total amount
            const totalAmount = medicationTotalAmount + doctorCharge;

            // Populate modal content
            document.getElementById('orderMessage').textContent = ` ${totalAmount}`;
            document.getElementById('orderNic').textContent = '<?php echo $user_nic; ?>';
            document.getElementById('orderPatientName').textContent = patientName;

            // Show the order confirmation modal
            var orderConfirmationModal = new bootstrap.Modal(document.getElementById('orderConfirmationModal'));
            orderConfirmationModal.show();
        });


        function showCodConfirmation() {
            // Show the confirmation modal when "Cash on Delivery" is clicked
            const codConfirmationModal = new bootstrap.Modal(document.getElementById('codConfirmationModal'));
            codConfirmationModal.show();
        }




        function confirmOrder(conAppId) {
            // Retrieve values from the modal elements
            const itemList = document.getElementById('medicationList').value; // Get the medication list from the input field
            const doctorCharge = document.getElementById('doctorCharge').value; // Get the doctor's charge
            const medicationTotalAmount = document.getElementById('medicationTotalAmount').value; // Get the total medication amount

            // Calculate the total amount (if necessary, you can customize this logic)
            const amount = parseFloat(doctorCharge) + parseFloat(medicationTotalAmount); // Add doctor's charge and medication total amount

            const nic = "<?php echo $_SESSION['user_NIC']; ?>"; // PHP session variable for NIC

            // Send AJAX request to the server
            fetch("insert_order_Appoinment.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        NIC: nic,
                        ItemList: itemList,
                        Amount: amount,
                        Method: "Cash on Delivery",
                        Status: "Pending",
                        Date: new Date().toISOString().slice(0, 10), // Current date in YYYY-MM-DD format
                        conAppId: conAppId // Add the conAppId here
                    }),
                })
                .then(response => {
                    console.log("Response:", response); // Log the response to check what is being returned
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Try to parse the JSON
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Error placing order: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while placing the order. Please try again.");
                });
        }
        const stripe = Stripe('pk_test_51PogfEJPAqFNtZdbiUOwCJQj5cHi1tKcxQie1Oknob9hx0p3XLPTVgwr9RrUGnIFt8KaqAWZM9QmXJUlUdprjmQ500nnPV4Piu');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

        function showOnlinePayment() {
        const modal = new bootstrap.Modal(document.getElementById('stripePaymentModal'));
        modal.show();
        }

document.getElementById('confirmPaymentButton').addEventListener('click', async function() {
    const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
    });

    if (error) {
        alert(error.message);
        return;
    }

    const amount = parseFloat(document.getElementById('medicationTotalAmount').value) +
                   parseFloat(document.getElementById('doctorCharge').value);

    const body = {
        payment_method_id: paymentMethod.id,
        user_nic: "<?php echo $_SESSION['user_NIC']; ?>",
        item_list: document.getElementById('medicationList').value,
        amount: amount,
        method: "Online Payment",
        status: "Paid",
        date: new Date().toISOString().slice(0, 10),
        payment: "Stripe",
        conAppId: document.getElementById('consultedDate').value // or pass CON_APP_ID dynamically if needed
    };

    const response = await fetch('process_appointment_payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
    });

    const data = await response.json();
    if (data.success) {
        alert(data.message);
        location.reload();
    } else {
        alert(data.error || "Payment failed.");
    }
});

    </script>

    <!-- Footer Start -->
    <?php include 'Footer.php'; ?>
    <!-- Footer End -->

</body>

</html>