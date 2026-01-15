<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as an admin
if (isset($_SESSION['admin_name'])) {
    $admin_name = $_SESSION['admin_name'];
    $user_nic = $_SESSION['user_NIC'];
} else {
    // Redirect to the login page if not logged in as admin
    header('location: Login.php');
    exit();
}

// Handle password change request
if (isset($_POST['change_password'])) {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Encrypt passwords for comparison and storage
    $current_password_hash = md5($current_password);
    $new_password_hash = md5($new_password);

    // Check if new password matches the confirm password
    if ($new_password != $confirm_password) {
        $error[] = "New password and confirm password do not match!";
    } else {
        // Query to check if the current password is correct
        $select = "SELECT * FROM user WHERE NIC = '$user_nic' AND password = '$current_password_hash'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            // Update password if current password is correct
            $update = "UPDATE user SET password = '$new_password_hash' WHERE NIC = '$user_nic'";
            $update_result = mysqli_query($conn, $update);

            if ($update_result) {
                $success_message = "Password changed successfully!";
            } else {
                $error[] = "Failed to change the password. Please try again.";
            }
        } else {
            $error[] = "Incorrect current password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- fa fa icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Style as you wish, similar to the login page */
        /* Example styles */
        body {
            background-image: url(../img/loginBG.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form {
            background: rgba(255, 255, 255, 0.7);
            padding: 30px 35px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .form-control {
            height: 50px;
            width: 95%;
            display: flex;
            margin-top: 20px;
            border-radius: 15px;
            border: 2px solid #393939;
            padding-left: 15px;
        }

        .button {
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-top: 15px;
        }

        .button:hover {
            background: #03ff1cbd;
        }

        .alert {
            color: red;
            text-align: center;
            margin-top: 16px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form">
            <h2 class="text-center">Change Password</h2>

            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<div class="alert">' . $error . '</div>';
                }
            }
            if (isset($success_message)) {
                echo '<div class="success-message">' . $success_message . '</div>';
            }
            ?>

            <form action="#" method="POST">
                <div class="form-group">
                    <input required="" type="password" name="current_password" class="form-control" placeholder="Enter Current Password">
                </div>
                <div class="form-group">
                    <input required="" type="password" name="new_password" class="form-control" placeholder="Enter New Password">
                </div>
                <div class="form-group">
                    <input required="" type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password">
                </div>

                <div class="form-group">
                    <input class="form-control button" type="submit" name="change_password" value="Change Password">
                </div>

                <div class="homeIcon" style="text-align:center;">
                    <a href="../index.html"><i class="fa fa-home" style="font-size: 36px"></i></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>