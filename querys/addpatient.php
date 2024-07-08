<?php
session_start();
include("db_config.php");


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}

$firstname = $_POST['firstname'];
$middleinitial = $_POST['middleinitial'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$age = $_POST['age'];
$contactnumber = $_POST['contactnumber'];
$presentaddress = $_POST['presentaddress'];
$username = $_POST['username'];
$userType = $_POST['userType'];
$password = $_POST['password'];
$image_url = '';

// Handle file upload
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../images/Uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_url = $target_file;
    } else {
        $image_url = "../images/Uploads/1954.png"; 
    }
} else {
    $image_url = "../images/Uploads/1954.png"; 
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query_check_name = "SELECT COUNT(*) as count FROM tbl_patient WHERE CONCAT(firstname, ' ', lastname) = ?";
$stmt_check_name = $connection->prepare($query_check_name);
$full_name = "$firstname $lastname";
$stmt_check_name->bind_param("s", $full_name);
$stmt_check_name->execute();
$result_check_name = $stmt_check_name->get_result();
$row_check_name = $result_check_name->fetch_assoc();
$name_exists = $row_check_name['count'] > 0;


$query_check_username = "SELECT COUNT(*) as count FROM tbl_login_info WHERE username = ?";
$stmt_check_username = $connection->prepare($query_check_username);
$stmt_check_username->bind_param("s", $username);
$stmt_check_username->execute();
$result_check_username = $stmt_check_username->get_result();
$row_check_username = $result_check_username->fetch_assoc();
$username_exists = $row_check_username['count'] > 0;


if ($name_exists) {
    if ($_SESSION["type_user"] === 'Admin') {
        header("Location: ../admin/patient.php?message=Full%20name%20already%20exists!");
    } elseif ($_SESSION["type_user"] === 'Staff') {
        header("Location: ../staff/patient.php?message=Full%20name%20already%20exists!");
    } else {
        echo "Unauthorized user type.";
    }
    exit();
} elseif ($username_exists) {
    if ($_SESSION["type_user"] === 'Admin') {
        header("Location: ../admin/patient.php?message=Username%20already%20exists!");
    } elseif ($_SESSION["type_user"] === 'Staff') {
        header("Location: ../staff/patient.php?message=Username%20already%20exists!");
    } else {
        echo "Unauthorized user type.";
    }
    exit();
} else {
 
    $query_patient = "INSERT INTO tbl_patient (image_url, firstname, middleinitial, lastname, gender, birthday, age, contactnumber, presentaddress, type_user) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_patient = $connection->prepare($query_patient);
    $stmt_patient->bind_param("ssssssisss", $image_url, $firstname, $middleinitial, $lastname, $gender, $birthday, $age, $contactnumber, $presentaddress, $userType);

    if ($stmt_patient->execute()) {
        $patient_id = $stmt_patient->insert_id;


        $query_login = "INSERT INTO tbl_login_info (username, password, fk_patient_id) 
                        VALUES (?, ?, ?)";
        $stmt_login = $connection->prepare($query_login);
        $stmt_login->bind_param("ssi", $username, $hashed_password, $patient_id);

        if ($stmt_login->execute()) {
      
            if ($_SESSION["type_user"] === 'Admin') {
                header("Location: ../admin/patient.php?message=Add%20Successfully!");
            } elseif ($_SESSION["type_user"] === 'Staff') {
                header("Location: ../staff/patient.php?message=Add%20Successfully!");
            } else {
                echo "Unauthorized user type.";
            }
            exit();
        } else {
            echo "Error: " . $stmt_login->error;
        }
    } else {
        echo "Error: " . $stmt_patient->error;
    }
}


$stmt_check_name->close();
$stmt_check_username->close();
$stmt_patient->close();
$stmt_login->close();
$connection->close();
?>
