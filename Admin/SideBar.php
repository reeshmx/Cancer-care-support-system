<?php
@include 'config.php'; // Ensure config.php is included for database connection

// Check if the user is logged in and if the user type is client
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_name'])) {
    $admin_name = $_SESSION['admin_name'];
    $user_nic = $_SESSION['user_NIC'];
} else {
    // Redirect to the login page if not logged in as client
    header('location: ../Login.php');
    exit();
}

// Get the current page file name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" style="width:250px; overflow-y:auto; max-height:1000vh; padding-bottom: 1rem;">
    <div class="sidebar__inner">
        <div class="profile">
            <div class="img">
                <!-- Replace the image with a user icon -->
                <i class="fas fa-user fa-3x"></i> <!-- Font Awesome user icon -->
            </div>
            <div class="profile_info">
                <p>Welcome</p>
                <p class="profile_name"><?php echo htmlspecialchars($admin_name); ?></p> <!-- Display admin name dynamically -->
            </div>
        </div>
        <ul>
            <li>
                <a href="index.php" <?php if ($current_page === 'index.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-dice-d6"></i></span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="Users.php" <?php if ($current_page === 'Users.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <span class="title">Users</span>
                </a>
            </li>
            <li>
                <a href="Medications.php" <?php if ($current_page === 'Medications.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-prescription-bottle-alt"></i></span>
                    <span class="title">Medication</span>
                </a>
            </li>
            <li class="has-submenu">
                <a href="Orders.php" <?php if ($current_page === 'Orders.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-box"></i></span>
                    <span class="title">Orders</span>
                    <span class="submenu-toggle" style="margin-left:40px;"><i class="fas fa-chevron-down"></i></span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="AllOrders.php" <?php if ($current_page === 'AllOrders.php') echo 'class="active"'; ?>>
                            <span class="title">All Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="OrdersStatus.php" <?php if ($current_page === 'OrdersStatus.php') echo 'class="active"'; ?>>
                            <span class="title">Orders Status</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="Programs.php" <?php if ($current_page === 'Programs.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-calendar-check"></i></span>
                    <span class="title">Programs</span>
                </a>
            </li>
            <li>
                <a href="LoanService.php" <?php if ($current_page === 'LoanService.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-hand-holding-usd"></i></span>
                    <span class="title">Loan Service</span>
                </a>
            </li>
            <li>
                <a href="query.php" <?php if ($current_page === 'query.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-hand-holding"></i></span>
                    <span class="title">Query</span>
                </a>
            </li>
            <li>
                <a href="ChangePassword.php" <?php if ($current_page === 'ChangePassword.php') echo 'class="active"'; ?>>
                    <span class="icon"><i class="fas fa-hand-holding"></i></span>
                    <span class="title">Change Password</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    .has-submenu .submenu {
        display: none;
        padding-left: 20px;
    }

    .has-submenu.active .submenu {
        display: block;
    }

    .submenu-toggle {
        float: right;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const submenuToggle = document.querySelector(".has-submenu > a");

        submenuToggle.addEventListener("click", function(event) {
            event.preventDefault();
            const parent = submenuToggle.parentElement;
            parent.classList.toggle("active");
        });
    });
</script>