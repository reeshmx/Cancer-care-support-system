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

// Query to get the total count of system users
$sql_users = "SELECT COUNT(*) AS user_count FROM user";
$result_users = $conn->query($sql_users);
if ($result_users) {
  $row_users = $result_users->fetch_assoc();
  $user_count = $row_users['user_count'];
} else {
  $user_count = 0;
}

// Query to get the count of doctors
$sql_doctors = "SELECT COUNT(*) AS doctor_count FROM user WHERE usertype = 'Doctor'";
$result_doctors = $conn->query($sql_doctors);
if ($result_doctors) {
  $row_doctors = $result_doctors->fetch_assoc();
  $doctor_count = $row_doctors['doctor_count'];
} else {
  $doctor_count = 0;
}

// Query to get the count of patients (clients)
$sql_patients = "SELECT COUNT(*) AS patient_count FROM user WHERE usertype = 'Client'";
$result_patients = $conn->query($sql_patients);
if ($result_patients) {
  $row_patients = $result_patients->fetch_assoc();
  $patient_count = $row_patients['patient_count'];
} else {
  $patient_count = 0;
}

// Query to get the total count of orders
$sql_orders = "SELECT COUNT(*) AS order_count FROM orders";
$result_orders = $conn->query($sql_orders);
if ($result_orders) {
  $row_orders = $result_orders->fetch_assoc();
  $order_count = $row_orders['order_count'];
} else {
  $order_count = 0;
}

// Query to get the count of support programs
$sql_support_programs = "SELECT COUNT(*) AS support_program_count FROM support_programs";
$result_support_programs = $conn->query($sql_support_programs);
if ($result_support_programs) {
  $row_support_programs = $result_support_programs->fetch_assoc();
  $support_program_count = $row_support_programs['support_program_count'];
} else {
  $support_program_count = 0;
}

// Query to get the count of loan services
$sql_loan_services = "SELECT COUNT(*) AS loan_service_count FROM loan_services";
$result_loan_services = $conn->query($sql_loan_services);
if ($result_loan_services) {
  $row_loan_services = $result_loan_services->fetch_assoc();
  $loan_service_count = $row_loan_services['loan_service_count'];
} else {
  $loan_service_count = 0;
}

// Query to get the count of drugs
$sql_drugs = "SELECT COUNT(*) AS drug_count FROM drugs";
$result_drugs = $conn->query($sql_drugs);
if ($result_drugs) {
  $row_drugs = $result_drugs->fetch_assoc();
  $drug_count = $row_drugs['drug_count'];
} else {
  $drug_count = 0;
}

// Query to get distinct specifications from doctor_details
$sql_specifications = "SELECT DISTINCT Specification FROM doctor_details";
$result_specifications = $conn->query($sql_specifications);
if (!$result_specifications) {
  echo "Error fetching specifications.";
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>CSS Sidebar Menu with icons Example</title>

  <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- SideBar-Menu CSS -->
  <link rel="stylesheet" href="../css/styles.css" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />

  <script>
    $(document).ready(function() {
      $(".hamburger .hamburger__inner").click(function() {
        $(".wrapper").toggleClass("active");
      });

      $(".top_navbar .fas").click(function() {
        $(".profile_dd").toggleClass("active");
      });
    });

    // Functions to open and close both modals
    function openDoctorModal() {
      document.getElementById('doctorReportModal').style.display = 'flex';
    }

    function closeDoctorModal() {
      document.getElementById('doctorReportModal').style.display = 'none';
    }

    function openOrdersModal() {
      document.getElementById('ordersReportModal').style.display = 'flex';
    }

    function closeOrdersModal() {
      document.getElementById('ordersReportModal').style.display = 'none';
    }

    // Functions to open and close the Invoice Report Modal
    function openInvoiceModal() {
      document.getElementById('invoiceReportModal').style.display = 'flex';
    }

    function closeInvoiceModal() {
      document.getElementById('invoiceReportModal').style.display = 'none';
    }
  </script>
</head>

<body>
  <?php include './TopBar.php'; ?>

  <div class="main_container">
    <?php include './SideBar.php'; ?>

    <div class="container mt-5">
      <header class="intro">
        <h1>Dashboard</h1>
      </header>

      <!-- Boxes to display the counts -->
      <div class="data-boxes">
        <div class="box">
          <h2>System Users</h2>
          <p><?php echo $user_count; ?></p>
        </div>
        <div class="box">
          <h2>Doctors</h2>
          <p><?php echo $doctor_count; ?></p>
        </div>
        <div class="box">
          <h2>Patients</h2>
          <p><?php echo $patient_count; ?></p>
        </div>
        <div class="box">
          <h2>Orders</h2>
          <p><?php echo $order_count; ?></p>
        </div>
        <div class="box">
          <h2>Support Programs</h2>
          <p><?php echo $support_program_count; ?></p>
        </div>
        <div class="box">
          <h2>Loan Services</h2>
          <p><?php echo $loan_service_count; ?></p>
        </div>
        <div class="box">
          <h2>Drugs</h2>
          <p><?php echo $drug_count; ?></p>
        </div>
      </div>

      <!-- Box for Doctors Report -->
      <div class="Reportbox">
        <h2>Generate Doctors Report</h2>
        <button class="custom-btn" onclick="openDoctorModal()">View Doctors Report</button>
      </div>

      <!-- Box for Orders Report -->
      <div class="Reportbox">
        <h2>Generate Orders Report</h2>
        <button class="custom-btn" onclick="openOrdersModal()">View Orders Report</button>
      </div>

      <!-- Box for Invoice Report -->
      <div class="Reportbox">
        <h2>Generate Invoice Report</h2>
        <button class="custom-btn" onclick="openInvoiceModal()">View Invoice Report</button>
      </div>

      <div class="Reportbox">
        <h2>Revenue Report </h2>
        <a href="RevenueReport.php" class="custom-btn">View Revenue Report</a>
      </div>

      

      <!-- Custom Modal for Doctors Report -->
      <div id="doctorReportModal" class="custom-modal">
        <div class="custom-modal-content">
          <span class="close" onclick="closeDoctorModal()">&times;</span>
          <h2>Doctors Report</h2>
          <form action="DoctorDetailsReport.php" method="post">
            <div class="form-group">
              <label for="specification">Specification</label>
              <select id="specification" name="specification" class="custom-select" required>
                <option value="" disabled selected>Select Specification</option>
                <?php
                if ($result_specifications->num_rows > 0) {
                  while ($row_specification = $result_specifications->fetch_assoc()) {
                    echo "<option value='" . $row_specification['Specification'] . "'>" . $row_specification['Specification'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="custom-btn" onclick="closeDoctorModal()">Close</button>
              <button type="submit" class="custom-btn">Generate Report</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Custom Modal for Orders Report -->
      <div id="ordersReportModal" class="custom-modal">
        <div class="custom-modal-content">
          <span class="close" onclick="closeOrdersModal()">&times;</span>
          <h2>Orders Report</h2>
          <form action="OrdersDetailsReport.php" method="post">
            <div class="form-group">
              <label for="from_date">From Date</label>
              <input type="date" id="from_date" name="from_date" class="custom-input" required>
            </div>
            <div class="form-group">
              <label for="to_date">To Date</label>
              <input type="date" id="to_date" name="to_date" class="custom-input" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="custom-btn" onclick="closeOrdersModal()">Close</button>
              <button type="submit" class="custom-btn">Generate Report</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Custom Modal for Invoice Report -->
      <div id="invoiceReportModal" class="custom-modal">
        <div class="custom-modal-content">
          <span class="close" onclick="closeInvoiceModal()">&times;</span>
          <h2>Invoice Report</h2>
          <form action="InvoiceDetailsReport.php" method="post">
            <div class="form-group">
              <label for="invoice_from_date">From Date</label>
              <input type="date" id="invoice_from_date" name="invoice_from_date" class="custom-input" required>
            </div>
            <div class="form-group">
              <label for="invoice_to_date">To Date</label>
              <input type="date" id="invoice_to_date" name="invoice_to_date" class="custom-input" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="custom-btn" onclick="closeInvoiceModal()">Close</button>
              <button type="submit" class="custom-btn">Generate Report</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>



<style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

/* Main Container */
.main_container {
  display: flex;
  flex-direction: column;
  padding: 30px;
  margin-left: 10px;
}

/* Dashboard Header */
.intro h1 {
  font-size: 2.2rem;
  margin-bottom: 30px;
  color: #198754;
  text-align: center;
  letter-spacing: 1px;
}

/* Summary Boxes Section */
.data-boxes {
  display: flex;
  gap: 25px;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 40px;
}

.box {
  background-color: #fff;
  padding: 25px 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 260px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.box:hover {
  transform: translateY(-6px);
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
}

.box h2 {
  font-size: 1.2rem;
  color: #333;
  margin-bottom: 8px;
}

.box p {
  font-size: 2rem;
  font-weight: bold;
  color: #198754;
}

/* Report Box Section */
.Reportbox {
  display: inline-block;
  background-color: #fff;
  border-radius: 10px;
  padding: 25px 20px;
  margin: 15px;
  width: 280px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  vertical-align: top;
}

.Reportbox h2 {
  font-size: 1.2rem;
  margin-bottom: 15px;
  color: #333;
}

/* Buttons */
.custom-btn {
  padding: 10px 20px;
  background-color: #198754;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1em;
  font-weight: bold;
  transition: background-color 0.3s, transform 0.2s;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
  text-decoration: none;
  display: inline-block;
}

.custom-btn:hover {
  background-color: #28a745;
  transform: translateY(-2px);
}

/* Modal styling */
.custom-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.custom-modal-content {
  background-color: #fff;
  padding: 25px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  position: relative;
}

.custom-modal-content h2 {
  margin-top: 0;
  color: #198754;
  text-align: center;
}

.close {
  color: #aaa;
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: #000;
}

.form-group {
  margin-bottom: 18px;
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  color: #333;
  font-weight: 500;
}

.custom-select,
.custom-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1em;
}

.modal-footer {
  text-align: right;
  margin-top: 20px;
}

@media (max-width: 768px) {
  .data-boxes {
    justify-content: center;
  }

  .box,
  .Reportbox {
    width: 90%;
    margin: 10px auto;
  }

  .custom-modal-content {
    width: 90%;
  }
}

</style>