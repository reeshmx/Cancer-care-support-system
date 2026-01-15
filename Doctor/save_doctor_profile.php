<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['doctor_name']) || !isset($_SESSION['user_NIC'])) {
    // Redirect to the login page if not logged in as a doctor
    header('location: ../Login.php');
    exit();
}

$user_nic = $_SESSION['user_NIC'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and validate the data from the form
    $doctor_name = $_POST['Doctor_Name'] ?? '';
    $age = $_POST['Age'] ?? null;
    $gender = $_POST['Gender'] ?? '';
    $phone = $_POST['PhoneNo'] ?? '';
    $address = $_POST['Address'] ?? '';
    $email = $_POST['Email'] ?? '';
    $dob = $_POST['DOB'] ?? '';
    $specification = $_POST['Specification'] ?? '';
    $qualification = $_POST['Qualification'] ?? '';
    $self_description = $_POST['Self_Description'] ?? '';

    // Handle file upload for photo, if a file was uploaded
    $photo_name = '';
    if (isset($_FILES['Photo']) && $_FILES['Photo']['error'] === UPLOAD_ERR_OK) {
        $photo_name = basename($_FILES['Photo']['name']);
        $photo_target = '../uploads/' . $photo_name;
        move_uploaded_file($_FILES['Photo']['tmp_name'], $photo_target);
    }

    // Prepare the SQL update query
    $query = "UPDATE doctor_details SET Doctor_Name = ?, Age = ?, Gender = ?, PhoneNo = ?, Address = ?, Email = ?, DOB = ?, Specification = ?, Qualification = ?, Self_Description = ?, Photo = ? WHERE NIC = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sissssssssss",
        $doctor_name,
        $age,
        $gender,
        $phone,
        $address,
        $email,
        $dob,
        $specification,
        $qualification,
        $self_description,
        $photo_name,
        $user_nic
    );

    // Execute the query and check for success
    if ($stmt->execute()) {
        // Redirect to profile or success page
        header('location: index.php?status=success');
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
