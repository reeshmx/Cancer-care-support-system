<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Check if the user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['doctor_name'])) {
    $doctor_name = $_SESSION['doctor_name'];
    $user_nic = $_SESSION['user_NIC'];

    // Query to get the homevisit records
    $homeVisitQuery = "SELECT PatientName, Age, PhoneNo, Address, Description, ID 
                       FROM homevisit";
    $homeVisitResult = mysqli_query($conn, $homeVisitQuery);

    // Handle record deletion
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Query to delete the record
        $deleteQuery = "DELETE FROM homevisit WHERE ID = ?";
        if ($stmt = mysqli_prepare($conn, $deleteQuery)) {
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Home visit request deleted successfully');</script>";
            } else {
                echo "<script>alert('Failed to delete the request');</script>";
            }
            mysqli_stmt_close($stmt);
        }
    }
} else {
    // Redirect to the login page if not logged in as doctor
    header('location: ../Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Home Visit Requests</title>

    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
    <?php include './TopBar.php'; ?>
    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container">
            <header class="intro">
                <h1>Home Visit Requests</h1>
            </header>

            <div class="table-responsive" style="width: 110%;">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr style="text-align:center;">
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th>Action</th> <!-- New Action column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($homeVisitResult) > 0) { ?>
                            <?php while ($homeVisit = mysqli_fetch_assoc($homeVisitResult)) { ?>
                                <tr>
                                    <td><?php echo $homeVisit['PatientName']; ?></td>
                                    <td><?php echo $homeVisit['Age']; ?></td>
                                    <td><?php echo $homeVisit['PhoneNo']; ?></td>
                                    <td><?php echo $homeVisit['Address']; ?></td>
                                    <td><?php echo $homeVisit['Description']; ?></td>
                                    <td style="text-align:center;">
                                        <!-- Delete Button -->
                                        <a href="?delete_id=<?php echo $homeVisit['ID']; ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this home visit request?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">No home visit requests found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="credit">
        <!-- Footer content here -->
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>