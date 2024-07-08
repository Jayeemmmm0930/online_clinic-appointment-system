<?php
session_start();

include_once "db_config.php";
$default_username = "Super";
$default_password = password_hash("Super", PASSWORD_DEFAULT);
$default_firstname = "Super";
$default_middleinitial = "Type";
$default_lastname = "Admin";
$default_image_url = "../images/Uploads/1954.png";
$default_type_user = "Admin";

// Check if the server request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle login form submission

    $username = $_POST["usernamelogin"];
    $password = $_POST["passwordlogin"];

    // Check if the submitted credentials match the default account
    if ($username === $default_username && password_verify($password, $default_password)) {
        // Set session variables for the default account
        $_SESSION["username"] = $default_username;
        $_SESSION["firstname"] = $default_firstname;
        $_SESSION["middleinitial"] = $default_middleinitial;
        $_SESSION["lastname"] = $default_lastname;
        $_SESSION["image_url"] = $default_image_url;
        $_SESSION["type_user"] = $default_type_user;

        // Redirect to appropriate page based on user type
        if ($default_type_user == 'Admin') {
            header("Location: ../admin/index.php");
            exit();
       
        }
    } else {
        // If the submitted credentials do not match the default account, proceed with the regular login process

        // Execute the main login query
        $sql = "SELECT password, fk_patient_id FROM tbl_login_info WHERE username = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Fetch user data from the database
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];
            $fk_patient_id = $row['fk_patient_id'];

            $sql_patient = "SELECT type_user, firstname, middleinitial, lastname, image_url FROM tbl_patient WHERE id = ?";
            $stmt_patient = $connection->prepare($sql_patient);
            $stmt_patient->bind_param("i", $fk_patient_id);
            $stmt_patient->execute();
            $result_patient = $stmt_patient->get_result();

            if ($result_patient->num_rows === 1) {
        
                $row_patient = $result_patient->fetch_assoc();
                $patient_type = $row_patient['type_user'];
                $firstname = $row_patient['firstname'];
                $middleinitial = $row_patient['middleinitial'];
                $lastname = $row_patient['lastname'];
                $image_url = $row_patient['image_url'];

                // Verify password
                if (password_verify($password, $stored_password)) {
                    // Set session variables
                    $_SESSION["username"] = $username;
                    $_SESSION["firstname"] = $firstname;
                    $_SESSION["middleinitial"] = $middleinitial;
                    $_SESSION["lastname"] = $lastname;
                    $_SESSION["image_url"] = $image_url;
                    $_SESSION["type_user"] = $patient_type;

                    // Redirect based on user type
                    if ($patient_type == 'Admin') {
                        header("Location: ../admin/index.php");
                        exit();
                    } elseif ($patient_type == 'Staff') {
                        header("Location: ../staff/index.php");
                        exit();
                    } elseif ($patient_type == 'Patient') {
                        header("Location: ../patient/index.php");
                        exit();
                    } else {
                        $_SESSION["login_error"] = "Unknown patient type.";
                        header("Location: ../index.php");
                        exit();
                    }
                } else {
                    $_SESSION["login_error"] = "Invalid username or password.";
                    header("Location: ../index.php");
                    exit();
                }
            } else {
                $_SESSION["login_error"] = "Patient not found.";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION["login_error"] = "Invalid username or password.";
            header("Location: ../index.php");
            exit();
        }
    }
} else {
    // If the server request method is not POST, do nothing
}

// Check if the default admin account already exists
$sql_check_default = "SELECT * FROM tbl_login_info WHERE username = ?";
$stmt_check_default = $connection->prepare($sql_check_default);
$stmt_check_default->bind_param("s", $default_username);
$stmt_check_default->execute();
$result_check_default = $stmt_check_default->get_result();

if ($result_check_default->num_rows === 0) {
    // Insert the default admin account into the database
    $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
    
    // Insert into tbl_login_info
    $sql_insert_login_info = "INSERT INTO tbl_login_info (username, password, fk_patient_id) VALUES (?, ?, ?)";
    $stmt_insert_login_info = $connection->prepare($sql_insert_login_info);
    $stmt_insert_login_info->bind_param("ssi", $default_username, $hashed_password, $default_patient_id);
    $stmt_insert_login_info->execute();

    // Get the ID of the newly inserted login info
    $default_patient_id = $stmt_insert_login_info->insert_id;

    // Insert into tbl_patient
    $sql_insert_patient = "INSERT INTO tbl_patient (type_user, firstname, middleinitial, lastname, image_url) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_patient = $connection->prepare($sql_insert_patient);
    $stmt_insert_patient->bind_param("sssss", $default_type_user, $default_firstname, $default_middleinitial, $default_lastname, $default_image_url);
    $stmt_insert_patient->execute();

    // Get the ID of the newly inserted patient
    $default_patient_id = $stmt_insert_patient->insert_id;

    // Update the foreign key in tbl_login_info
    $sql_update_login_info = "UPDATE tbl_login_info SET fk_patient_id = ? WHERE username = ?";
    $stmt_update_login_info = $connection->prepare($sql_update_login_info);
    $stmt_update_login_info->bind_param("is", $default_patient_id, $default_username);
    $stmt_update_login_info->execute();
}

// Close the database connection
$connection->close();
?>
