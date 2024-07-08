
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="modal fade" id="accessLevelModal" tabindex="-1" role="dialog" aria-labelledby="accessLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accessLevelModalLabel">Access Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Access Level.</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="maintenanceCheckbox" data-function-id="2">
                        <label class="form-check-label" for="maintenanceCheckbox">
                            Maintenance
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="patientCheckbox" data-function-id="1">
                        <label class="form-check-label" for="patientCheckbox">
                            Patient
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
    function updateCheckboxStatus() {
        $.ajax({
            url: '../querys/update_checkbox_status.php',
            dataType: 'json',
            success: function(response) {
                // Check the status of function with id 1 (Patient)
                if (response.id1 && response.id1.length > 0 && response.id1[0] === '1') {
                    $('#patientCheckbox').prop('checked', true);
                } else {
                    $('#patientCheckbox').prop('checked', false);
                }
                
                // Check the status of function with id 2 (Maintenance)
                if (response.id2 && response.id2.length > 0 && response.id2[0] === '1') {
                    $('#maintenanceCheckbox').prop('checked', true);
                } else {
                    $('#maintenanceCheckbox').prop('checked', false);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle error
            }
        });
    }

    // Call the function on page load
    updateCheckboxStatus();





            $('.form-check-input').on('click', function() {
                var checkboxId = $(this).attr('id');
                var functionId = $(this).data('function-id');
                var isChecked = $(this).is(':checked');

                // Make AJAX request to update database
                $.ajax({
                    url: '../querys/update_database.php', // Replace with your server-side script URL
                    method: 'POST',
                    data: {function_id: functionId, checked: isChecked ? 1 : 0},
                    dataType: 'json',
                    success: function(response) {
                        // Handle success
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
           
                    }
                });
            });
        });
    </script>




        

    <section id="sidebar">
        <a class="brand"><i class='bx bxs-smile icon'></i> Admin Panel</a>
        <ul class="side-menu">
            <li><a href="index.php" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
            <li class="divider" data-text="main">Main</li>
            <li><a href="index.php"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
            <?php
include '../querys/db_config.php';

// Check if type_user is Admin
if ($_SESSION['type_user'] === 'Admin') {
    // Output HTML for Admin
    echo '<li class="divider" data-text="Patient">Patient</li>
    <li>
        <a href="patient.php"><i class="bx bx-user icon"></i> Patient</a>
    </li>';
} else {
    // Execute query for Staff
    $query = "SELECT function FROM tbl_acc WHERE id = 1"; 
    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Error executing query: " . mysqli_error($connection);
    } else {
        $row = mysqli_fetch_assoc($result);
        $function_value = $row['function'];

        // Output HTML for Staff based on function value
        if ($function_value == 1) {
            echo '<li class="divider" data-text="Patient">Patient</li>
            <li>
                <a href="patient.php"><i class="bx bx-user icon"></i> Patient</a>
            </li>';
        }
    }
}

// Close the database connection
mysqli_close($connection);
?>

            <li>
        
                <a href="#" ><i class='bx bx-file icon' ></i> Transcations <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="pending.php"><i class='bx bx-circle icon' style='color:#dc0f0f'></i>Pending</a></li>
                    <li><a href="accept.php"><i class='bx bx-circle icon' style='color:#0fdc49'  ></i>Approved</a></li>
                    <li><a href="complete.php"><i class='bx bxs-circle icon' style='color:#0fdc49'  ></i>Completed</a></li>
                    <li><a href="reject.php"><i class='bx bxs-circle icon'  style='color:#dc0f0f'></i>Rejected</a></li>
                    <li><a href="unsuccessful.php"><i class='bx bxs-circle icon'  style='color:black'></i>Unsuccessful</a></li>
          
                 
                </ul>
            </li>
            <?php
include '../querys/db_config.php';

// Check if type_user is Admin
if ($_SESSION['type_user'] === 'Admin') {
    echo '<li class="divider" data-text="Maintenance">Maintenance</li>
            <li>
                <a href="#"><i class="bx bx-shield-alt-2 icon"></i> Maintenance <i class="bx bx-chevron-right icon-right"></i></a>
                <ul class="side-dropdown">
                    <li><a href="schedule.php"><i class="bx bxs-time icon"></i>Schedule</a></li>
                    <li><a href="holidays.php"><i class="bx bxs-calendar icon"></i>Holidays</a></li>
                    <li><a href="service.php"><i class="bx bx-list-ul icon"></i>Services</a></li>
                </ul>
            </li>';
} elseif ($_SESSION['type_user'] === 'Staff') {
    $query = "SELECT function FROM tbl_acc WHERE id = 2"; 
    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Error executing query: " . mysqli_error($connection);
    } else {
        $row = mysqli_fetch_assoc($result);
        $function_value = $row['function'];

        if ($function_value == 1) {
            // Output HTML as a string
            echo '<li class="divider" data-text="Maintenance">Maintenance</li>
            <li>
                <a href="#"><i class="bx bx-shield-alt-2 icon"></i> Maintenance <i class="bx bx-chevron-right icon-right"></i></a>
                <ul class="side-dropdown">
                    <li><a href="schedule.php"><i class="bx bxs-time icon"></i>Schedule</a></li>
                    <li><a href="holidays.php"><i class="bx bxs-calendar icon"></i>Holidays</a></li>
                    <li><a href="service.php"><i class="bx bx-list-ul icon"></i>Services</a></li>
                </ul>
            </li>';
        }
    }
} else {
    // Handle other cases, if needed
}

// Close the database connection
mysqli_close($connection);
?>


          
               
          <?php

if ($_SESSION['type_user'] === 'Admin') {
    echo '<li class="divider" data-text="Settings">Settings</li>
    <li>
        <a href="#"><i class="bx bxs-cog icon"></i> Settings <i class="bx bx-chevron-right icon-right"></i></a>
        <ul class="side-dropdown">
            <a href="#" data-toggle="modal" data-target="#accessLevelModal"><i class="bx bxs-cog icon"></i> Access Level</a>
        </ul>
    </li>';
}
?>
        </ul>
    
    </section>
 
