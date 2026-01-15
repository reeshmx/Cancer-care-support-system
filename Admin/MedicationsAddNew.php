<?php
@include '../config.php';
// Check if the user is logged in and if the user type is admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['admin_name'])) {
    $admin_name = $_SESSION['admin_name'];
} else {
    // Redirect to the login page if not logged in as admin
    header('location: ../Login.php');
    exit();
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../UploadImages/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        $imageFileName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Save image path relative to the project root in the database
            $imageURL = $imagePath;
        } else {
            $imageURL = null;
            echo "<script>alert('Error uploading the image.');</script>";
        }
    } else {
        $imageURL = null;
    }

    // Insert data into the database
    $sql = "INSERT INTO drugs (Name, Type, Price, Description, Image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $name, $type, $price, $description, $imageURL);

    if ($stmt->execute()) {
        echo "<script>alert('New medication added successfully'); window.location.href='Medications.php';</script>";
    } else {
        echo "<script>alert('Error adding medication');</script>";
    }

    $stmt->close();
    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CSS Sidebar Menu with icons Example</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- SideBar-Menu CSS -->
    <link rel="stylesheet" href="../css/styles.css" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="css/demo.css" />

    <script>
        $(document).ready(function() {
            $(".hamburger .hamburger__inner").click(function() {
                $(".wrapper").toggleClass("active");
            });

            $(".top_navbar .fas").click(function() {
                $(".profile_dd").toggleClass("active");
            });
        });
    </script>

    <style>
        /* Center the form */
        .form-container {
            width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;

        }
    </style>
</head>

<body>
    <?php include './TopBar.php'; ?>

    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">

            <div class="form-container">

                <!-- Button to Add New Medication -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="Medications.php" class="btn btn-success">Back </a>
                </div>
                <header class="text-center mb-4">
                    <h1>Add New Medication</h1>
                </header>


                <!-- Form to add new medication -->
                <form action="MedicationsAddNew.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Add Medication</button>
                </form>
            </div>
        </div>
    </div>
</body>
<footer class="credit">

</footer>





</html>