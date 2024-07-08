<?php
session_start();
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION["type_user"])) {
        echo "Unauthorized access.";
        exit();
    }

    $date = $_POST['date'];
    $description = $_POST['description'];

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO tbl_holidays (date, description) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $date, $description);

    if ($stmt->execute() === TRUE) {
        echo "Holiday added successfully";
        // Redirect based on the user type stored in the session
        if ($_SESSION["type_user"] === 'Admin') {
            header("Location: ../admin/holidays.php");
        } elseif ($_SESSION["type_user"] === 'Staff') {
            header("Location: ../staff/holidays.php");
        } else {
            echo "Unauthorized user type.";
        }
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
} else {
    echo "Invalid request method.";
}
?>
