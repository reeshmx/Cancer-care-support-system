<?php
@include '../config.php';
session_start();

if (!isset($_SESSION['user_NIC'])) {
    header('location: ../Login.php');
    exit();
}

$doctor_nic = $_SESSION['user_NIC'];
$from_date = '';
$to_date = '';
$result = null;
$stmt = null;
$error = '';
$grand_total = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $from_date = $_POST['from_date'] ?? '';
    $to_date = $_POST['to_date'] ?? '';

    if (!empty($from_date) && !empty($to_date)) {
        $sql = "SELECT DATE(ConsultedDate) AS consult_date,
                       SUM(DoctorCharge) AS TotalRevenue
                FROM doctor_consultation_response
                WHERE Doctor_NIC = ?
                  AND ContactStatus = 'yes'
                  AND ConsultedDate BETWEEN ? AND ?
                GROUP BY consult_date
                ORDER BY consult_date ASC";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $doctor_nic, $from_date, $to_date);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
            } else {
                $error = "Error executing query: " . $stmt->error;
            }
        } else {
            $error = "Error preparing query: " . $conn->error;
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
<title>Doctor Revenue Report | Cancer Care Support</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap and Theme -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">

<style>
body {
  background-color: #f8f9fa;
  font-family: 'Open Sans', sans-serif;
}
.header-section {
  background-color: #198754;
  color: white;
  padding: 40px 0;
  text-align: center;
}
.header-section h1 {
  font-weight: 700;
  margin: 0;
}
.container-box {
  background: #fff;
  border-radius: 10px;
  padding: 30px;
  margin-top: 40px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.btn-primary {
  background-color: #198754;
  border: none;
}
.btn-primary:hover {
  background-color: #157347;
}
.btn-outline-success {
  color: #198754;
  border-color: #198754;
}
.btn-outline-success:hover {
  background-color: #198754;
  color: white;
}
.table thead {
  background-color: #198754;
  color: white;
}
.print-button {
  background-color: #198754;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 5px;
  float: right;
}
.print-button:hover {
  background-color: #157347;
}
@media print {
  .no-print, .header-section {
    display: none;
  }
  .container-box {
    box-shadow: none;
    border: none;
  }
}
</style>
</head>

<body>

<!-- Header -->
<section class="header-section">
  <h1><i class="fas fa-file-invoice-dollar me-2"></i>Doctor Revenue Report</h1>
  <p class="mb-0">Cancer Care Support System</p>
</section>

<!-- Main Container -->
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
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-chart-line me-1"></i> Generate Report</button>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-outline-success"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
    </div>
  </form>

  <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if ($result): ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="text-success">Revenue Report from <?php echo htmlspecialchars($from_date); ?> to <?php echo htmlspecialchars($to_date); ?></h4>
      <button class="print-button no-print" onclick="window.print();"><i class="fas fa-file-pdf me-2"></i>Download PDF</button>
    </div>

    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th>Date</th>
          <th>Total Revenue (LKR)</th>
        </tr>
      </thead>
      <tbody>
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $grand_total += $row['TotalRevenue'];
              echo "<tr>
                      <td>{$row['consult_date']}</td>
                      <td>" . number_format($row['TotalRevenue'], 2) . "</td>
                    </tr>";
          }
          echo "<tr class='fw-bold bg-light'>
                  <td>Total</td>
                  <td>" . number_format($grand_total, 2) . "</td>
                </tr>";
      } else {
          echo "<tr><td colspan='2' class='text-muted'>No revenue records found for the selected period.</td></tr>";
      }
      ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-center text-secondary">Select a date range to view your revenue report.</p>
  <?php endif; ?>
</div>

<?php
if ($stmt) $stmt->close();
$conn->close();
?>

<!-- Footer -->
<footer class="text-center mt-5 text-muted no-print">
  <p>&copy; <?php echo date("Y"); ?> Cancer Care Support. All Rights Reserved.</p>
</footer>

</body>
</html>


