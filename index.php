<?php
session_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); 
} else {
    $message = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <!-- Modals for displaying various messages -->
    <div class="modal fade" id="fullNameRegisteredModal" tabindex="-1" role="dialog" aria-labelledby="nameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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

    <div class="modal fade" id="usernameErrorModal" tabindex="-1" role="dialog" aria-labelledby="usernameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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

    <div class="modal fade" id="successAdd" tabindex="-1" role="dialog" aria-labelledby="nameErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameErrorModalLabel">Resgister</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Successfully Registered!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Registration Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="querys/register.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
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
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="passwordreg">Password</label>
                                    <input type="password" class="form-control" id="passwordreg" name="passwordreg" placeholder="Password" required>
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="login-container">
        <!-- Add your logo image -->
        <img src="images.png" alt="Logo" class="logo">
        <h2>Login</h2>
        <form action="querys/login.php" method="post">
            <div class="form-group">
                <label for="usernamelogin"><i class="fas fa-user icon"></i>Username</label>
                <input type="text" id="usernamelogin" name="usernamelogin" required>
            </div>
            <div class="form-group">
                <label for="passwordlogin"><i class="fas fa-lock icon"></i>Password</label>
                <div class="password-input">
                    <input type="password" id="passwordlogin" name="passwordlogin" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </span>
                </div>
            </div>
            <?php
  
        if (isset($_SESSION["login_error"])) {
      
            echo '<p style="color: red;">' . $_SESSION["login_error"] . '</p>';
         
            unset($_SESSION["login_error"]);
        }
        ?>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="or-separator">
            <span class="or-text">or</span>
        </div>
        <div class="form-group">
        <input type="button" value="Register" onclick="openRegisterModal();">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>

    <input type="hidden" id="sessionMessage" value="<?= $message ?>">
</body>


</html>
