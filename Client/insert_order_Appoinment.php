<?php
session_start();
@include '../config.php';

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);

// Validate the input
if (isset($input['NIC']) && isset($input['ItemList']) && isset($input['Amount']) && isset($input['Date'])) {
    $nic = $input['NIC'];
    $itemList = json_encode($input['ItemList']);  // Serialize the array to JSON
    $amount = $input['Amount'];
    $method = "Cash on Delivery";
    $status = "Pending";
    $date = $input['Date'];

    // Prepare and execute the SQL statement to insert the order
    $stmt = $conn->prepare("INSERT INTO orders (NIC, ItemList, Amount, Method, Status, Date) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "SQL prepare failed"]);
        exit();
    }

    // Bind the parameters (s = string, d = double, i = integer)
    $stmt->bind_param("ssdsss", $nic, $itemList, $amount, $method, $status, $date);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order placed successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to place order"]);
    }


    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
}

$conn->close();
