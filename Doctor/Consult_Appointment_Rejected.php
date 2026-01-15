<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Check if the user is logged in and if the user type is client
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['doctor_name'])) {
    $doctor_name = $_SESSION['doctor_name'];
    $user_nic = $_SESSION['user_NIC'];

    // Query to get the Doctor_ID based on user_nic
    $doctorIdQuery = "SELECT Doctor_ID FROM doctor_details WHERE NIC = '$user_nic'";
    $doctorIdResult = mysqli_query($conn, $doctorIdQuery);

    if ($doctorIdRow = mysqli_fetch_assoc($doctorIdResult)) {
        $doctor_id = $doctorIdRow['Doctor_ID'];

        // Query to get consultation appointments filtered by Doctor_ID and status = 5 (rejected)
        $appointmentsQuery = "SELECT CON_APP_ID, PatientName, Age, Gender, PhoneNo, Address, Description, Doctor_ID, Doctor_Name 
        FROM consult_appointment 
        WHERE Doctor_ID = '$doctor_id' AND status = '5'";
        $appointmentsResult = mysqli_query($conn, $appointmentsQuery);
    } else {
        // Handle case where no Doctor_ID was found
        $appointmentsResult = [];
    }
} else {
    // Redirect to the login page if not logged in as client
    header('location: ../Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Rejected Consult Appointments</title>

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
                <h1>Rejected Consult Appointments</h1>
            </header>

            <div class="table-responsive" style="width: 110%;">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr style="text-align:center;">
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointmentsResult)) { ?>
                            <?php while ($appointment = mysqli_fetch_assoc($appointmentsResult)) { ?>
                                <tr>
                                    <td><?php echo $appointment['PatientName']; ?></td>
                                    <td><?php echo $appointment['Age']; ?></td>
                                    <td><?php echo $appointment['Gender']; ?></td>
                                    <td><?php echo $appointment['PhoneNo']; ?></td>
                                    <td><?php echo $appointment['Address']; ?></td>
                                    <td><?php echo $appointment['Description']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">No rejected appointments found for this doctor.</td>
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