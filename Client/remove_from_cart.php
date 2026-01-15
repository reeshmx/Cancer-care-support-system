<?php
session_start();
@include '../config.php';

if (isset($_GET['cartID'])) {
    $cartID = intval($_GET['cartID']);  // Ensure the cart ID is an integer

    // Prepare the delete query
    $query = "DELETE FROM cart WHERE cartID = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $cartID);  // Bind the cart ID parameter
        if ($stmt->execute()) {
            // Redirect back to the cart page
            header("Location: cart.php?msg=Item removed successfully.");  // Adjust the redirection as needed
            exit;
        } else {
            // Handle the error if the delete failed
            echo "Error: Could not delete item.";
        }
        $stmt->close();
    } else {
        echo "Error: Could not prepare statement.";
    }
}

// Close the connection
$conn->close();
