<?php
session_start();
include("db_config.php");


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['service'];
    $fee = $_POST['fee'];

    $sql = "INSERT INTO tbl_service (type, fee) VALUES ('$type', '$fee')";

    if ($connection->query($sql) === TRUE) {
        echo "Service added successfully";
        // Redirect based on user type
        if ($_SESSION["type_user"] === 'Admin') {
            header("Location: ../admin/service.php");
        } elseif ($_SESSION["type_user"] === 'Staff') {
            header("Location: ../staff/service.php");
        } else {
            echo "Unauthorized user type.";
        }
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    $connection->close();
}
?>
