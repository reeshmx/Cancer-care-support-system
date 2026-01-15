<?php
@include '../config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the program ID from the POST request
    $program_id = intval($_POST['program_id']); // Add this line

    // Get the other values from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $modal_content = $_POST['modal_content'];
    $session_info = $_POST['session_info'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // Prepare and execute the update SQL statement
    $sql = "UPDATE support_programs SET title = ?, description = ?, modal_content = ?, session_info = ?, button_text = ?, button_link = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $description, $modal_content, $session_info, $button_text, $button_link, $program_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        header("Location: Programs.php?msg=Program+Updated+Successfully");
        exit; // Make sure to exit after the header redirect
    } else {
        echo "Error updating program: " . $stmt->error; // Change $conn->error to $stmt->error
    }

    $stmt->close();
}

// Fetching the program data if id is provided in URL
if (isset($_GET['id'])) {
    $program_id = intval($_GET['id']); // Get the program ID from the URL

    // Prepare and execute the SQL statement to fetch the program details
    $sql = "SELECT * FROM support_programs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the program exists
    if ($result->num_rows > 0) {
        $program = $result->fetch_assoc(); // Fetch the program details into an associative array
    } else {
        echo "Program not found.";
        exit;
    }

    $stmt->close();
} else {
    echo "No program ID specified.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Edit Support Program</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .right-aligned-table {
            margin-left: auto;
            margin-right: 0;
            width: 120%;
        }
    </style>
</head>

<body>
    <?php include './TopBar.php'; ?>
    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container py-3">
            <header class="intro text-center">
                <h1 class="text-primary">Edit Support Program</h1>
            </header>
            <div class="right-aligned-table">
                <form method="POST">
                    <input type="hidden" name="program_id" value="<?php echo htmlspecialchars($program['id']); ?>"> <!-- Add this line -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($program['title']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required><?php echo htmlspecialchars($program['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modal_content">Modal Content</label>
                        <textarea name="modal_content" id="modal_content" class="form-control" required><?php echo htmlspecialchars($program['modal_content']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="session_info">Session Info</label>
                        <input type="text" name="session_info" id="session_info" value="<?php echo htmlspecialchars($program['session_info']); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="button_text">Button Text</label>
                        <input type="text" name="button_text" id="button_text" value="<?php echo htmlspecialchars($program['button_text']); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="button_link">Button Link</label>
                        <input type="text" name="button_link" id="button_link" value="<?php echo htmlspecialchars($program['button_link']); ?>" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Program</button>
                    <a href="Programs.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
<footer class="credit"></footer>

</html>