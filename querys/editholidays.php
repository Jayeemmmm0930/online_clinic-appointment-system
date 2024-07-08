<?php
include("db_config.php");
session_start();

// Check if the user is logged in and has a valid user type
if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}




if (isset($_POST['id']) && isset($_POST['exampleInputDate']) && isset($_POST['description'])) {
    $id = intval($_POST['id']);
    $date = $_POST['exampleInputDate'];
    $description = $_POST['description'];

    $stmt = $connection->prepare("UPDATE tbl_holidays SET date = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $date, $description, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Holiday updated successfully.";
            if ($_SESSION["type_user"] === 'Admin') {
                header("Location: ../admin/holidays.php");
            } elseif ($_SESSION["type_user"] === 'Staff') {
                header("Location: ../staff/holidays.php");
            }
            exit();
        } else {
            echo "No changes made or invalid holiday ID.";
        }
    } else {
        echo "Failed to update holiday: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "All fields are required.";
}

$connection->close();
?>
