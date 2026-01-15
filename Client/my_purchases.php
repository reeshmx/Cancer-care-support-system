<?php
@include '../config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_NIC'])) {
    header('location: ../Login.php');
    exit();
}

$NIC = $_SESSION['user_NIC'];

// Fetch past medication orders for this user
$query = "SELECT * FROM orders WHERE NIC = '$NIC' ORDER BY Date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Past Medications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f8fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px 30px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #0078D7;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-orders {
            text-align: center;
            font-size: 18px;
            color: #777;
            margin-top: 20px;
        }
        .back-btn {
            display: inline-block;
            background: #0078D7;
            color: white;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }
        .back-btn:hover {
            background: #005bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Past Medication Orders</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item List</th>
                        <th>Amount (Rs)</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['OrderID']; ?></td>
                            <td><?php echo htmlspecialchars($row['ItemList']); ?></td>
                            <td><?php echo number_format($row['Amount'], 2); ?></td>
                            <td><?php echo $row['Method']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo $row['Payment']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['Comment']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="no-orders">You have not purchased any medications yet.</div>
        <?php } ?>

        <div style="text-align:center;">
            <a href="Medications.php" class="back-btn">← Back to Medications</a>
        </div>
    </div>
</body>
</html>

