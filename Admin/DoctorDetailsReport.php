<?php
// DoctorDetailsReport.php

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected specification from the form
    $selected_specification = $_POST['specification'];

    // Prepare and execute query to fetch doctor details by specification
    $sql = "SELECT Doctor_Name, Email, Specification, Qualification, Self_Description FROM doctor_details WHERE Specification = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_specification);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Report</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 128, 0, 0.15);
            padding: 30px 40px;
        }

        h2 {
            text-align: center;
            color: #0a7e07;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .report-info {
            text-align: center;
            color: #555;
            font-size: 16px;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 8px;
        }

        th {
            background-color: #0a7e07;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 15px;
        }

        td {
            background-color: #f9f9f9;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        tr:hover td {
            background-color: #eafaea;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #888;
            font-weight: 500;
            background: #fdfdfd;
        }

        .btn-back {
            display: inline-block;
            background-color: #0a7e07;
            color: #fff;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background-color: #066b05;
        }

        .actions {
            text-align: right;
            margin-top: 20px;
        }

        @media print {
            .btn-back, .actions {
                display: none;
            }
            body {
                background: white;
            }
            .container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
    <script>
        // Auto print when the page loads
        function printReport() {
            window.print();
        }
    </script>
</head>

<body onload="printReport()">
    <div class="container">
        <h2>Doctor Details Report</h2>
        <p class="report-info">Specification: <strong><?php echo htmlspecialchars($selected_specification); ?></strong></p>

        <table>
            <tr>
                <th>Doctor Name</th>
                <th>Email</th>
                <th>Qualification</th>
                <th>Self Description</th>
            </tr>

            <?php
            // Display doctor details
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['Doctor_Name']) . "</td>
                            <td>" . htmlspecialchars($row['Email']) . "</td>
                            <td>" . htmlspecialchars($row['Qualification']) . "</td>
                            <td>" . htmlspecialchars($row['Self_Description']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='no-data'>No doctors found for this specification.</td></tr>";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
            ?>
        </table>

        <div class="actions">
            <a href="index.php" class="btn-back">⬅ Back to Report Page</a>
        </div>
    </div>
</body>

</html>

<?php
} else {
    echo "Invalid request method.";
}
?>
