<?php
@include '../config.php';

if (isset($_GET['id'])) {
    $program_id = intval($_GET['id']);

    // Delete the program from the database
    $sql = "DELETE FROM support_programs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $program_id);

    if ($stmt->execute()) {
        // Redirect back to the program management page after deletion
        header("Location: ManagePrograms.php?msg=Program+Deleted+Successfully");
    } else {
        echo "Error deleting program: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
