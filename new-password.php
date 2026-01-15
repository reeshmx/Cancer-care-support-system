<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a New Password</title>
    


    <style>
        body {
            /* Background Styles */
            background-image: url(../html/images/pexels-maxime-francis-2246476.jpg);
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
            padding: 80px 35px; /* Increased padding for a larger form */
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            text-align: center; /* Center-align the form */
            width: 70%; /* Increased width for the form */
            margin: 0 auto; /* Center the form horizontally */
        }

        /* Form Control Styles */
        .container .form-control {
            height: 50px; /* Increased height for form controls */
            width: 95%;
            display: flex;
            position: relative;
            font-size: 18px; /* Increased font size for form controls */
            margin-top: 20px;
            border-radius: 10px;
            border: 1px solid #393939;
            padding-left: 10px; /* Increased padding-left for form controls */
        }

        /* Button Styles */
        .container .form form .button {
            background: #ffffff;
            color: #000;
            font-size: 20px; /* Increased font size for the button */
            font-weight: bold;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            display: inline-block;
            margin-top: 20px; /* Adjusted margin-top for button alignment */
        }

        /* Button Hover Styles */
        .container .form form .button:hover {
            background: #03ff1cbd;
        }

        /* Alert Styles */
        .container .row .alert {
            color: red;
            text-align: center; /* Center-align the error messages */
            margin-top: 20px;
            margin-top: 20px;
        }

        /* Center Text Styles */
        .text-center {
            text-align: center;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="new-password.php" method="POST" autocomplete="off">
                    <h2 class="text-center">New Password</h2>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Create new password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="change-password" value="Change">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>