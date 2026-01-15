<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and retrieve doctor name and NIC
if (isset($_SESSION['doctor_name'])) {
    $doctor_name = $_SESSION['doctor_name']; // Get doctor name from session
    $user_nic = $_SESSION['user_NIC'];

    // Extract the last name
    $name_parts = explode(' ', $doctor_name);
    $last_name = end($name_parts); // Get the last name (assuming last name is the last part)
} else {
    // Redirect to the login page if not logged in as a doctor
    header('location: ../Login.php');
    exit();
}

// Get the current page file name
$current_page = basename($_SERVER['PHP_SELF']);

// Query to count appointments with status = 0 for the current doctor (matching last name)
$status_zero_count = 0; // Initialize count
$query = "SELECT COUNT(*) as count FROM consult_appointment WHERE status = 0 AND Doctor_Name LIKE ?"; // Use LIKE to match last name
$stmt = $conn->prepare($query);
$last_name_with_wildcard = "%" . $last_name; // Add wildcard for matching
$stmt->bind_param("s", $last_name_with_wildcard); // Bind the last name with wildcard to the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count from the result set
if ($result) {
    $row = $result->fetch_assoc();
    $status_zero_count = $row['count'];
}

$stmt->close(); // Close the prepared statement
?>

<style>
    .icon {
        position: relative;
        /* Enable positioning for the badge */
    }

    .badge {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 50%;
        /* Make it circular */
        background-color: red;
        /* Background color */
        color: white;
        /* Text color */
        position: absolute;
        /* Position it over the icon */
        top: -5px;
        /* Adjust vertical positioning */
        right: -10px;
        /* Adjust horizontal positioning */
        font-size: 12px;
        /* Adjust font size */
        line-height: 1;
        /* Align text nicely */
        min-width: 20px;
        /* Ensure minimum width for consistency */
        text-align: center;
        /* Center text */
    }
</style>

<div class="sidebar">
    <div class="sidebar__inner">
        <div class="profile">
            <div class="img">
                <i class="fas fa-user fa-3x"></i> <!-- Font Awesome user icon -->
            </div>
            <div class="profile_info">
                <p>Welcome</p>
                <p class="profile_name"><?php echo htmlspecialchars($doctor_name); ?></p> <!-- Display doctor name dynamically -->
            </div>
        </div>
        <ul>
            <li>
                <a href="index.php" <?php if ($current_page === 'index.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-dice-d6"></i></span>
                    <span class="title">Profile</span>
                </a>
            </li>
            <li>
                <a href="Consult_Appointment.php" <?php if ($current_page === 'Consult_Appointment.php') echo 'class="active"'; ?>>
                    <span class="icon">
                        <i class="fas fa-lightbulb"></i>
                        <?php if ($status_zero_count > 0): ?>
                            <span class="badge"><?php echo $status_zero_count; ?></span>
                        <?php endif; ?>
                    </span>
                    <span class="title">Consult App</span>
                </a>
            </li>
            <li>
                <a href="Consult_Appointment_Completed.php" <?php if ($current_page === 'Consult_Appointment_Completed.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-user-plus"></i></span>
                    <span class="title">Completed </span>
                </a>
            </li>
            <li>
                <a href="Consult_Appointment_Rejected.php" <?php if ($current_page === 'Consult_Appointment_Rejected.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-user-times"></i></span>
                    <span class="title">Rejected </span>
                </a>
            </li>
            <li>
                <a href="HomeVisit.php" <?php if ($current_page === 'HomeVisit.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-house-user"></i></span>
                    <span class="title">Home Visit </span>
                </a>
            </li>
            <li>
                 <a href="DoctorRevenueReport.php">
                    <i class="fa fa-chart-line"></i>
                    <span>Revenue Report</span>
                </a>
            </li>

        </ul>
    </div>
</div>