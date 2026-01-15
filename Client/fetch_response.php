<?php
// Database connection
@include '../config.php'; // Adjust the path as necessary

// Check if the con_app_id is set
if (isset($_GET['con_app_id'])) {
    $conAppId = intval($_GET['con_app_id']); // Sanitize input

    // Prepare and execute the query
    $query = "SELECT * FROM doctor_consultation_response WHERE CON_APP_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $conAppId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data was found
    if ($result->num_rows > 0) {
        $response = $result->fetch_assoc(); // Fetch the data
        echo json_encode($response); // Return data as JSON
    } else {
        echo json_encode(null); // No data found
    }

    $stmt->close();
} else {
    echo json_encode(null); // Invalid request
}

$conn->close();
