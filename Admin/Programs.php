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


// Fetch programs
$sql = "SELECT * FROM support_programs";
$result = $conn->query($sql);

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
        /* Custom CSS to move the table to the right */
        .right-aligned-table {
            margin-left: auto;
            margin-right: 0;
            width: 120%;
            /* Adjust width as needed */
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
                <h1 class="text-primary">Manage Support Programs</h1>
            </header>

            <!-- Add Program Button -->
            <div class="mb-3 text-left">
                <a href=" AddProgram.php" class="btn btn-success">Add New Program</a>
            </div>

            <!-- Programs Table -->
            <div class="right-aligned-table"> <!-- Added custom CSS class here -->
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Program ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td>
                                    <!-- Apply action-btn class for uniform button size -->
                                    <a href="EditProgram.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm action-btn">Edit</a>
                                    <a href="DeleteProgram.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this program?');" class="btn btn-danger btn-sm action-btn">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $conn->close(); ?>
    </div>
</body>
<footer class="credit"></footer>

</html>