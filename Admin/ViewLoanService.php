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

// Handle form submission for adding a loan service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];

    // Handle the image upload
    $target_dir = "../img/LoanServiceIMG/";
    $target_file = $target_dir . basename($_FILES["service_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or a fake image
    $check = getimagesize($_FILES["service_image"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.');</script>";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["service_image"]["size"] > 2000000) {
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["service_image"]["tmp_name"], $target_file)) {
            // Insert new service into the database
            $sql = "INSERT INTO loan_services (service_name, service_image, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $service_name, $target_file, $description);
            if ($stmt->execute()) {
                echo "<script>alert('Service added successfully!');</script>";
            } else {
                echo "<script>alert('Error adding service.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}

// Handle deletion of a loan service
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM loan_services WHERE service_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Service deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting service.');</script>";
    }
}

// Fetch all loan services for display
$sql = "SELECT * FROM loan_services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Loan Services - Admin Dashboard</title>
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
        /* Custom CSS to move the table to the right */
        .table-responsive {
            margin-left: auto;
            margin-right: 0;
            width: 120%;
        }

        /* Set uniform width for Edit and Delete buttons */
        .action-btn {
            width: 80px;
            /* Set width to ensure both buttons are the same size */
        }
    </style>
</head>

<body>
    <?php include './TopBar.php'; ?>

    <div class="main_container ">
        <?php include './SideBar.php'; ?>

        <div class="container py-3">
            <header class="intro text-center">
                <h1 class="text-primary">Loan Applications</h1>
            </header>



            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="service_name">Service Name:</label>
                        <input type="text" class="form-control" name="service_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="service_image">Service Image:</label>
                        <input type="file" class="form-control-file" name="service_image" accept="image/*" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
                <button type="submit" name="add_service" class="btn btn-success">Add Service</button>
            </form>



            <!-- Table to Display Existing Loan Services -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Service Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['service_id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['service_name']) . '</td>';
                                echo '<td><img src="' . htmlspecialchars($row['service_image']) . '" alt="' . htmlspecialchars($row['service_name']) . '" width="100" /></td>';
                                echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                                echo '<td>';
                                echo '<a href="?delete=' . htmlspecialchars($row['service_id']) . '" class="btn btn-danger action-btn">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">No services available</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
<footer class="credit"></footer>

</html>