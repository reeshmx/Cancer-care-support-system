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
        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
        }

        .quantity-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .quantity-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            padding: 0;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
        }

        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
                Cart
            </h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-white" href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-white" href="Medications.php">Medications</a>
                    </li>
                    <li class="breadcrumb-item text-success active" aria-current="page">
                        Cart
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->





    <!-- Cart Section Start -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Your Cart</h2>

        <?php
        // Query to get data from the cart and drugs tables for the current user
        $query = "SELECT cart.cartID, cart.drugID, cart.createdAt, drugs.Name, drugs.Type, drugs.Price, drugs.Image 
              FROM cart 
              JOIN drugs ON cart.drugID = drugs.drugID 
              WHERE cart.user_NIC = '$user_nic'";
        $result = mysqli_query($conn, $query);

        $productNames = []; // Array to store product names for ItemsList in modal

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-striped text-center">';
            echo '<thead class="table-success">';
            echo '<tr>';
            echo '<th scope="col">Name</th>';
            echo '<th scope="col">Type</th>';
            echo '<th scope="col">Price</th>';
            echo '<th scope="col">Quantity</th>';
            echo '<th scope="col">Image</th>';
            echo '<th scope="col">Created At</th>';
            echo '<th scope="col">Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Initialize total amount
            $totalAmount = 0;

            // Fetch and display each row of data for the current user
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row['Price'];
                $totalAmount += $price;

                // Add product name to the array
                $productNames[] = $row['Name'];

                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['Type']) . '</td>';
                echo '<td>$<span class="price">' . number_format($price, 2) . '</span></td>';
                echo '<td>';
                echo '<div class="quantity-wrapper">';
                echo '<button type="button" class="btn btn-outline-secondary quantity-btn" onclick="adjustQuantity(this, -1)">-</button>';
                echo '<input type="number" class="form-control quantity-input" value="1" min="1" data-price="' . $price . '" oninput="updateTotal()" />';
                echo '<button type="button" class="btn btn-outline-secondary quantity-btn" onclick="adjustQuantity(this, 1)">+</button>';
                echo '</div>';
                echo '</td>';
                echo '<td><img src="' . htmlspecialchars($row['Image']) . '" style="width: 50px; height: auto;" alt="Drug Image"></td>';
                echo '<td>' . $row['createdAt'] . '</td>';
                echo '<td><button type="button" class="btn btn-danger" onclick="removeFromCart(' . $row['cartID'] . ')">Remove</button></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '<h4 class="text-center mt-4">Total Amount: $<span id="totalAmount">' . number_format($totalAmount, 2) . '</span></h4>';

            // Add the BUY NOW button
            echo '<div class="text-center mt-4">';
            echo '<button type="button" class="btn btn-success btn-lg" onclick="showOrderConfirmation()">BUY NOW</button>';
            echo '</div>';

            echo '</div>';
        } else {
            echo '<p class="text-center">Your cart is empty.</p>';
        }

        // Free result set and close the connection
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>

        <!-- Pass product names to JavaScript as JSON in a data attribute -->
        <div id="cartContainer" data-product-names='<?php echo json_encode($productNames); ?>'></div>
    </div>

    <!-- Order Confirmation Modal -->
    <div class="modal fade" id="orderConfirmationModal" tabindex="-1" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="orderConfirmationModalLabel">Order Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="confirm_order.php" method="POST">
                        <p>Please confirm your order details:</p>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Client Name:</label>
                            <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($client_name); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userNIC" class="form-label">NIC:</label>
                            <input type="text" class="form-control" id="userNIC" name="userNIC" value="<?php echo htmlspecialchars($user_nic); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount:</label>
                            <input type="text" class="form-control" id="totalAmountModal" name="totalAmount" value="" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ItemsList" class="form-label">Items List:</label>
                            <ul id="ItemsList" class="list-group"></ul> <!-- Items List will be populated here -->
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                            <button type="button" class="btn btn-secondary btn-lg px-4" onclick="showCodConfirmation()">Cash on Delivery</button>

                            <button type="button" class="btn btn-success btn-lg px-4" onclick="handleOnlinePayment()">Online Payment</button>
                        </div>
                    </form>
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
                    <button type="button" class="btn btn-success" onclick="confirmOrder()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Online Payment Modal -->
    <div class="modal fade" id="onlinePaymentModal" tabindex="-1" aria-labelledby="onlinePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="onlinePaymentModalLabel">Online Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Payment Options -->
                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-outline-secondary">
                            <i class="fab fa-paypal"></i> PayPal
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fab fa-apple"></i> Apple Pay
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fab fa-google"></i> Google Pay
                        </button>
                    </div>
                    <p class="text-center">or pay using credit card</p>

                    <!-- Credit Card Form -->
                    <form id="creditCardForm" method="POST" action="process_payment.php">
                        <div class="mb-3">
                            <label for="cardHolderName" class="form-label">Card holder full name</label>
                            <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <div id="card-element"><!-- Stripe Element will be inserted here --></div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="button" id="checkout-button" class="btn btn-dark">Checkout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript for Remove Functionality -->
    <script>
        function removeFromCart(cartID) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                window.location.href = 'remove_from_cart.php?cartID=' + cartID; // Redirect to PHP script for deletion
            }
        }



        function showOrderConfirmation() {
            // Get total amount from the DOM
            const totalAmount = document.getElementById('totalAmount').textContent;
            // Set the total amount in the modal
            document.getElementById('totalAmountModal').value = totalAmount;
            // Show the modal
            var orderConfirmationModal = new bootstrap.Modal(document.getElementById('orderConfirmationModal'));
            orderConfirmationModal.show();
        }
    </script>


    <!-- JavaScript to Adjust Quantity and Calculate Total Amount -->
    <script>
        function adjustQuantity(button, delta) {
            const input = button.parentElement.querySelector('.quantity-input');
            let newQuantity = parseInt(input.value) + delta;

            // Ensure the quantity does not go below 1
            if (newQuantity >= 1) {
                input.value = newQuantity; // Update the quantity input value
                updateTotal(); // Recalculate the total amount when quantity changes
            }
        }

        function updateTotal() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            let total = 0;

            // Loop through each quantity input and calculate total
            quantityInputs.forEach(input => {
                const price = parseFloat(input.getAttribute('data-price')); // Get price from data attribute
                const quantity = parseInt(input.value); // Get current quantity value
                total += price * quantity; // Calculate total price for each item
            });

            // Update the total amount in the DOM
            document.getElementById('totalAmount').textContent = total.toFixed(2); // Format total to 2 decimal places
        }

        // JavaScript to display the items list in the modal
        function showOrderConfirmation() {
            // Get product names from the data attribute
            const productNames = JSON.parse(document.getElementById("cartContainer").dataset.productNames);
            const itemsList = document.getElementById("ItemsList");

            // Populate ItemsList in the modal
            itemsList.innerHTML = productNames.map(name => `<li class="list-group-item">${name}</li>`).join("");

            // Set total amount in the modal
            document.getElementById("totalAmountModal").value = document.getElementById("totalAmount").innerText;

            // Show the modal
            new bootstrap.Modal(document.getElementById("orderConfirmationModal")).show();
        }

        function showCodConfirmation() {
            // Show the confirmation modal when "Cash on Delivery" is clicked
            const codConfirmationModal = new bootstrap.Modal(document.getElementById('codConfirmationModal'));
            codConfirmationModal.show();
        }

        function handleOnlinePayment() {
            // Show the online payment modal
            var onlinePaymentModal = new bootstrap.Modal(document.getElementById('onlinePaymentModal'));
            onlinePaymentModal.show();
        }


        const stripe = Stripe('pk_test_51PogfEJPAqFNtZdbiUOwCJQj5cHi1tKcxQie1Oknob9hx0p3XLPTVgwr9RrUGnIFt8KaqAWZM9QmXJUlUdprjmQ500nnPV4Piu'); // Replace with your Stripe Publishable key
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        document.getElementById('checkout-button').addEventListener('click', async (e) => {
            e.preventDefault();
            const {
                error,
                paymentMethod
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: document.getElementById('cardHolderName').value,
                },
            });
            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                // Collect the order data
                const userNIC = <?php echo json_encode($_SESSION['user_NIC']); ?>;
                const itemList = document.getElementById("ItemsList").innerText;
                const amount = document.getElementById("totalAmountModal").value;
                const method = 'Online Payment';
                const status = 'Pending';
                const date = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD format
                const payment = 'Paid';

                // Send paymentMethod.id and order data to the server
                fetch('process_payment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            payment_method_id: paymentMethod.id,
                            user_nic: userNIC,
                            item_list: itemList,
                            amount: amount,
                            method: method,
                            status: status,
                            date: date,
                            payment: payment
                        })
                    }).then(response => response.json())
                    .then(result => {
                        if (result.error) {
                            document.getElementById('card-errors').textContent = result.error;
                        } else {
                            alert('Payment successful!');
                            window.location.reload();
                        }
                    });
            }
        });


        function confirmOrder() {
            const itemList = document.getElementById("ItemsList").innerText; // Get the item list from the modal
            const amount = document.getElementById("totalAmountModal").value; // Get the amount from the modal
            const nic = "<?php echo $_SESSION['user_NIC']; ?>"; // PHP session variable for NIC

            // Send AJAX request to the server
            fetch("insert_order.php", {
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
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Refresh the page if order is successful
                        location.reload();
                    } else {
                        alert("Error placing order: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>



    <!-- Cart Section End -->




    </div>





    <!-- Cart Section End -->





    <!-- Footer Start -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer End -->


</body>

</html>