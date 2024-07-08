<?php
include("db_config.php");
session_start();


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $connection->prepare("DELETE FROM tbl_schedule WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Schedule deleted successfully.";
         
            if ($_SESSION["type_user"] === 'Admin') {
                header("Location: ../admin/schedule.php");
            } elseif ($_SESSION["type_user"] === 'Staff') {
                header("Location: ../staff/schedule.php");
            } else {
                echo "Unauthorized user type.";
            }
            exit();
        } else {
            echo "No schedule found with the given ID.";
        }
    } else {
        echo "Failed to delete schedule: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID parameter missing.";
}

$connection->close();
?>
