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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<title>AdminSite</title>
</head>
<!-- edit --->
<div class="modal fade" id="editSchedule" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Edit Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../querys/editschedule.php" method="post">
        <div class="form-group">
        <input type="hidden" id="id" name="id">
    <label for="date">Date</label>
    <input type="date" class="form-control" id="date" name="date" placeholder="Select date">
</div>
          <div class="form-group">
            <label for="slots">Slots</label>
            <input type="number" class="form-control" id="slots" name="slots" placeholder="Slots">
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






<div class="modal fade" id="createSchedule" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Add Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../querys/addschedule.php" method="post">
        <div class="form-group">
    <label for="date">Date</label>
    <input type="date" class="form-control" id="datee" name="date" placeholder="Select date">
</div>
          <div class="form-group">
            <label for="slots">Slots</label>
            <input type="number" class="form-control" id="slots" name="slots" placeholder="Slots">
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
		include ("../includes/sidebar.php");
		
		?>



	<section id="content">
		
		<?php
		include ("../includes/navbar.php");
		
		?>
	
	
	
		
		
		  
	
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Maintenance</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Maintenance</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Schedule</a></li>
			</ul>
			<br><br>

            <div class="container-tables">
    <a href="#" class="btn" data-toggle="modal" data-target="#createSchedule">Create New</a><br><br>
    <table id="schedule" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>SLOTS</th>
                <th>SLOTS DATE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        <?php
include("../querys/db_config.php");

$sql = mysqli_query($connection, "SELECT * FROM tbl_schedule");

if (mysqli_num_rows($sql) > 0) {
    while ($rows = mysqli_fetch_array($sql)) {
        echo "<tr>";
        echo "<td>" . $rows['id'] . "</td>";
        echo "<td>" . $rows['date_schedule'] . "</td>";
        echo "<td>" . $rows['slots'] . "</td>";
        echo "<td>
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Action
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        <a data-id='" . $rows["id"] . "' class='dropdown-item editbtn' data-toggle='modal' data-target='#editSchedule'>
                            <i class='bx bxs-edit' style='color:#1860c0'></i>Edit
                        </a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item deletebtn' data-id='" . $rows["id"] . "' href='#'>
                            <i class='bx bxs-trash-alt' style='color:#e10a0a'></i>Delete
                        </a>
                    </div>
                </div>
            </td>";
        echo "</tr>";
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
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="../script/script.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

	<script>

$(document).on('click', '.deletebtn', function(e) {
            e.preventDefault();
            var patientId = $(this).data('id');
            var confirmDelete = confirm("Are you sure you want to delete this patient?");
            if (confirmDelete) {
                window.location.href = '../querys/deleteschedule.php?id=' + patientId;
            }
        });



	$(document).on('click', '.editbtn', function() {
  var id = $(this).data('id');
  var url = '../querys/get_shedule.php?id=' + id;

  $.ajax({
    url: url,
    type: 'GET',
    success: function(response) {
      try {
        var data = JSON.parse(response);
        console.log(data);

        if (data.error) {
          console.error(data.error);
          alert(data.error); 
        } else {
          $('#id').val(data.id);
          $('#date').val(data.date_schedule);
          $('#slots').val(data.slots);
         
          
         
        }
      } catch (e) {
        console.error("Invalid JSON response: ", response);
      }
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
    }
  });
});

		$(document).ready(function () {
    $('#schedule').DataTable();
});

document.addEventListener('DOMContentLoaded', function() {
      
        var dateInput = document.getElementById('datee');
        
    
        function isWeekend(date) {
            var day = date.getDay(); 
            return day === 0 || day === 6; 
        }

  
        dateInput.addEventListener('input', function() {
            var selectedDate = new Date(this.value); 
            
            if (isWeekend(selectedDate)) {
               
                this.value = ''; 
                alert('No Work on Weekends.'); 
            }
        });
    });
</script>

	
</body>
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