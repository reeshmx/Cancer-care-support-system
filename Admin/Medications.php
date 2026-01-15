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


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CSS Sidebar Menu with icons Example</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- SideBar-Menu CSS -->
    <link rel="stylesheet" href="../css/styles.css" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="css/demo.css" />

    <script>
        $(document).ready(function() {
            $(".hamburger .hamburger__inner").click(function() {
                $(".wrapper").toggleClass("active");
            });

            $(".top_navbar .fas").click(function() {
                $(".profile_dd").toggleClass("active");
            });

            // Filter function
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#medicationsTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>

    <style>
        /* Green Theme */
        .table-green-theme thead {
            background-color: #4CAF50;
            color: white;
        }

        .table-green-theme tbody tr:hover {
            background-color: #e8f5e9;
        }

        .table-green-theme tbody tr:nth-child(odd) {
            background-color: #f1f8e9;
        }

        .table-green-theme td,
        .table-green-theme th {
            border-color: #c8e6c9;
        }

        .table-container {
            max-width: 100%;
            margin-right: -60px;
            margin-left: 70px;
        }

        .search-container {
            margin-top: 10px;
        }

        #Addbtn {
            width: 200px;
            margin-right: -60px;
        }

        #searchInput {

            width: 500px;
            margin-left: 70px;
        }
    </style>
</head>

<body>
    <?php include './TopBar.php'; ?>

    <div class="main_container">
        <?php include './SideBar.php'; ?>


        <div class="container py-5">
            <header class="intro">
                <h1 class="text-center">Medications</h1>
            </header>


            <!-- Search bar -->
            <div class="search-container d-flex justify-content-between mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search for medications..." aria-label="Search">
                <a href="MedicationsAddNew.php" class="btn btn-success ml-2" id="Addbtn">+ Add New</a>
            </div>


            <!-- Table Container for Wider Layout -->
            <div class="table-container">
                <!-- Green-themed Bootstrap-styled table for displaying medications with Actions column -->
                <table class="table table-striped table-green-theme mt-4" id="medicationsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Actions</th> <!-- Actions column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch records from drugs table
                        $sql = "SELECT drugID, Name, Type, Price, Image FROM drugs";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['drugID']}</td>
                                    <td>{$row['Name']}</td>
                                    <td>{$row['Type']}</td>
                                    <td>$" . number_format($row['Price'], 2) . "</td>
                                    <td>
                                        <a href='MedicationsEditUpdate.php?id={$row['drugID']}' class='btn btn-sm btn-warning'>Edit</a>
                                        <a href='deleteDrug.php?id={$row['drugID']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this medication?\")'>Delete</a>
                                    </td>
                                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No records available</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<footer class="credit"></footer>

</html>