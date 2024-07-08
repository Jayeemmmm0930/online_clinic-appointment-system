<?php
session_start(); 
include("db_config.php");

$firstname = $_POST['firstname'];
$middleinitial = $_POST['middleinitial'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$age = $_POST['age'];
$contactnumber = $_POST['contactnumber'];
$presentaddress = $_POST['presentaddress'];
$username = $_POST['username'];

$password = $_POST['passwordreg'];
$image_url = ''; 


if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../images/Uploads/"; 
    $target_file = $target_dir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    $image_url = $target_file;
}else {

    $image_url = "../images/Uploads/1954.png";
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$query_check_name = "SELECT COUNT(*) as count FROM tbl_patient WHERE CONCAT(firstname, ' ', lastname) = '$firstname $lastname'";
$result_check_name = mysqli_query($connection, $query_check_name);
$row_check_name = mysqli_fetch_assoc($result_check_name);
$name_exists = $row_check_name['count'] > 0;


$query_check_username = "SELECT COUNT(*) as count FROM tbl_login_info WHERE username = '$username'";
$result_check_username = mysqli_query($connection, $query_check_username);
$row_check_username = mysqli_fetch_assoc($result_check_username);
$username_exists = $row_check_username['count'] > 0;

if ($name_exists) {
    $_SESSION['message'] = "Full name already exists!";
    header("Location: ../index.php");
    exit();
} elseif ($username_exists) {
    $_SESSION['message'] = "Username already exists!";
    header("Location: ../index.php");
    exit();
} else {
   

  
    $query_patient = "INSERT INTO tbl_patient (image_url, firstname, middleinitial, lastname, gender, birthday, age, contactnumber, presentaddress, type_user) 
                      VALUES ('$image_url','$firstname', '$middleinitial', '$lastname', '$gender', '$birthday', '$age', '$contactnumber', '$presentaddress','Patient')";

    if (mysqli_query($connection, $query_patient)) {
       
        $patient_id = mysqli_insert_id($connection);

     
        $query_login = "INSERT INTO tbl_login_info (username, password, fk_patient_id) 
                        VALUES ('$username', '$hashed_password', '$patient_id')";

        if (mysqli_query($connection, $query_login)) {
            $_SESSION['message'] =  "Add Successfully!";
            header("Location: ../index.php");
                exit();
        } else {
            echo "Error: " . $query_login . "<br>" . mysqli_error($connection);
        }
    } else {
        echo "Error: " . $query_patient . "<br>" . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>