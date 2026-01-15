<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and retrieve doctor name and NIC
if (isset($_SESSION['doctor_name'], $_SESSION['user_NIC'])) {
    $doctor_name = $_SESSION['doctor_name']; // Get doctor name from session
    $user_nic = $_SESSION['user_NIC'];

    // Retrieve doctor's details from the database
    $query = "SELECT * FROM doctor_details WHERE NIC = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $user_nic);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $doctor_data = $result->fetch_assoc(); // Fetch doctor data as an associative array
            } else {
                echo "No records found for NIC: " . htmlspecialchars($user_nic);
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Process form submission to update doctor details
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $doctor_name = $_POST['Doctor_Name'];
        $age = $_POST['Age'];
        $gender = $_POST['Gender'];
        $phone_no = $_POST['PhoneNo'];
        $address = $_POST['Address'];
        $nic = $_POST['NIC'];
        $email = $_POST['Email'];
        $dob = $_POST['DOB'];
        $specification = $_POST['Specification'];
        $qualification = $_POST['Qualification'];
        $self_description = $_POST['Self_Description'];

        // Initialize $photo_dest to use existing photo by default
        $photo_dest = $doctor_data['Photo'];

        // Handle file upload if a new photo is submitted
        if (isset($_FILES['Photo']) && $_FILES['Photo']['error'] == 0) {
            $photo_name = basename($_FILES['Photo']['name']);
            $photo_tmp = $_FILES['Photo']['tmp_name'];
            $photo_dest = "../img/DoctorImage/" . $photo_name; // Change the destination path

            // Move the uploaded file to the designated directory
            if (move_uploaded_file($photo_tmp, $photo_dest)) {
                // File successfully uploaded
            } else {
                echo "Error uploading photo.";
            }
        }

        // Update doctor details in the database
        $update_query = "UPDATE doctor_details SET Doctor_Name=?, Age=?, Gender=?, PhoneNo=?, Address=?, NIC=?, Email=?, DOB=?, Specification=?, Qualification=?, Photo=?, Self_Description=? WHERE NIC=?";
        $update_stmt = $conn->prepare($update_query);

        if ($update_stmt) {
            $update_stmt->bind_param("sssssssssssss", $doctor_name, $age, $gender, $phone_no, $address, $nic, $email, $dob, $specification, $qualification, $photo_dest, $self_description, $user_nic);
            if ($update_stmt->execute()) {
                // Redirect or display success message after updating
                echo "<p>Profile updated successfully.</p>";
            } else {
                echo "Error updating profile: " . $update_stmt->error;
            }
        } else {
            echo "Error preparing update statement: " . $conn->error;
        }
    }
} else {
    // Redirect to the login page if not logged in as a doctor
    header('location: ../Login.php');
    exit();
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
    <style>
        .form-background {
            background-color: #f7f9fc;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include './TopBar.php'; ?>
    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container">
            <header class="intro">
                <h1>Doctor Profile</h1>
            </header>

            <div class="form-background">
                <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="Doctor_Name">Doctor Name</label>
                            <input type="text" class="form-control" id="Doctor_Name" name="Doctor_Name" value="<?php echo htmlspecialchars($doctor_data['Doctor_Name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Age">Age</label>
                            <input type="number" class="form-control" id="Age" name="Age" value="<?php echo htmlspecialchars($doctor_data['Age'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Gender">Gender</label>
                            <select class="form-control" id="Gender" name="Gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo (isset($doctor_data['Gender']) && $doctor_data['Gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo (isset($doctor_data['Gender']) && $doctor_data['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo (isset($doctor_data['Gender']) && $doctor_data['Gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="PhoneNo">Phone Number</label>
                            <input type="text" class="form-control" id="PhoneNo" name="PhoneNo" value="<?php echo htmlspecialchars($doctor_data['PhoneNo'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" id="Address" name="Address" value="<?php echo htmlspecialchars($doctor_data['Address'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="NIC">NIC</label>
                            <input type="text" class="form-control" id="NIC" name="NIC" value="<?php echo htmlspecialchars($doctor_data['NIC'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email" value="<?php echo htmlspecialchars($doctor_data['Email'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="DOB">Date of Birth</label>
                            <input type="date" class="form-control" id="DOB" name="DOB" value="<?php echo htmlspecialchars($doctor_data['DOB'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Specification">Specification</label>
                            <input type="text" class="form-control" id="Specification" name="Specification" value="<?php echo htmlspecialchars($doctor_data['Specification'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="Qualification">Qualification</label>
                            <input type="text" class="form-control" id="Qualification" name="Qualification" value="<?php echo htmlspecialchars($doctor_data['Qualification'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Photo">Photo</label>
                            <input type="file" class="form-control" id="Photo" name="Photo">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Self_Description">Self Description</label>
                            <textarea class="form-control" id="Self_Description" name="Self_Description"><?php echo htmlspecialchars($doctor_data['Self_Description'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>