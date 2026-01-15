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

// Fetch orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Orders - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/demo.css" />
    <style>
        .table-responsive {
            margin: 0 auto;
            width: 110%;
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            padding: 0;
            font-size: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-box {
            width: 30%;
            margin: 15px 0;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".hamburger .hamburger__inner").click(function() {
                $(".wrapper").toggleClass("active");
            });
            $(".top_navbar .fas").click(function() {
                $(".profile_dd").toggleClass("active");
            });

            // Filter table rows by NIC as the user types
            $("#searchNIC").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#ordersTable tbody tr").filter(function() {
                    $(this).toggle($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</head>

<body>
    <?php include './TopBar.php'; ?>
    <div class="main_container">
        <?php include './SideBar.php'; ?>

        <div class="container py-3">
            <header class="intro text-center">
                <h1 class="text-primary">Order Details</h1>
            </header>

            <!-- Search Box for NIC -->
            <input type="text" id="searchNIC" class="form-control search-box" placeholder="Search by NIC">

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="ordersTable">
                    <thead class="thead-dark">
                        <tr>
                            <th> ID</th>
                            <th>NIC</th>
                            <th>Item List</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['OrderID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['NIC']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ItemList']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Amount']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Method']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Comment']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Payment']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No orders found</td></tr>";
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