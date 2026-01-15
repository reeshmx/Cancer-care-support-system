<?php
@include '../config.php'; // Ensure config.php is included for database connection

// Check if the user is logged in and if the user type is client
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['doctor_name'])) {
    $doctor_name = $_SESSION['doctor_name'];
    $user_nic = $_SESSION['user_NIC'];

    // Query to get the Doctor_ID based on user_nic
    $doctorIdQuery = "SELECT Doctor_ID FROM doctor_details WHERE NIC = '$user_nic'";
    $doctorIdResult = mysqli_query($conn, $doctorIdQuery);

    if ($doctorIdRow = mysqli_fetch_assoc($doctorIdResult)) {
        $doctor_id = $doctorIdRow['Doctor_ID'];

        // Query to get consultation appointments filtered by Doctor_ID and status = 0
        $appointmentsQuery = "SELECT CON_APP_ID, PatientName, Age, Gender, PhoneNo, Address, Description, Doctor_ID, Doctor_Name 
        FROM consult_appointment 
        WHERE Doctor_ID = '$doctor_id' AND status = '0'";
        $appointmentsResult = mysqli_query($conn, $appointmentsQuery);

        // Query to get medications from the drugs table
        $medicationsQuery = "SELECT drugID, Name, Type, Price FROM drugs";
        $medicationsResult = mysqli_query($conn, $medicationsQuery);
    } else {
        // Handle case where no Doctor_ID was found
        $appointmentsResult = [];
        $medicationsResult = [];
    }
} else {
    // Redirect to the login page if not logged in as client
    header('location: ../Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Consult Appointment</title>

    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

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

<body>
    <?php include './TopBar.php'; ?>
    <div class="main_container">
        <?php include './SideBar.php'; ?>
        <div class="container">
            <header class="intro">
                <h1>Consult Appointment</h1>
            </header>

            <div class="table-responsive" style="width: 110%;">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr style="text-align:center;">
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointmentsResult)) { ?>
                            <?php while ($appointment = mysqli_fetch_assoc($appointmentsResult)) { ?>
                                <tr>
                                    <td><?php echo $appointment['PatientName']; ?></td>
                                    <td><?php echo $appointment['Age']; ?></td>
                                    <td><?php echo $appointment['Gender']; ?></td>
                                    <td><?php echo $appointment['PhoneNo']; ?></td>
                                    <td><?php echo $appointment['Address']; ?></td>
                                    <td><?php echo $appointment['Description']; ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" style="width: 100px; margin-bottom:10px;" onclick="openConsultationForm('<?php echo $appointment['PatientName']; ?>', <?php echo $appointment['CON_APP_ID']; ?>)">Consultation</button>

                                        <button class="btn btn-danger btn-sm" style="width: 100px; margin-bottom:10px;" onclick="handleReject(<?php echo $appointment['CON_APP_ID']; ?>)">Reject</button>



                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">No appointments found for this doctor.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="consultationModal" tabindex="-1" role="dialog" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="consultationForm" method="POST" action="handle_consultation.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="consultationModalLabel">Consultation Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="CON_APP_ID" name="CON_APP_ID">
                        <input type="hidden" id="doctorNIC" name="DoctorNIC" value="<?php echo $user_nic; ?>">
                        <input type="hidden" id="doctorName" name="DoctorName" value="<?php echo $doctor_name; ?>">

                        <div class="form-group">
                            <label>Patient Name</label>
                            <input type="text" id="patientName" name="PatientName" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Consulted Date</label>
                            <input type="text" id="consultedDate" name="ConsultedDate" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Did you Contact Patient?</label>
                            <select name="ContactStatus" class="form-control">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                                <option value="no_response">No Response</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Medication</label>
                            <select id="medicationSelect" class="form-control">
                                <option value="">Select Medication</option>
                                <?php while ($medication = mysqli_fetch_assoc($medicationsResult)) { ?>
                                    <option value="<?php echo $medication['Name']; ?>" data-price="<?php echo $medication['Price']; ?>">
                                        <?php echo $medication['Name'] . " (" . $medication['Type'] . ") - $" . $medication['Price']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Selected Medications</label>
                            <ul id="selectedMedicationsList" class="list-group">
                            </ul>
                        </div>
                        <input type="hidden" name="MedicationList" id="selectedMedications">
                        <input type="hidden" name="TotalAmount" id="medicationTotalAmount">


                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="Description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Doctor Charge</label>
                            <input type="number" name="DoctorCharge" class="form-control" step="0.01" min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="credit">
        <!-- Footer content here -->
    </footer>

    <script>
        // Open the consultation form with pre-filled patient name and appointment ID
        function openConsultationForm(patientName, conAppId) {
            document.getElementById('patientName').value = patientName;
            document.getElementById('CON_APP_ID').value = conAppId;

            const sriLankaTime = new Date().toLocaleString('en-US', {
                timeZone: 'Asia/Colombo'
            });
            document.getElementById('consultedDate').value = sriLankaTime;

            $('#consultationModal').modal('show');
        }


        // Handle rejection of an appointment
        function handleReject(CON_APP_ID) {
            if (confirm("Are you sure you want to reject this appointment?")) {
                $.ajax({
                    url: 'update_Reject_Consult_status.php',
                    type: 'POST',
                    data: {
                        CON_APP_ID: CON_APP_ID,
                        status: 5
                    },
                    success: function(response) {
                        if (response === 'success') {
                            alert('Appointment rejected successfully.');
                            location.reload();
                        } else {
                            alert('Failed to reject the appointment.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        }

        // Medication selection and calculation
        const selectedMedications = [];
        const medicationSelect = document.getElementById('medicationSelect');
        const selectedMedicationsList = document.getElementById('selectedMedicationsList');
        const medicationTotalAmount = document.getElementById('medicationTotalAmount');
        const medicationListInput = document.getElementById('selectedMedications'); // Hidden input for medication list

        // Update the total amount of selected medications
        function updateTotalAmount() {
            const totalAmount = selectedMedications.reduce((sum, med) => sum + med.price, 0);
            medicationTotalAmount.value = totalAmount.toFixed(2); // Display total amount
        }

        // Update the hidden input with selected medications as a JSON string
        function updateMedicationListInput() {
            medicationListInput.value = JSON.stringify(selectedMedications.map(med => med.name));
        }

        // Add a medication to the list upon selection
        medicationSelect.addEventListener('change', function() {
            const selectedOption = medicationSelect.options[medicationSelect.selectedIndex];
            const medicationName = selectedOption.value;
            const medicationPrice = parseFloat(selectedOption.getAttribute('data-price'));

            if (medicationName) {
                const medication = {
                    name: medicationName,
                    price: medicationPrice
                };
                selectedMedications.push(medication);

                // Create list item for the selected medication
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.textContent = `${medication.name} - $${medication.price.toFixed(2)}`;

                // Add a remove button for the medication
                const removeButton = document.createElement('button');
                removeButton.className = 'btn btn-danger btn-sm';
                removeButton.textContent = 'Remove';

                // Remove medication on button click
                removeButton.addEventListener('click', function() {
                    const index = selectedMedications.findIndex(med => med.name === medication.name);
                    if (index > -1) {
                        selectedMedications.splice(index, 1);
                        selectedMedicationsList.removeChild(listItem);
                        updateTotalAmount();
                        updateMedicationListInput();
                    }
                });

                listItem.appendChild(removeButton);
                selectedMedicationsList.appendChild(listItem);

                // Update total amount and hidden input with selected medications
                updateTotalAmount();
                updateMedicationListInput();
            }

            // Reset the select input after adding
            medicationSelect.value = '';
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>