<?php
@include '../config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $patient_name = $_POST['patient_name'];
    $nic = $_POST['nic'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $suffering_duration = $_POST['suffering_duration'];
    $loan_service = $_POST['loan_service'];
    $help = $_POST['help'];
    $application_date = date('Y-m-d H:i:s'); // Get the current date and time

    // Prepare and execute the insert SQL statement
    $sql = "INSERT INTO loan_applications (patient_name, nic, gender, address, phone1, phone2, suffering_duration, loan_service, help, application_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $patient_name, $nic, $gender, $address, $phone1, $phone2, $suffering_duration, $loan_service, $help, $application_date);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect or display a success message
        header("Location: LoanService.php?msg=" . urlencode("✅ Loan Application Submitted Successfully!"));
      exit; // Make sure to exit after the header redirect
    } else {
        echo "Error submitting application: " . $stmt->error; // Change $conn->error to $stmt->error
    }

    $stmt->close();
}

$conn->close();
