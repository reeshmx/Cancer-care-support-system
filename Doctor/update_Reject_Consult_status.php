<?php
@include '../config.php'; // Ensure database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $CON_APP_ID = $_POST['CON_APP_ID'];
    $status = $_POST['status'];

    // Prepare and execute the update query
    $updateQuery = "UPDATE consult_appointment SET status = ? WHERE CON_APP_ID = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $status, $CON_APP_ID);

    if (mysqli_stmt_execute($stmt)) {
        echo 'success';
    } else {
        echo 'error';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
