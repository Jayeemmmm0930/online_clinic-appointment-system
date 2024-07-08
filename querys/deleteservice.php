<?php
include("db_config.php");
session_start();


if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}


if ($_SESSION["type_user"] !== 'Admin' && $_SESSION["type_user"] !== 'Staff') {
    echo "Unauthorized access.";
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $connection->prepare("DELETE FROM tbl_service WHERE id = ?");
    $stmt->bind_param("i", $id);


    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Service deleted successfully.";
         
            if ($_SESSION["type_user"] === 'Admin') {
                header("Location: ../admin/service.php");
            } elseif ($_SESSION["type_user"] === 'Staff') {
                header("Location: ../staff/service.php");
            } else {
                echo "Unauthorized user type.";
            }
            exit();
        } else {
            echo "No service found with the given ID.";
        }
    } else {
        echo "Failed to delete service: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID parameter missing.";
}

$connection->close();
?>
