<?php 
require '../vendor/autoload.php';
@include '../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['client_name'])) {
    header('location: ../Login.php');
    exit();
}

\Stripe\Stripe::setApiKey('sk_test_51PogfEJPAqFNtZdbduwy02cCzH0Yr4Iom6unQwXrElw6q2MsVmGLyXgeT5PKDHRwjarsW7CWj7EaqDnTjOtwPxuv00ncwfnKaR');

header('Content-Type: application/json');

$input = file_get_contents("php://input");
$body = json_decode($input, true);

$paymentMethodId = $body['payment_method_id'];
$userNIC = $body['user_nic'];
$itemList = $body['item_list'];
$amount = $body['amount'];
$method = $body['method'];
$status = $body['status'];
$date = $body['date'];
$payment = $body['payment'];
$conAppId = $body['conAppId'];

try {
    // Stripe payment intent
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount * 100,
        'currency' => 'usd',
        'payment_method' => $paymentMethodId,
        'confirm' => true,
        'automatic_payment_methods' => [
            'enabled' => true,
            'allow_redirects' => 'never',
        ],
    ]);

    if ($paymentIntent->status === 'requires_action' || $paymentIntent->status === 'requires_confirmation') {
        echo json_encode(['requires_action' => true, 'payment_intent_client_secret' => $paymentIntent->client_secret]);
    } else {
        // ✅ Record the appointment payment in the 'orders' table
        $query = "INSERT INTO orders (NIC, ItemList, Amount, Method, Status, Date, Payment)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssdssss', $userNIC, $itemList, $amount, $method, $status, $date, $payment);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Payment successful and recorded in orders table.']);
        } else {
            echo json_encode(['error' => 'Failed to insert payment record: ' . $stmt->error]);
        }

        $stmt->close();
    }
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Unexpected error: ' . $e->getMessage()]);
}

$conn->close();
?>

