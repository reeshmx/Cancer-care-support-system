<?php

@include '../config.php'; // Ensure config.php is included for database connection


// Database connection (assuming $db is your database connection variable)
$query = "SELECT *FROM query";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Doctor Profile</title>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css" />
    <!-- Demo CSS -->
    <link rel="stylesheet" href="css/demo.css" />
</head>

<body>
    <?php include './TopBar.php'; ?>
    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container">
            <header class="intro">

            </header>

            <div class="visit-requests">
                <h2>Query</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th> Name</th>
                            <th>Email</th>
                            <th>NIC</th>
                            <th>PhoneNo</th>
                            <th>Subject</th>
                            <th>Message </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through the results and display them
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nic']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phoneno']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>