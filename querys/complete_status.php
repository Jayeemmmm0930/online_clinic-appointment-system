<?php
include("db_config.php");
session_start();

// Check if the user is logged in and has a valid patient type
if (!isset($_SESSION["type_user"])) {
    echo "Unauthorized access.";
    exit();
}

$id = $_POST['id'];

$sql = "UPDATE tbl_transaction SET status = 'Complete' WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Status updated successfully";
    // Redirect based on user type
    if ($_SESSION["type_user"] === 'Admin') {
        header("Location: ../admin/transactions.php");
    } elseif ($_SESSION["type_user"] === 'Staff') {
        header("Location: ../staff/transactions.php");
    }  else {
        echo "Unauthorized user type.";
    }
    exit();
} else {
    echo "Error updating status: " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
