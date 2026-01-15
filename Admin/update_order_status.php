<?php
@include '../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the request method is POST and required parameters are present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['Payment'])) {
    // Sanitize inputs to prevent SQL injection
    $order_id = intval($_POST['order_id']);
    $Payment = $conn->real_escape_string($_POST['Payment']);

    // Update the order status in the orders table
    $sql = "UPDATE orders SET Payment = '$Payment' WHERE OrderID = $order_id";

    if ($conn->query($sql) === TRUE) {
        // Fetch the required order details along with the PatientName (FirstName from user table)
        $fetchOrderSql = "SELECT o.NIC, o.Amount, o.Date, u.FirstName FROM orders o 
                          JOIN user u ON u.NIC = o.NIC 
                          WHERE o.OrderID = $order_id";
        $orderResult = $conn->query($fetchOrderSql);

        if ($orderResult->num_rows > 0) {
            // Fetch the order details and patient name
            $orderData = $orderResult->fetch_assoc();
            $patientName = $conn->real_escape_string($orderData['FirstName']);  // Using FirstName from user table
            $NIC = $conn->real_escape_string($orderData['NIC']);
            $amount = $orderData['Amount'];
            $date = $orderData['Date'];

            // Insert the data into the invoice table
            $insertInvoiceSql = "INSERT INTO invoice (OrderID, PatientName, NIC, Amount, Date) 
                                 VALUES ($order_id, '$patientName', '$NIC', $amount, '$date')";
            if ($conn->query($insertInvoiceSql) === TRUE) {
                echo "Order Payment updated and invoice created successfully.";
            } else {
                echo "Error inserting into invoice table: " . $conn->error;
            }
        } else {
            echo "Order not found or user not associated with this order.";
        }
    } else {
        echo "Error updating Payment: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
