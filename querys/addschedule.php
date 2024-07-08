<?php
session_start();
include("db_config.php");


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $slots = $_POST["slots"];


    if (strtotime($date) < strtotime(date("Y-m-d"))) {
        echo "Error: Cannot add schedule for past or current date.";
        exit();
    }

    // Insert schedule into the database
    $query = "INSERT INTO tbl_schedule (date_schedule, slots) VALUES ('$date', '$slots')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Schedule added successfully.";
        // Redirect based on user type
        if ($_SESSION["type_user"] === 'Admin') {
            header("Location: ../admin/schedule.php");
        } elseif ($_SESSION["type_user"] === 'Staff') {
            header("Location: ../staff/schedule.php");
        } else {
            echo "Unauthorized user type.";
        }
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    header("Location: ../your_form_page.php");
    exit();
}
?>
