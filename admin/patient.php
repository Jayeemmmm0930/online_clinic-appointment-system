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

	<title>AdminSite</title>
</head>

<!---->
<div class="modal fade" id="successUpdate" tabindex="-1" role="dialog" aria-labelledby="nameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameErrorModalLabel">Update Complete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Patient/User Details Successfully Updated!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successAdd" tabindex="-1" role="dialog" aria-labelledby="nameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameErrorModalLabel">Add Complete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Patient/User Details Successfully Added!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal edit -->
<div class="modal fade" id="editPatient" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Edit Patient/User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="patientForm" action="../querys/edit_patient.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
  <input type="hidden" id="id" name="id">

  <div class="form-group">
    <div class="row">
      <div class="col-md-4">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
      </div>
      <div class="col-md-4">
        <label for="middleinitial">Middle Initial</label>
        <input type="text" class="form-control" id="middleinitial" name="middleinitial" placeholder="Middle Initial Optional">
      </div>
      <div class="col-md-4">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="row">
      <div class="col-md-4">
        <label for="gender">Gender</label>
        <select class="form-control" id="gender" name="gender" required>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="birthday">Birthday</label>
        <input type="date" class="form-control" id="editbirthday" name="birthday" onchange="calculateAgeforedit()" required>
      </div>
      <div class="col-md-4">
        <label for="age">Age</label>
        <input type="number" class="form-control" id="editage" name="age" readonly>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="contactnumber">Contact Number</label>
    <input type="tel" class="form-control" id="contactnumber" name="contactnumber" placeholder="Contact Number" required>
  </div>
  <div class="form-group">
    <label for="presentaddress">Present Address</label>
    <input type="text" class="form-control" id="presentaddress" name="presentaddress" placeholder="Present Address" required>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
      </div>
      <div class="col-md-6">
        <label for="type_user">User Type</label>
        <select class="form-control" id="type_user" name="type_user" required>
          <option value="">Select User Type</option>
          <option value="Admin">Admin</option>
          <option value="Staff">Staff</option>
          <option value="Patient">Patient</option>
        </select>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="col-md-6">
        <label for="passwordconfirm">Confirm Password</label>
        <input type="password" class="form-control" id="passwordconfirm" name="passwordconfirm" placeholder="Confirm Password">
        <div id="passwordError" style="color: red; display: none;">Passwords do not match.</div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="image_url">Upload Image</label>
    <input type="file" class="form-control" id="image_url" name="image_url" accept="image/*" onchange="previewImage(event)">
    <img id="imagePreview" src="" alt="Image Preview" style="width: 50px; height: 50px; border-radius: 50%; display: none;">
  </div>

  <div id="nameError" style="color: red; display: none;">A patient with the same first name and last name already exists.</div>
  <div id="usernameError" style="color: red; display: none;">The username is already taken.</div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>

      </div>
    </div>
  </div>
</div>	
<!-- Modal for name error -->
<div class="modal fade" id="fullNameRegisteredModal" tabindex="-1" role="dialog" aria-labelledby="nameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameErrorModalLabel">Error: Name Already Exists</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                A patient/user with the same first name and last name already exists.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for username error -->
<div class="modal fade" id="usernameErrorModal" tabindex="-1" role="dialog" aria-labelledby="usernameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usernameErrorModalLabel">Error: Username Already Taken</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                The username is already taken.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPatient" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Add Patient/User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="../querys/addpatient.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
  <div class="form-group">
    <div class="row">
      <div class="col-md-4">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
      </div>
      <div class="col-md-4">
        <label for="middleinitial">Middle Initial</label>
        <input type="text" class="form-control" id="middleinitial" name="middleinitial" placeholder="Middle Initial Optional">
      </div>
      <div class="col-md-4">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="row">
      <div class="col-md-4">
        <label for="gender">Gender</label>
        <select class="form-control" id="gender" name="gender" required>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="birthday">Birthday</label>
        <input type="date" class="form-control" id="addbirthday" name="birthday" onchange="calculateAgeforadd()" required>
      </div>
      <div class="col-md-4">
        <label for="age">Age</label>
        <input type="number" class="form-control" id="addage" name="age" readonly>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="contactnumber">Contact Number</label>
    <input type="tel" class="form-control" id="contactnumber" name="contactnumber" placeholder="Contact Number" required>
  </div>

  <div class="form-group">
    <label for="presentaddress">Present Address</label>
    <input type="text" class="form-control" id="presentaddress" name="presentaddress" placeholder="Present Address" required>
  </div>

  <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
      </div>
      <div class="col-md-6">
        <label for="userType">User Type</label>
        <select class="form-control" id="userType" name="userType" required>
          <option value="">Select User Type</option>
          <option value="Admin">Admin</option>
          <option value="Staff">Staff</option>
          <option value="Patient">Patient</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="row">
      <div class="col-md-6">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
      </div>
      <div class="col-md-6">
        <label for="passwordconfirm">Confirm Password</label>
        <input type="password" class="form-control" id="passwordconfirm" name="passwordconfirm" placeholder="Confirm Password" required>
        <div id="passwordError" style="color: red; display: none;">Passwords do not match.</div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="image">Upload Image</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
    <img id="imagePreview" src="" alt="Image Preview" style="display:none; width: 100px; height: 100px; margin-top: 10px;">
  </div>

  <div id="nameError" style="color: red; display: none;">A patient with the same first name and last name already exists.</div>
  <div id="usernameError" style="color: red; display: none;">The username is already taken.</div>
  
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
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Home</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Dashboard</a></li>
			</ul>
			<br><br>
            <div class="container-tables">
    <a href="#" class="btn" data-toggle="modal" data-target="#addPatient">Create New</a><br><br>
    <table id="schedule" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>IMAGE</th>
                <th>FULLNAME</th>
                <th>GENDER</th>
                <th>BIRTHDAY</th>
                <th>AGE</th>
          
                <th>CONTACT NUMBER</th>
                <th>PRESENT ADDRESS</th>
                <th>USER TYPE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        <?php
include("../querys/db_config.php");

$sql = mysqli_query($connection, "SELECT * FROM tbl_patient");

if (mysqli_num_rows($sql) > 0) {
    while ($rows = mysqli_fetch_array($sql)) {
        echo "<tr>";
   
        echo "<td>" . $rows['id'] . "</td>";
        echo "<td><img src='../Uploads/" . $rows['image_url'] . "' style='width: 45px; height: 45px; border-radius: 45%;' /></td>";
        echo "<td>" . $rows['firstname'] . " " . $rows['middleinitial'] . " " . $rows['lastname']  . "</td>";
        echo "<td>" . $rows['gender'] . "</td>";
        echo "<td>" . $rows['birthday'] . "</td>";
        echo "<td>" . $rows['age'] . "</td>";
     
        echo "<td>" . $rows['contactnumber'] . "</td>";
        echo "<td>" . $rows['presentaddress'] . "</td>";
        echo "<td>" . $rows['type_user'] . "</td>";
    
   
        
        echo "<td>
                <div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Action
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        <a data-id='" . $rows["id"] . "' class='dropdown-item editbtn' data-toggle='modal' data-target='#editPatient'>
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
                window.location.href = '../querys/deletepatient.php?id=' + patientId;
            }
        });

        function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}


</script>	
	  
    <script>
         <?php
              if (isset($_GET['message']) && $_GET['message'] === "Updated Successfully!") {
                echo '$("#successUpdate").modal("show");';}
        ?>
          <?php
              if (isset($_GET['message']) && $_GET['message'] === "Add Successfully!") {
                echo '$("#successAdd").modal("show");';}
        ?>
    <?php
              if (isset($_GET['message']) && $_GET['message'] === "Full name already exists!") {
                echo '$("#fullNameRegisteredModal").modal("show");';}
        ?>
        <?php
           if (isset($_GET['message']) && $_GET['message'] === "Username already exists!") {
            echo '$("#usernameErrorModal").modal("show");';
        }
            
        ?>
    </script> 
    
    
    <script>
 function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("passwordconfirm").value;

    if (password !== confirmPassword) {
      document.getElementById("passwordError").style.display = "block";
      return false;
    } else {
      document.getElementById("passwordError").style.display = "none";
      return true;
    }
  }


    $(document).ready(function () {
$('#schedule').DataTable();
});


function calculateAgeforedit() {
    var today = new Date();
    var birthDate = new Date(document.getElementById("editbirthday").value);
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDiff = today.getMonth() - birthDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    document.getElementById("editage").value = age;
  }

  function calculateAgeforadd() {
    var today = new Date();
    var birthDate = new Date(document.getElementById("addbirthday").value);
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDiff = today.getMonth() - birthDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    document.getElementById("addage").value = age;
  }

</script>

<script>
$(document).on('click', '.editbtn', function() {
  var id = $(this).data('id');
  var url = '../querys/get_patient.php?id=' + id;

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
          $('#firstname').val(data.firstname);
          $('#middleinitial').val(data.middleinitial);
          $('#lastname').val(data.lastname);
          $('#gender').val(data.gender);
          $('#editbirthday').val(data.birthday);
          $('#editage').val(data.age);
          $('#contactnumber').val(data.contactnumber);
          $('#presentaddress').val(data.presentaddress);
          $('#username').val(data.username);
          $('#type_user').val(data.type_user);
          $('#password').val('');
          $('#passwordconfirm').val('');
          
          if (data.image_url) {
            $('#imagePreview').attr('src', data.image_url).show();
          } else {
            $('#imagePreview').hide();
          }
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
img{
	
	width: 100px;
	margin: 10px;
	border-radius: 60%;
	
	
	 
	
	
	}
</style>

</html>