<?php
@include '../config.php';
session_start();

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_NIC'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input and decode it
    $data = json_decode(file_get_contents('php://input'), true);
    $drugID = $data['drugID'];
    $userNIC = $_SESSION['user_NIC'];

    // Insert the item into the 'cart' table
    $stmt = $conn->prepare("INSERT INTO cart (user_NIC, drugID) VALUES (?, ?)");
    $stmt->bind_param("si", $userNIC, $drugID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    $stmt->close();
}
$conn->close();
