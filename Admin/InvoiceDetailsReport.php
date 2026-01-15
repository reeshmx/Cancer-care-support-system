<?php
@include '../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_name'])) {
    header('location: ../Login.php');
    exit();
}

$from_date = '';
$to_date = '';
$result = null;
$error = '';
$total_amount = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from_date = $_POST['invoice_from_date'] ?? '';
    $to_date = $_POST['invoice_to_date'] ?? '';

    if (!empty($from_date) && !empty($to_date)) {
        $sql = "SELECT InvoiceID, OrderID, PatientName, NIC, Amount, Date 
                FROM invoice 
                WHERE Date BETWEEN ? AND ? 
                ORDER BY Date";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $from_date, $to_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = "No invoices found for the given date range.";
        }
    } else {
        $error = "Please select both From and To dates.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice Report (Admin)</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
.intro { background-color: #198754; color: #fff; text-align: center; padding: 20px 0; }
.container { width: 90%; margin: 30px auto; background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
form { margin-bottom: 20px; }
label { font-weight: bold; }
input[type="date"] { padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
button { background-color: #198754; color: #fff; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; }
button:hover { background-color: #157347; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
th { background-color: #198754; color: #fff; }
tr:nth-child(even) { background-color: #f9f9f9; }
.print-button { background-color: #198754; color: #fff; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; margin-top: 10px; }
.no-data { text-align: center; color: #777; font-style: italic; }
.total-row { font-weight: bold; background-color: #e9f5ee; }
@media print { .intro, form, .print-button { display: none; } }
</style>
</head>
<body>
<header class="intro">
    <h1>Admin Invoice Report</h1>
</header>

<div class="container">
    <form method="post">
        <label>From: <input type="date" name="invoice_from_date" value="<?php echo htmlspecialchars($from_date); ?>" required></label>
        &nbsp;
        <label>To: <input type="date" name="invoice_to_date" value="<?php echo htmlspecialchars($to_date); ?>" required></label>
        &nbsp;
        <button type="submit">Generate Report</button>
    </form>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <h3>Report from <?php echo htmlspecialchars($from_date); ?> to <?php echo htmlspecialchars($to_date); ?></h3>
        <button class="print-button" onclick="window.print();">Download PDF</button>

        <table>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Order ID</th>
                    <th>Patient Name</th>
                    <th>NIC</th>
                    <th>Amount (LKR)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): 
                    $total_amount += $row['Amount']; ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['InvoiceID']); ?></td>
                        <td><?php echo htmlspecialchars($row['OrderID']); ?></td>
                        <td><?php echo htmlspecialchars($row['PatientName']); ?></td>
                        <td><?php echo htmlspecialchars($row['NIC']); ?></td>
                        <td><?php echo number_format($row['Amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['Date']); ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="total-row">
                    <td colspan="4">Total</td>
                    <td colspan="2"><strong><?php echo number_format($total_amount, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)): ?>
        <p class="no-data">No invoices found for the selected dates.</p>
    <?php else: ?>
        <p style="color:#555;">Select a date range to generate the report.</p>
    <?php endif; ?>

    <div class="actions">
    <a href="index.php" class="btn-back">⬅ Back to Report Page</a>
</div>

<style>
.actions {
    text-align: center;
    margin-top: 20px;
}

.btn-back {
    display: inline-block;
    background-color: #1c7430; /* Deep green */
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
}

.btn-back:hover {
    background-color: #28a745; /* Lighter green on hover */
    transform: translateY(-2px);
}
</style>

</div>

<?php
if ($stmt) $stmt->close();
if ($conn) $conn->close();
?>
</body>
</html>
