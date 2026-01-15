<?php
@include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $comment = $_POST['comment'];

    // Update the comment in the orders table
    $stmt = $conn->prepare("UPDATE orders SET Comment = ? WHERE OrderID = ?");
    $stmt->bind_param("si", $comment, $orderId);

    if ($stmt->execute()) {
        echo "Comment updated successfully";
    } else {
        echo "Error updating comment";
    }
    $stmt->close();
}
