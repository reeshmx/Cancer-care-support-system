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

// Fetch loan applications
$sql = "SELECT * FROM loan_applications";
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
            width: 115%;
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

            <!-- Add Program Button -->
            <div class="mb-3 text-left">
                <a href=" ViewLoanService.php" class="btn btn-success">View Loan Services</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>NIC</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Phone 1</th>
                            <th>Phone 2</th>
                            <th>Suffering Duration</th>
                            <th>Loan Service</th>
                            <th>Help</th>
                            <th>Application Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";

                                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nic']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone1']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone2']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['suffering_duration']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['loan_service']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['help']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['application_date']) . "</td>";
                                echo '<td>
                                       
                                        <button class="btn btn-danger action-btn" onclick="deleteApplication(' . $row['application_id'] . ')">Delete</button>
                                      </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12' class='text-center'>No loan applications found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        // Function to delete an application
        function deleteApplication(applicationId) {
            if (confirm("Are you sure you want to delete this application?")) {
                $.ajax({
                    url: 'delete_loan_application.php',
                    type: 'POST',
                    data: {
                        application_id: applicationId
                    },
                    success: function(response) {
                        location.reload(); // Reload the page to see the changes
                    },
                    error: function() {
                        alert("Error deleting application.");
                    }
                });
            }
        }
    </script>
</body>
<footer class="credit"></footer>

</html>