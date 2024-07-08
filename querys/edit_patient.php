<?php
include("db_config.php");
session_start();


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middleinitial = $_POST['middleinitial'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $contactnumber = $_POST['contactnumber'];
    $presentaddress = $_POST['presentaddress'];
    $username = $_POST['username'];
    $type_user = $_POST['type_user'];
    $password = $_POST['password'];
    $image_url = ''; 

    // Check if a new image is uploaded
    if ($_FILES['image_url']['size'] > 0) {
        $target_dir = "../images/Uploads/"; 
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file);
        $image_url = $target_file;
    } else {
        // No new image selected, keep the existing image
        $query_get_image = mysqli_query($connection, "SELECT image_url FROM tbl_patient WHERE id='$id'");
        $row_image = mysqli_fetch_assoc($query_get_image);
        $image_url = $row_image['image_url'];
    }

    $query_check_name = "SELECT COUNT(*) as count FROM tbl_patient WHERE CONCAT(firstname, ' ', lastname) = '$firstname $lastname' AND id != '$id'";
    $result_check_name = mysqli_query($connection, $query_check_name);
    $row_check_name = mysqli_fetch_assoc($result_check_name);
    $name_exists = $row_check_name['count'] > 0;

    $query_check_username = "SELECT COUNT(*) as count FROM tbl_login_info WHERE username = '$username' AND id != '$id'";
    $result_check_username = mysqli_query($connection, $query_check_username);
    $row_check_username = mysqli_fetch_assoc($result_check_username);
    $username_exists = $row_check_username['count'] > 0;

    if ($name_exists) {
        $_SESSION["message"] = "Full name already exists!";
        if ($_SESSION["type_user"] === 'Admin') {
            header("Location: ../admin/patient.php?message=Full%20name%20already%20exists!");
        } elseif ($_SESSION["type_user"] === 'Staff') {
            header("Location: ../staff/patient.php?message=Full%20name%20already%20exists!");
        }
        exit();
    } elseif ($username_exists) {
        $_SESSION["message"] = "Username already exists!";
        if ($_SESSION["type_user"] === 'Admin') {
            header("Location: ../admin/patient.php?message=Username%20already%20exists!");
        } elseif ($_SESSION["type_user"] === 'Staff') {
            header("Location: ../staff/patient.php?message=Username%20already%20exists!");
        }
        exit();
    } else {
        // Update patient information
        $update_patient = mysqli_query($connection, "UPDATE tbl_patient SET 
            image_url='$image_url',
            firstname='$firstname', 
            middleinitial='$middleinitial', 
            lastname='$lastname', 
            gender='$gender', 
            birthday='$birthday', 
            contactnumber='$contactnumber', 
            presentaddress='$presentaddress',
            type_user='$type_user'
            WHERE id='$id'");

        if ($update_patient) {
            // Update login information if username is provided
            $update_login_info = true;
            if (!empty($username)) {
                $password_sql = "";
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $password_sql = ", password='$hashed_password'";
                }
                $update_login_info = mysqli_query($connection, "UPDATE tbl_login_info SET 
                    username='$username' $password_sql 
                    WHERE fk_patient_id='$id'");
            }

            if ($update_login_info) {
                $_SESSION["message"] = "Update Successfully!";
                // Redirect based on user type
                if ($_SESSION["type_user"] === 'Admin') {
                    header("Location: ../admin/patient.php?message=Updated%20Successfully!");
                } elseif ($_SESSION["type_user"] === 'Staff') {
                    header("Location: ../staff/patient.php?message=Updated%20Successfully!");
                } else {
                    echo "Unauthorized user type.";
                }
                exit();
            } else {
                $_SESSION["message"] = "Failed to update login information";
                if ($_SESSION["type_user"] === 'Admin') {
                    header("Location: ../admin/patient.php");
                } elseif ($_SESSION["type_user"] === 'Staff') {
                    header("Location: ../staff/patient.php");
                }
                exit();
            }
        } else {
            $_SESSION["message"] = "Failed to update patient information";
            if ($_SESSION["type_user"] === 'Admin') {
                header("Location: ../admin/patient.php");
            } elseif ($_SESSION["type_user"] === 'Staff') {
                header("Location: ../staff/patient.php");
            }
            exit();
        }
    }
}
mysqli_close($connection);
?>
