<?php
@include '../config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $modal_content = $_POST['modal_content'];
    $session_info = $_POST['session_info'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // Prepare and execute the insert SQL statement
    $sql = "INSERT INTO support_programs (title, description, modal_content, session_info, button_text, button_link) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $description, $modal_content, $session_info, $button_text, $button_link);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        header("Location: Programs.php?msg=Program+Added+Successfully");
        exit; // Make sure to exit after the header redirect
    } else {
        echo "Error adding program: " . $stmt->error; // Change $conn->error to $stmt->error
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add Support Program</title>
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
                <h1 class="text-primary">Add Support Program</h1>
            </header>
            <div class="right-aligned-table">
                <form method="POST">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modal_content">Modal Content</label>
                        <textarea name="modal_content" id="modal_content" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="session_info">Session Info</label>
                        <input type="text" name="session_info" id="session_info" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="button_text">Button Text</label>
                        <input type="text" name="button_text" id="button_text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="button_link">Button Link</label>
                        <input type="text" name="button_link" id="button_link" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Program</button>
                    <a href="Programs.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
<footer class="credit"></footer>

</html>