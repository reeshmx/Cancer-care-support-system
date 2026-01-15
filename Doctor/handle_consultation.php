<?php
@include '../config.php'; // Ensure config.php is included for database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorName = $_POST['DoctorName'];
    $doctorNIC = $_POST['DoctorNIC'];
    $patientName = $_POST['PatientName'];

    // Set the current date for Sri Lanka timezone
    $dateTimeColombo = new DateTime('now', new DateTimeZone('Asia/Colombo'));
    $consultedDate = $dateTimeColombo->format('Y-m-d'); // Format the date as needed

    $contactStatus = $_POST['ContactStatus'];
    $description = $_POST['Description'];
    $doctorCharge = $_POST['DoctorCharge'];
    $medicationList = $_POST['MedicationList'];
    $medicationTotalAmount = $_POST['TotalAmount'];
    $conAppID = $_POST['CON_APP_ID'];

    // Prepare and execute the insert statement
    $insertQuery = "INSERT INTO doctor_consultation_response (Doctor_Name, Doctor_NIC, PatientName, ConsultedDate, ContactStatus, Description, DoctorCharge, MedicationList, MedicationTotalAmount, CON_APP_ID) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $insertQuery)) {
        mysqli_stmt_bind_param($stmt, 'ssssssssss', $doctorName, $doctorNIC, $patientName, $consultedDate, $contactStatus, $description, $doctorCharge, $medicationList, $medicationTotalAmount, $conAppID);

        if (mysqli_stmt_execute($stmt)) {
            // Successfully inserted into doctor_consultation_response
            mysqli_stmt_close($stmt); // Close the statement before executing another query

            // Update the status in consult_appointment table
            $updateQuery = "UPDATE consult_appointment SET status = '1' WHERE CON_APP_ID = ?";
            if ($updateStmt = mysqli_prepare($conn, $updateQuery)) {
                mysqli_stmt_bind_param($updateStmt, 's', $conAppID);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);
            } else {
                echo 'Update prepare failed';
            }

            header('Location: Consult_Appointment.php');
            exit(); // Ensure no further code executes
        } else {
            echo 'Insert error';
        }
    } else {
        echo 'Prepare failed';
    }
}
