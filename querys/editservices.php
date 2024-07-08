<?php
include("db_config.php");
session_start();

// Check if the user is logged in and has a valid user type
if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}


if (isset($_POST['id']) && isset($_POST['type']) && isset($_POST['fee'])) {
    $id = intval($_POST['id']);
    $type = $_POST['type'];
    $fee = $_POST['fee'];

    $stmt = $connection->prepare("UPDATE tbl_service SET type = ?, fee = ? WHERE id = ?");
    $stmt->bind_param("ssi", $type, $fee, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Service updated successfully.";
            header("Location: ../admin/service.php");
            exit();
        } else {
            echo "No changes made or invalid service ID.";
        }
    } else {
        echo "Failed to update service: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "All fields are required.";
}

$connection->close();
?>
