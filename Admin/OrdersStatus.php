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

// Fetch orders where Comment is empty or NULL
$sql = "SELECT * FROM orders WHERE Comment IS NULL OR Comment = ''";
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

        .action-btn,
        .save-btn {
            width: 35px;
            height: 35px;
            padding: 0;
            font-size: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .save-btn {
            color: #fff;
            background-color: #007bff;
            border: none;
            cursor: pointer;
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
        });

        // Function to update comment via AJAX
        function updateComment(orderId) {
            var comment = $("#comment_" + orderId).val();
            $.ajax({
                url: 'update_comment.php',
                type: 'POST',
                data: {
                    order_id: orderId,
                    comment: comment
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Failed to update comment.');
                }
            });
        }

        function updateStatus(orderId, Payment) {
            $.ajax({
                url: 'update_order_status.php',
                type: 'POST',
                data: {
                    order_id: orderId,
                    Payment: Payment
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Failed to update Payment.');
                }
            });
        }

        function updateDeliveryStatus(orderId, status) {
            $.ajax({
                url: 'update_Delivery_status.php',
                type: 'POST',
                data: {
                    order_id: orderId,
                    status: status
                },
                success: function(response) {
                    location.reload(); // Reload the page to show updated status
                },
                error: function() {
                    alert('Failed to update status.');
                }
            });
        }


        // Function to mark as paid via AJAX
        function markAsPaid(orderId) {
            $.ajax({
                url: 'update_order_status.php',
                type: 'POST',
                data: {
                    order_id: orderId,
                    Payment: 'Paid'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Failed to mark as paid.');
                }
            });
        }
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

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>NIC</th>
                            <th>Item List</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>

                            <th>Delivery</th>
                            <th>Pay</th>
                            <th>Comment</th>
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

                                // Delivery Column - Show text or icons based on the status
                                echo "<td>";
                                if ($row['Status'] == 'Delivered' || $row['Status'] == 'Rejected') {
                                    echo htmlspecialchars($row['Status']);
                                } else {
                                    echo "<button class='btn btn-success action-btn' onclick=\"updateDeliveryStatus(" . $row['OrderID'] . ", 'Delivered')\"><i class='fas fa-check'></i></button>
                                          <button class='btn btn-danger action-btn' onclick=\"updateDeliveryStatus(" . $row['OrderID'] . ", 'Rejected')\"><i class='fas fa-times'></i></button>";
                                }
                                echo "</td>";

                                // Payment Status
                                if ($row['Payment'] === 'Paid') {
                                    echo "<td>Paid</td>";
                                } else {
                                    echo "<td><button class='btn btn-warning action-btn' onclick=\"markAsPaid(" . $row['OrderID'] . ")\">Paid</button></td>";
                                }
                                echo "<td>
                                <div class='input-group'>
                                    <div class='input-group-prepend'>
                                        <button class='save-btn' onclick=\"updateComment(" . $row['OrderID'] . ")\"><i class='fas fa-save'></i></button>
                                    </div>
                                    <input type='text' id='comment_" . $row['OrderID'] . "' class='form-control' placeholder='' value='" . htmlspecialchars($row['Comment']) . "' />
                                </div>
                              </td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No orders found</td></tr>";
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