<?php
@include '../config.php';

// Check if the user is logged in and if the user type is admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['admin_name'])) {
    $admin_name = $_SESSION['admin_name'];
} else {
    // Redirect to the login page if not logged in as admin
    header('location: ../Login.php');
    exit();
}

// Check if order_id and status are passed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);  // sanitize status

    // Update the status in the orders table
    $sql = "UPDATE orders SET Status = '$status' WHERE OrderID = $order_id";

    if ($conn->query($sql) === TRUE) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
