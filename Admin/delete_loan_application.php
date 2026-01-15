<?php
@include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the application ID from the POST request
    $application_id = isset($_POST['application_id']) ? intval($_POST['application_id']) : 0;

    // Check if the application ID is valid
    if ($application_id > 0) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM loan_applications WHERE application_id = ?");
        $stmt->bind_param("i", $application_id);

        if ($stmt->execute()) {
            // Check if a row was deleted
            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Application deleted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "No application found with the specified ID."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete application."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid application ID."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
