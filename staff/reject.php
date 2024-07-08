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


<body>
	
	<!-- SIDEBAR -->
	<?php
		include ("../includes/sidebar.php");
		
		?>



	<section id="content">
		
		<?php
		include ("../includes/navbar.php");
		
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
			<br><br>
            <div class="container-tables">

    <table id="pending" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>STATUS</th> 
                <th>TRANSACTION NO.</th>
                <th>SERVICE</th>
                <th>DATE APPOINTMENT</th>
                <th>TIME SLOT</th>
                
         
            </tr>
        </thead>
        <tbody>
        <?php
include("../querys/db_config.php");

// Fetch all rows from tbl_transaction
$sql = mysqli_query($connection, "SELECT * FROM tbl_transaction WHERE status = 'Reject'");

if (mysqli_num_rows($sql) > 0) {
    while ($rows = mysqli_fetch_array($sql)) {
        $serviceId = $rows['fk_service_id'];
        $patientId = $rows['fk_patient_id'];
        $scheduleId = $rows['fk_schedule_id'];

    
        $serviceQuery = mysqli_query($connection, "SELECT type FROM tbl_service WHERE id = '$serviceId'");
        $serviceRow = mysqli_fetch_array($serviceQuery);
        $serviceType = $serviceRow['type'];
        
        $scheduleQuery = mysqli_query($connection, "SELECT date_schedule FROM tbl_schedule WHERE id = '$scheduleId'");
        $scheduleRow = mysqli_fetch_array( $scheduleQuery);
        $scheduleType = $scheduleRow['date_schedule'];

        $patientQuery = mysqli_query($connection, "SELECT firstname, middleinitial, lastname FROM tbl_patient WHERE id = '$patientId'");
        $patientRow = mysqli_fetch_array($patientQuery);
        $patientName = $patientRow['firstname'] . ' ' . $patientRow['middleinitial'] . ' ' . $patientRow['lastname'];
        
        echo "<tr>";
        echo "<td>" . $rows['id'] . "</td>";
        
        $statusStyle = ($rows['status'] == 'Reject') ? 'background-color: lightcoral; color: white; border-radius: 5px; padding: 2px 5px;' : '';
        echo "<td><span style='$statusStyle'>" . $rows['status'] . "</span></td>";
        
 
        echo "<td><span style='color: blue;'>" . $rows['transaction_number'] . "</span><br><span style='color: green;'>" . $patientName . "</span></td>";

        echo "<td>" . $serviceType . "</td>"; 
        echo "<td>" .  $scheduleType . "</td>"; 
        echo "<td>" . $rows['time_slot'] . "</td>";
        
   
        
      
    }          
}
?>



        </tbody>
    </table>
</div>

		</main>
	
	</section>
	<!-- NAVBAR -->
	<?php
		include ("../includes/footer.php");
		
		?>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="sweetalert2.min.js"></script>s
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="../script/script.js"></script>
	
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>    $(document).ready(function () {
$('#pending').DataTable();
});
</script>
	
</body>
<style>
.tooltip {
    visibility: hidden;
    background-color: black;
    color: white;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    top: 65px; /* Adjust this value to position the tooltip above the icon */
    left: 92%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
}

.approvebtn:hover .tooltip,
.rejectbtn:hover .tooltip {
    visibility: visible;
    opacity: 1;
}


    .status-pending {
        background-color: lightblue;
    }


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