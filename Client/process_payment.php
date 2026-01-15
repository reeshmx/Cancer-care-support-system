<?php
require '../vendor/autoload.php';
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

\Stripe\Stripe::setApiKey('sk_test_51PogfEJPAqFNtZdbduwy02cCzH0Yr4Iom6unQwXrElw6q2MsVmGLyXgeT5PKDHRwjarsW7CWj7EaqDnTjOtwPxuv00ncwfnKaR'); // Replace with your Stripe Secret Key

header('Content-Type: application/json');

// Get the raw POST data
$input = file_get_contents("php://input");
$body = json_decode($input, true);

// Extract order details and payment method ID
$paymentMethodId = $body['payment_method_id'];
$userNIC = $body['user_nic'];
$itemList = $body['item_list'];
$amount = $body['amount'];
$method = $body['method'];
$status = $body['status'];
$date = $body['date'];
$payment = $body['payment'];

try {
    // Create a PaymentIntent with the payment method ID
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount * 100, // Convert amount to cents (Stripe expects amount in cents)
        'currency' => 'usd',
        'payment_method' => $paymentMethodId,
        'confirmation_method' => 'manual', // Change to 'automatic' if you want Stripe to handle confirmations
        'confirm' => true,
        'return_url' => 'http://yourwebsite.com/return', // Replace with your return URL
    ]);

    // Check the status of the PaymentIntent
    if ($paymentIntent->status === 'requires_action' || $paymentIntent->status === 'requires_confirmation') {
        // Card action is required (e.g., 3D Secure)
        echo json_encode(['requires_action' => true, 'payment_intent_client_secret' => $paymentIntent->client_secret]);
    } else {
        // Payment was successful, insert the order into the database
        $query = "INSERT INTO orders (NIC, ItemList, Amount, Method, Status, Date, Payment) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param('sssssss', $userNIC, $itemList, $amount, $method, $status, $date, $payment);

        // Execute the query
        if ($stmt->execute()) {
            // If the order was successfully inserted, proceed to delete cart records
            // Delete records from the Cart table based on the user NIC
            $deleteQuery = "DELETE FROM Cart WHERE user_NIC = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            if ($deleteStmt === false) {
                die('Error preparing delete statement: ' . $conn->error);
            }

            // Bind parameters for the delete statement
            $deleteStmt->bind_param('s', $userNIC);

            // Execute the delete query
            if ($deleteStmt->execute()) {
                // Successfully deleted from Cart, return success response
                echo json_encode(['success' => true, 'message' => 'Payment successful, order saved, and cart cleared.']);
            } else {
                // Failed to delete from Cart, but still returning success for order insertion
                echo json_encode(['success' => true, 'message' => 'Payment successful and order saved, but failed to clear cart.']);
            }

            // Close the delete statement
            $deleteStmt->close();
        } else {
            echo json_encode(['error' => 'Failed to insert order into database']);
        }

        // Close the insert statement
        $stmt->close();
    }
} catch (\Stripe\Exception\CardException $e) {
    // Handle card errors
    echo json_encode(['error' => $e->getError()->message]);
} catch (\Stripe\Exception\InvalidRequestException $e) {
    // Handle other errors
    echo json_encode(['error' => $e->getError()->message]);
} catch (Exception $e) {
    // Handle unexpected errors
    echo json_encode(['error' => 'Something went wrong.']);
}

// Close the database connection
$conn->close();
