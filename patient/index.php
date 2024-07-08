<?php

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="sweetalert2.min.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	
	<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/style.css">
	<title>AdminSite</title>
</head>
<input type="hidden" id="sessionMessage" value="<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; unset($_SESSION['message']); ?>">
<div class="modal fade" id="fullNameRegisteredModal" tabindex="-1" role="dialog" aria-labelledby="nameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameErrorModalLabel">Online Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   Successful Add Appointment
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



<div class="modal fade" id="bookSchedule" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Book Schedule <span id="modalDate"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../querys/addtranscation_patient.php" method="post">
                    <input type="hidden" class="form-control" id="id_date" name="id_date" required>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <select class="form-control" id="service" name="service" required>
                            <?php
                            include("../querys/db_config.php");

                            $sql = "SELECT * FROM tbl_service";
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["id"] . '" data-fee="' . $row["fee"] . '">' . $row["type"] . '</option>';
                                }
                            }

                            $connection->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fee">Fee</label>
                        <input type="text" class="form-control" id="fee" name="fee" readonly required>
                    </div>
                    <div class="form-group">
    <label for="time">Select Time</label>
    <input type="time" class="form-control" id="time" name="time" placeholder="Select time" required>
    <div id="timeError" class="invalid-feedback" style="display: none;">Please select a time.</div>
</div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<body>
	
	<!-- SIDEBAR -->
	<?php
		include ("includes/sidebar.php");
		
		?>



	<section id="content">
		
		<?php
		include ("includes/navbar.php");
		
		?>
	
	
	
		
		
		  
	
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Home</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Dashboard</a></li>
			</ul>
			


			<div class="dashboard-row">
            <?php
include("../querys/db_config.php");


$sql = "SELECT COUNT(*) AS totalPatients FROM tbl_transaction";
$result = $connection->query($sql);

// Check if query was successful
if ($result) {
    $row = $result->fetch_assoc();
    $totalPatients = $row['totalPatients'];
} else {
    // Error handling if query fails
    $totalPatients = 'N/A';
}

$connection->close();
?>



    <div class="dashboard-element total-patient">
        <div class="count"><?php echo $totalPatients; ?></div>
        <div class="textpanel">Total Patient</div>
    </div>
    <?php
include("../querys/db_config.php");


$sql = "SELECT COUNT(*) AS totalServices FROM tbl_service";
$result = $connection->query($sql);

// Check if query was successful
if ($result) {
    $row = $result->fetch_assoc();
    $totalServices = $row['totalServices'];
} else {
    // Error handling if query fails
    $totalServices = '0';
}

$connection->close();
?>
    <div class="dashboard-element services">
      
    <div class="count"><?php echo $totalServices; ?></div>
		
        <div class="textpanel">Services</div>
    </div>
    <?php
include("../querys/db_config.php");





$sqlTotalPending = "SELECT COUNT(*) AS totalPending FROM tbl_transaction WHERE status = 'Pending'";
$resultTotalPending = $connection->query($sqlTotalPending);

if ($resultTotalPending) {
    $rowTotalPending = $resultTotalPending->fetch_assoc();
    $totalPending = $rowTotalPending['totalPending'];
} else {
   
    $totalPending = '0';
}

$connection->close();
?>

    <div class="dashboard-element pending">
   
    <div class="count"><?php echo $totalPending; ?></div>
		
        <div class="textpanel">Pending</div>
    </div>
    <?php
include("../querys/db_config.php");





$sqlTotalApprove = "SELECT COUNT(*) AS totalApprove FROM tbl_transaction WHERE status = 'Approve'";
$resultTotalApprove = $connection->query($sqlTotalApprove);

if ($resultTotalApprove) {
    $rowTotalApprove = $resultTotalApprove->fetch_assoc();
    $totalApprove = $rowTotalApprove['totalApprove'];
} else {
   
    $totalApprove = '0';
}

$connection->close();
?>
    <div class="dashboard-element approve">
  
    <div class="count"><?php echo $totalApprove; ?></div>
		
        <div class="textpanel">Approve</div>
    </div>
    
     </div>
           <div class="containerforcalendar">
            <div class="row">
				<div class="col-md-12">
<?php
				include ("calendar.php");
				
				?>
              </div>
			  </div>
			  </div>
			
			  <div class="legend-container">
    <h2>Legend</h2>
	<hr>
    <ul class="legend">
        <li class="legend-item legend-green">Available Slots</li>
        <li class="legend-item legend-blue">No Slots</li>
        <li class="legend-item legend-red">Fully Booked</li>
        <li class="legend-item legend-purple">Holidays</li>
   
    </ul>
</div>


	<hr>
	<?php
include("../querys/db_config.php");


$sql = "SELECT * FROM tbl_holidays "; 

$result = mysqli_query($connection, $sql);

// Check if there are any holidays
if (mysqli_num_rows($result) > 0) {
    echo "<div class='holiday-container'>";
    echo "<h2>Holidays for 2024</h2>";
    echo "<hr>";
    echo "<ul class='holiday-list'>";
    

    while ($row = mysqli_fetch_assoc($result)) {
        $holidayDate = date('F j, Y', strtotime($row['date'])); 
        $holidayName = $row['description']; 

    
        echo "<li class='legend-item legend-purple'>$holidayName - $holidayDate</li>";
    }

    echo "</ul>";
    echo "</div>";
} else {
    echo "<p>No holidays found for 2024.</p>";
}

mysqli_close($connection);
?>


		</main>
	
	</section>
	<!-- NAVBAR -->
	<?php
		include ("includes/footer.php");
		
		?>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="sweetalert2.min.js"></script>s
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="../script/script.js"></script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

	
</body>
<script>
    

    $(document).ready(function() {
    var message = $("#sessionMessage").val();
    if (message === "Successful!") {
        $("#fullNameRegisteredModal").modal("show");
    }
});

document.addEventListener('DOMContentLoaded', function () {
        var serviceSelect = document.getElementById('service');
        var feeInput = document.getElementById('fee');

        serviceSelect.addEventListener('change', function () {
            var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            var fee = selectedOption.dataset.fee;
            feeInput.value = fee;
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("time").addEventListener("input", function() {
            var timeInput = this.value;
            var timeError = document.getElementById("timeError");
            if (!timeInput) {
                timeError.style.display = "block";
            } else {
                timeError.style.display = "none";
            }
        });
    });
	</script>
<style>

.btn{
	background: #1e90ff;
	width: 120px;
	padding: 8px;
	text-align: center;
	text-decoration: none;
	color: #fff;
	cursor: pointer;
	box-shadow: 0 0 10px rgba(0,0,0, 0.1);
	float: right;
	-webkit-transition-duration: 0.3s;
	transition-duration: 0.3s;
	-webkit-transition-property: box-shadow, transform;
	transition-property: box-shadow, transform;
	}
	.btn:hover, .btn:focus, .btn:active{
	
	box-shadow: 0 0 20px rgba(0,0,0, 0.5);
	-webkit-transform: scale(1.1);
	transform: scale(1.1);
}
</style>

</html>