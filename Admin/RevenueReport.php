<?php 
@include '../config.php';

$from_date = '';
$to_date = '';
$error = '';
$grand_total = 0;
$revenue_data = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $from_date = $_POST['from_date'] ?? '';
    $to_date = $_POST['to_date'] ?? '';

    if (!empty($from_date) && !empty($to_date)) {

        // ✅ 1. Fetch medication revenue from orders table
        $sql_orders = "SELECT DATE(`Date`) AS order_date, SUM(Amount) AS TotalRevenue
                       FROM orders
                       WHERE Status = 'Delivered' AND Payment = 'Paid'
                       AND `Date` BETWEEN ? AND ?
                       GROUP BY order_date";
        $stmt1 = $conn->prepare($sql_orders);
        $stmt1->bind_param("ss", $from_date, $to_date);
        $stmt1->execute();
        $orders_result = $stmt1->get_result();

        while ($row = $orders_result->fetch_assoc()) {
            $date = $row['order_date'];
            $revenue_data[$date]['OrderMedication'] = $row['TotalRevenue'];
        }
        $stmt1->close();

        // ✅ 2. Fetch doctor consultation revenues separately
        $sql_docs = "SELECT DATE(ConsultedDate) AS consult_date,
                            SUM(DoctorCharge) AS TotalDoctorCharge,
                            SUM(MedicationTotalAmount) AS TotalConsultMedRevenue
                     FROM doctor_consultation_response
                     WHERE (ContactStatus = 'Completed' OR ContactStatus = 'yes')
                     AND ConsultedDate BETWEEN ? AND ?
                     GROUP BY consult_date";
        $stmt2 = $conn->prepare($sql_docs);
        $stmt2->bind_param("ss", $from_date, $to_date);
        $stmt2->execute();
        $docs_result = $stmt2->get_result();

        while ($row = $docs_result->fetch_assoc()) {
            $date = $row['consult_date'];
            $revenue_data[$date]['DoctorCharge'] = $row['TotalDoctorCharge'];
            $revenue_data[$date]['ConsultMedication'] = $row['TotalConsultMedRevenue'];
        }
        $stmt2->close();

        if (!empty($revenue_data)) {
            ksort($revenue_data);
        } else {
            $error = "No records found for this date range.";
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
<title>Revenue Report (Admin)</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

<style>
body { background-color: #f8f9fa; font-family: 'Open Sans', sans-serif; }
.header-section { background-color: #198754; color: #fff; text-align: center; padding: 30px 0; }
.container-box { background: #fff; border-radius: 10px; padding: 25px; margin-top: 40px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.btn-primary { background-color: #198754; border: none; }
.btn-primary:hover { background-color: #157347; }
.table thead { background-color: #198754; color: white; }
.print-button { background-color: #198754; color: white; border: none; padding: 8px 16px; border-radius: 5px; float: right; }
.print-button:hover { background-color: #157347; }
.btn-back { background-color: #198754; color: white; text-decoration: none; padding: 8px 18px; border-radius: 5px; transition: all 0.2s; }
.btn-back:hover { background-color: #157347; transform: translateY(-2px); }
@media print { .no-print, .header-section { display: none; } }
</style>
</head>
<body>

<section class="header-section">
    <h1><i class="fas fa-file-invoice-dollar me-2"></i>Admin Revenue Report</h1>
    <p class="mb-0">Cancer Care Support System</p>
</section>

<div class="container container-box">
    <form method="post" class="no-print text-center mb-4">
        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <label class="form-label fw-bold">From Date</label>
                <input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">To Date</label>
                <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>" class="form-control" required>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-chart-line me-2"></i>Generate Report</button>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
        </div>
    </form>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($revenue_data)): ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-success fw-bold">Report from <?php echo htmlspecialchars($from_date); ?> to <?php echo htmlspecialchars($to_date); ?></h5>
            <button class="print-button no-print" onclick="window.print();"><i class="fas fa-file-pdf me-2"></i>Download PDF</button>
        </div>

        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Medication Orders (LKR)</th>
                    <th>Consultation Medications (LKR)</th>
                    <th>Doctor Charges (LKR)</th>
                    <th>Total (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($revenue_data as $date => $data) {
                    $orderMed = $data['OrderMedication'] ?? 0;
                    $consultMed = $data['ConsultMedication'] ?? 0;
                    $doctorCharge = $data['DoctorCharge'] ?? 0;
                    $total = $orderMed + $consultMed + $doctorCharge;
                    $grand_total += $total;

                    echo "<tr>
                            <td>$date</td>
                            <td>" . number_format($orderMed, 2) . "</td>
                            <td>" . number_format($consultMed, 2) . "</td>
                            <td>" . number_format($doctorCharge, 2) . "</td>
                            <td class='fw-bold text-success'>" . number_format($total, 2) . "</td>
                          </tr>";
                }
                echo "<tr class='fw-bold bg-light'>
                        <td colspan='4'>Grand Total</td>
                        <td>" . number_format($grand_total, 2) . "</td>
                      </tr>";
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-muted">Select a date range to view the revenue details.</p>
    <?php endif; ?>
</div>

<footer class="text-center mt-5 text-muted no-print">
    <p>&copy; <?php echo date("Y"); ?> Cancer Care Support. All Rights Reserved.</p>
</footer>

<?php if ($conn) $conn->close(); ?>
</body>
</html>




