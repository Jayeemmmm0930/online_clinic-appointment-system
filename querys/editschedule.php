<?php
include("db_config.php");
session_start();


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}



if (isset($_POST['id']) && isset($_POST['date']) && isset($_POST['slots'])) {
    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $slots = intval($_POST['slots']);

    // Check if the date is in the past or current date
    if (strtotime($date) < strtotime(date("Y-m-d"))) {
        echo "Error: Cannot add schedule for past or current date.";
        exit();
    }

    $stmt = $connection->prepare("UPDATE tbl_schedule SET date_schedule = ?, slots = ? WHERE id = ?");
    $stmt->bind_param("sii", $date, $slots, $id);

    // Execute the query
    if ($stmt->execute()) {
        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            echo "Schedule updated successfully.";
            if ($_SESSION["type_user"] === 'Admin') {
                header("Location: ../admin/schedule.php");
            } elseif ($_SESSION["type_user"] === 'Staff') {
                header("Location: ../staff/schedule.php");
            }
            exit();
        } else {
            echo "No changes made or invalid schedule ID.";
        }
    } else {
        echo "Failed to update schedule: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "All fields are required.";
}

$connection->close();
?>
