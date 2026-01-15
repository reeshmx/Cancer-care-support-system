<?php

// Including the 'config.php' file
@include 'config.php';

// Starting the session
session_start();

// Checking if the form is submitted
if (isset($_POST['submit'])) {

    // Sanitizing and escaping the NIC input
    $NIC = mysqli_real_escape_string($conn, $_POST['NIC']);

    // Encrypting the password using the md5 hash function
    $pass = md5($_POST['password']);

    // Query to check if the NIC and password match an entry in the 'staff_login' table
    $select = "SELECT * FROM user WHERE NIC = '$NIC' && password = '$pass'";

    $result = mysqli_query($conn, $select);

    // Checking if any rows were returned
    if (mysqli_num_rows($result) > 0) {

        // Fetching the data from the result
        $row = mysqli_fetch_array($result);

        // Storing NIC in the session
        $_SESSION['user_NIC'] = $row['NIC'];

        // Storing user name in the session
        if ($row['usertype'] == 'Admin') {  // admin
            $_SESSION['admin_name'] = $row['LastName'];
            header('location: ./Admin/index.php');
        } elseif ($row['usertype'] == 'Client') {   // client
            $_SESSION['client_name'] = $row['LastName'];
            header('location: ./Client/index.php');
        } elseif ($row['usertype'] == 'Doctor') {
            $_SESSION['doctor_name'] = $row['LastName'];  // Doctor
            header('location: ./Doctor/index.php');
        }
    } else {
        // If no matching rows were found, setting an error message
        $error[] = '!!! Incorrect NIC or Password !!! <br> Forgot Details? Please Contact 1577';
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Now</title>

    <!-- fa fa icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            /* Background Styles */
            background-image: url(./img/loginBG.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            animation: movingBackground 20s infinite linear;
        }

        /* Keyframes for Background Animation */
        @keyframes movingBackground {
            0% {
                background-position: 0% 100%;
            }

            50% {
                background-position: 100% 0%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Container Styles */
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Form Styles */
        .container .form {
            background: rgba(255, 255, 255, 0.71);
            padding: 30px 35px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        /* Form Control Styles */
        .container .form-control {
            height: 50px;
            /* Adjusted height */
            width: 95%;
            /* Adjusted width */
            display: flex;
            position: relative;
            font-size: 18px;
            /* Adjusted font size */
            margin-top: 20px;
            border-radius: 15px;
            /* Adjusted border radius */
            border: 2px solid #393939;
            /* Adjusted border width and color */
            padding-left: 15px;
            /* Adjusted padding */
        }

        /* Forget Password Styles */
        .container .form form .forget-pass {
            margin: 10px 0 20px 0;
            /* Adjusted margin */
        }

        .container .form form .forget-pass a {
            font-size: 15px;
        }

        /* Button Styles */
        .container .form form .button {
            height: 50px;
            /* Adjusted height */
            font-size: 20px;
            /* Adjusted font size */
            font-weight: bold;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            display: inline-block;
            margin-top: 15px;
            /* Adjusted margin-top */
        }

        /* Button Hover Styles */
        .container .form form .button:hover {
            background: #03ff1cbd;
        }

        /* Link Styles */
        .container .form form .link {
            margin-top: 10px;
            padding: 5px 0;
        }

        .container .form form .link a {
            color: #6665ee;
        }


        /* Alert Styles */
        .container .row .alert {
            color: red;
            text-align: 10px;
            margin-top: 16px;
        }

        /* Center Text Styles */
        .text-center {
            text-align: center;
            font-size: 18px;
        }

        /* Center Text Styles */
        .text-center-head {
            text-align: center;
            font-size: 30px;
        }

        /* Radio Inputs Styles */
        .radio-inputs {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            border-radius: 0.5rem;
            background-color: #EEE;
            box-sizing: border-box;
            box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
            padding: 0.25rem;
            width: 330px;
            font-size: 14px;
        }

        .radio-inputs .radio {
            flex: 1 1 auto;
            text-align: center;
            margin: 5px;
        }

        .radio-inputs .radio input {
            display: none;
        }

        .radio-inputs .radio .name {
            display: flex;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            border: none;
            padding: 10px;
            color: rgba(51, 65, 85, 1);
            transition: all .15s ease-in-out;
        }

        .radio-inputs .radio input:checked+.name {
            background-color: #fff;
            font-weight: 600;
        }

        /* Home Icon Styles */
        .homeIcon {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-link {
            margin-top: 10px;
            text-align: center;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 form login-form">
                <form action="#" method="POST">

                    <?php
                    if (isset($error)) {
                        foreach ($error as $error) {
                            echo '<div class="alert alert-danger text-center">' . $error . '</div>';
                        };
                    };
                    ?>

                    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success') { ?>
                    <div class="alert alert-success text-center">Registration Successful! You can now login.</div>
                    <?php } ?>


                    <h2 class="text-center-head">Login</h2>


                    <div class="form-group">
                        <input required="" type="text" name="NIC" class="form-control" placeholder="Enter Your NIC">
                    </div>
                    <div class="form-group">
                        <input required="" type="password" name="password" class="form-control" placeholder="Enter Your Password">
                    </div>

                    <br>

                    <div class="form-group">
                        <input class="form-control button" type="submit" name="submit" value="Sign in">
                    </div>

                    <div class="signup-link"> <a href="Register.php">Click here to Register</a>

                    </div>

                    <div class="homeIcon">
                        <a href="./index.html"><i class="fa fa-home" style="font-size: 36px"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>