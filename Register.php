<?php
ob_start(); // Start output buffering
@include 'config.php';
session_start();

// Handle form submission
if (isset($_POST['submit'])) {

    // ✅ Ensure privacy agreement is checked
    if (empty($_POST['agree_privacy'])) {
        $error[] = 'You must agree to the Privacy Policy and Terms of Service before registering.';
    } else {
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
        $nic = mysqli_real_escape_string($conn, $_POST['nic']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $confirmPassword = md5($_POST['confirmPassword']);
        $usertype = 'Client';

        $select = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'Email already registered!';
        } elseif ($password !== $confirmPassword) {
            $error[] = 'Password and confirm password do not match!';
        } else {
            $insert = "INSERT INTO user (FirstName, LastName, NIC, Email, Password, usertype) 
                       VALUES ('$firstName', '$lastName', '$nic', '$email', '$password', '$usertype')";
            
            if (mysqli_query($conn, $insert)) {
                ob_clean(); // ✅ Ensure no previous output before redirect
                header('Location: login.php?msg=success');
                exit();
            } else {
                $error[] = 'Registration failed. Please try again.';
            }
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
    <title>Register Now - Cancer Care</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-image: url(./img/loginBG.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            animation: movingBackground 20s infinite linear;
        }

        @keyframes movingBackground {
            0% { background-position: 0% 100%; }
            50% { background-position: 100% 0%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .container .form {
            background: rgba(255, 255, 255, 0.9);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .container .form-control {
            height: 50px;
            width: 95%;
            display: flex;
            font-size: 18px;
            margin-top: 20px;
            border-radius: 10px;
            border: 2px solid #444;
            padding-left: 15px;
        }

        .container .form form .button {
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .container .form form .button:hover {
            background: #03ff1cbd;
        }

        .alert {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .text-center-head {
            text-align: center;
            font-size: 30px;
            color: #28a745;
        }

        .signup-link {
            margin-top: 10px;
            text-align: center;
            font-size: 15px;
        }

        .form-check {
            margin-top: 15px;
            font-size: 15px;
        }

        .form-check a {
            color: #198754;
            text-decoration: none;
        }

        .form-check a:hover {
            text-decoration: underline;
        }

        .homeIcon {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .homeIcon a {
            color: #198754;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form login-form">
            <form action="#" method="POST">
                <?php
                if (isset($error)) {
                    foreach ($error as $errorMsg) {
                        echo '<div class="alert">' . $errorMsg . '</div>';
                    }
                }
                ?>

                <h2 class="text-center-head">Register</h2>

                <div class="form-group">
                    <input required type="text" name="firstName" class="form-control" placeholder="Enter Patient's First Name">
                </div>

                <div class="form-group">
                    <input required type="text" name="lastName" class="form-control" placeholder="Enter Patient's Last Name">
                </div>

                <div class="form-group">
                    <input required type="text" name="nic" class="form-control" placeholder="Enter Patient's NIC">
                </div>

                <div class="form-group">
                    <input required type="email" name="email" class="form-control" placeholder="Enter Email">
                </div>

                <div class="form-group">
                    <input required type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>

                <div class="form-group">
                    <input required type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
                </div>

                <!-- ✅ Privacy & Terms Agreement -->
                <div class="form-check mt-3 mb-2">
                    <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_privacy" value="1" required>
                    <label class="form-check-label" for="agree_terms">
                        I agree to the 
                        <a href="privacy_policy_public.php" target="_blank" class="text-success">Privacy Policy</a> 
                        and 
                        <a href="terms_public.php" target="_blank" class="text-success">Terms of Service</a>.
                    </label>
                </div>

                <div class="form-group">
                    <input class="form-control button" type="submit" name="submit" value="Register">
                </div>

                <div class="signup-link">
                    Already have an account? <a href="login.php">Login here</a>
                </div>

                <div class="homeIcon">
                    <a href="./index.html"><i class="fa fa-home" style="font-size: 36px"></i></a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

