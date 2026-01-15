<?php
@include '../config.php';

// Check if the user is logged in and if the user type is admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_name'])) {
    header('location: ../Login.php');
    exit();
}

// Check if drugID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $drugID = $_GET['id'];

    // Prepare and execute the SQL statement to delete the record
    $sql = "DELETE FROM drugs WHERE drugID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $drugID);

    if ($stmt->execute()) {
        // Record deleted successfully, redirect back to the main medications page
        echo "<script>alert('Medication deleted successfully'); window.location.href = 'Medications.php';</script>";
    } else {
        echo "<script>alert('Error deleting medication'); window.location.href = 'Medications.php';</script>";
    }

    $stmt->close();
} else {
    // Invalid ID, redirect back to the main medications page
    header("Location: Medications.php");
    exit();
}

$conn->close();
