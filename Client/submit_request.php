<?php
@include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $patientName = $_POST['patientName'];
    $age = $_POST['age'];
    $phoneNo = $_POST['phoneNo'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $doctor = $_POST['doctor'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO HomeVisit (PatientName, Age, PhoneNo, Address, Description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $patientName, $age, $phoneNo, $address, $description);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: HomeVisit.php?success=1");
        exit();
    } else {
        // Redirect with error message
        header("Location: HomeVisit.php?error=1");
        exit();
    }

    // Close the statement
    $stmt->close();
}
?>

