<?php
session_start();
@include '../config.php';

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);

// Validate the input
if (isset($input['NIC']) && isset($input['ItemList']) && isset($input['Amount'])) {
    $nic = $input['NIC'];
    $itemList = $input['ItemList'];
    $amount = $input['Amount'];
    $method = "Cash on Delivery";
    $status = "Pending";
    $date = $input['Date'];

    // Prepare and execute the SQL statement to insert the order
    $stmt = $conn->prepare("INSERT INTO orders (NIC, ItemList, Amount, Method, Status, Date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $nic, $itemList, $amount, $method, $status, $date);

    if ($stmt->execute()) {
        // If order insertion is successful, delete the cart records for the user
        $deleteStmt = $conn->prepare("DELETE FROM cart WHERE user_NIC = ?");
        $deleteStmt->bind_param("s", $nic);

        if ($deleteStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Order placed successfully and cart cleared."]);
        } else {
            echo json_encode(["success" => false, "message" => "Order placed, but failed to clear cart: " . $deleteStmt->error]);
        }

        $deleteStmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error placing order: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
}

$conn->close();
