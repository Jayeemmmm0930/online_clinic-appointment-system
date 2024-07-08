<?php
include("db_config.php");
session_start();

// Check if the user is logged in and has a valid user type
if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}



$id = $_GET['id'];

$delete_patient = mysqli_query($connection, "DELETE FROM tbl_patient WHERE id='$id'");
$delete_login_info = mysqli_query($connection, "DELETE FROM tbl_login_info WHERE fk_patient_id='$id'");

if ($delete_patient && $delete_login_info) {
    echo 'DELETING SUCCESSFULLY UPDATED!';
} else {
    echo 'DELETING DATA FAILED!';
}

// Redirect based on user type
if ($_SESSION["type_user"] === 'Admin') {
    header("Location: ../admin/patient.php");
} elseif ($_SESSION["type_user"] === 'Staff') {
    header("Location: ../staff/patient.php");
} else {
    echo "Unauthorized user type.";
}

exit();
?>
