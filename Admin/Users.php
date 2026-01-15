<?php
@include '../config.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (isset($_SESSION['admin_name'])) {
    $admin_name = $_SESSION['admin_name'];
} else {
    header('location: ../Login.php');
    exit();
}

// Notification variable
$notification = '';
$notification_type = ''; // 'success' or 'danger'

// Add, Update, or Delete user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new user
    if (isset($_POST['action']) && $_POST['action'] == 'addUser') {
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $nic = $_POST['NIC'];
        $email = $_POST['Email'];
        $password = md5($_POST['Password']);
        $usertype = $_POST['usertype'];
        $status = 1;

        $sql = "INSERT INTO user (FirstName, LastName, NIC, Email, Password, usertype, status)
                VALUES ('$firstName', '$lastName', '$nic', '$email', '$password', '$usertype', '$status')";

        if ($conn->query($sql) === TRUE) {
            $notification = "✅ New user added successfully.";
            $notification_type = "success";

            // If Doctor, insert into doctor_details
            if ($usertype == "Doctor") {
                $doctorName = $firstName . ' ' . $lastName;
                $doctorSql = "INSERT INTO doctor_details (Doctor_Name, NIC, Email) VALUES ('$doctorName', '$nic', '$email')";
                if ($conn->query($doctorSql) === TRUE) {
                    $notification .= " Doctor details added successfully.";
                } else {
                    $notification .= " ⚠️ Error adding doctor details: " . $conn->error;
                    $notification_type = "danger";
                }
            }
        } else {
            $notification = "❌ Error adding user: " . $conn->error;
            $notification_type = "danger";
        }
    }

    // Update user
    elseif (isset($_POST['action']) && $_POST['action'] == 'updateUser') {
    $userId = $_POST['userId'];
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];

    // NIC intentionally excluded — cannot be changed
    $sql = "UPDATE user SET FirstName='$firstName', LastName='$lastName', Email='$email' WHERE id=$userId";

    if ($conn->query($sql) === TRUE) {
        $notification = "✅ User updated successfully.";
        $notification_type = "success";
    } else {
        // Friendly message for any unexpected issue
        if (strpos($conn->error, 'Duplicate entry') !== false && strpos($conn->error, 'Email') !== false) {
            $notification = "⚠️ This email already exists. Please use a different email address.";
        } else {
            $notification = "❌ Error updating user. NIC cannot be modified for security and data integrity reasons.";
        }
        $notification_type = "danger";
    }
}


    // Delete user (soft delete)
    elseif (isset($_POST['action']) && $_POST['action'] == 'deleteUser') {
        $userId = $_POST['userId'];
        $sql = "UPDATE user SET status = 5 WHERE id = $userId";

        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
        exit();
    }
}

// Retrieve all active users
$users_sql = "SELECT * FROM user WHERE status != 5";
$users_result = $conn->query($users_sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Manage System Users</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script>
        $(document).ready(function() {
            $(".hamburger .hamburger__inner").click(function() {
                $(".wrapper").toggleClass("active");
            });
            $(".top_navbar .fas").click(function() {
                $(".profile_dd").toggleClass("active");
            });
        });
    </script>
</head>

<style>
    body {
        background-color: #f8f9fa;
    }

    .main_container {
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    header.intro {
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    #userTable {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .alert {
        margin-top: 20px;
    }
</style>

<body>
    <?php include './TopBar.php'; ?>

    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container">
            <header class="intro">
                <h1>System Users</h1>
            </header>

            <!-- Notifications -->
            <?php if (!empty($notification)): ?>
                <div class="alert alert-<?php echo $notification_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $notification; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form id="userForm" method="POST" action="">
                <input type="hidden" id="userId" name="userId" value="">
                <div class="form-group">
                    <label for="FirstName">First Name:</label>
                    <input type="text" class="form-control" id="FirstName" name="FirstName" required>
                </div>
                <div class="form-group">
                    <label for="LastName">Last Name:</label>
                    <input type="text" class="form-control" id="LastName" name="LastName" required>
                </div>
                <div class="form-group">
                    <label for="NIC">NIC:</label>
                    <input type="text" class="form-control" id="NIC" name="NIC" required>
                </div>
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="email" class="form-control" id="Email" name="Email" required>
                </div>
                <div class="form-group" id="usertypeDiv">
                    <label for="usertype">User Type:</label>
                    <select class="form-control" id="usertype" name="usertype">
                        <option value="Admin">Admin</option>
                        <option value="Doctor">Doctor</option>
                    </select>
                </div>
                <div class="form-group" id="passwordDiv">
                    <label for="Password">Password:</label>
                    <input type="password" class="form-control" id="Password" name="Password" required>
                </div>
                <input type="hidden" id="action" name="action" value="addUser">
                <button type="submit" class="btn btn-success" id="submitButton">Add User</button>
                <button type="button" class="btn btn-secondary" id="returnToAddButton" style="display: none;">Return to Add</button>
            </form>

            <h2 class="mt-5">All Users</h2>

            <!-- Filters -->
            <div class="form-row mb-3">
                <div class="form-group col-md-4">
                    <label for="nameFilter">Filter by Name</label>
                    <input type="text" id="nameFilter" class="form-control" placeholder="Type name...">
                </div>
                <div class="form-group col-md-4">
                    <label for="usertypeFilter">Filter by User Type</label>
                    <select id="usertypeFilter" class="form-control">
                        <option value="All">All</option>
                        <option value="Admin">Admin</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Client">Client</option>
                    </select>
                </div>
                <div class="form-group col-md-4 d-flex align-items-end">
                    <button id="clearFilters" class="btn btn-secondary ml-auto">Clear</button>
                </div>
            </div>

            <table id="userTable" class="table table-bordered mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>NIC</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users_result->num_rows > 0): ?>
                        <?php while ($row = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td class="firstName"><?php echo $row['FirstName']; ?></td>
                                <td class="lastName"><?php echo $row['LastName']; ?></td>
                                <td class="nic"><?php echo $row['NIC']; ?></td>
                                <td class="email"><?php echo $row['Email']; ?></td>
                                <td class="usertype"><?php echo $row['usertype']; ?></td>
                                <td>
                                    <button class="btn btn-warning edit-btn" data-id="<?php echo $row['id']; ?>">Edit</button>
                                    <button class="btn btn-danger delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<script>
    $(document).ready(function() {
        function filterUsers() {
            var nameValue = $("#nameFilter").val().toLowerCase();
            var userTypeValue = $("#usertypeFilter").val();
            var found = false;

            $("#userTable tbody tr").each(function() {
                var firstName = $(this).find(".firstName").text().toLowerCase();
                var lastName = $(this).find(".lastName").text().toLowerCase();
                var userType = $(this).find(".usertype").text();

                if (
                    (firstName.includes(nameValue) || lastName.includes(nameValue)) &&
                    (userTypeValue === "All" || userType === userTypeValue)
                ) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });

            if (!found) {
                $("#userTable tbody").append('<tr><td colspan="6" class="text-center">No users found</td></tr>');
            }
        }

        $("#nameFilter").on("keyup", filterUsers);
        $("#usertypeFilter").on("change", filterUsers);

        $('#clearFilters').click(function() {
            $('#nameFilter').val('');
            $('#usertypeFilter').val('All');
            location.reload();
        });

        $(document).on("click", ".edit-btn", function() {
    var row = $(this).closest("tr");
    var userId = $(this).data("id");
    $("#userId").val(userId);
    $("#FirstName").val(row.find(".firstName").text());
    $("#LastName").val(row.find(".lastName").text());
    $("#NIC").val(row.find(".nic").text()).prop('disabled', true); // Disable NIC
    $("#Email").val(row.find(".email").text());
    $("#usertype").val(row.find(".usertype").text()).prop('disabled', true);
    $("#Password").val("").prop('required', false);
    $("#usertypeDiv").hide();
    $("#passwordDiv").hide();
    $("#action").val("updateUser");
    $("#submitButton").text("Update User");
    $("#returnToAddButton").show();
});


        $("#returnToAddButton").on("click", function() {
            $("#userForm")[0].reset();
            $("#userId").val('');
            $("#usertype").prop('disabled', false);
            $("#Password").prop('required', true);
            $("#usertypeDiv").show();
            $("#passwordDiv").show();
            $("#action").val("addUser");
            $("#submitButton").text("Add User");
            $("#returnToAddButton").hide();
        });

        $(document).on("click", ".delete-btn", function() {
            if (confirm("Are you sure you want to delete this user?")) {
                var userId = $(this).data("id");
                $.post("", {
                    action: "deleteUser",
                    userId: userId
                }, function(response) {
                    alert(response);
                    location.reload();
                });
            }
        });
    });
</script>

</html>
