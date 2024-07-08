<?php
include("../querys/db_config.php");

session_start();

if (!isset($_SESSION["firstname"], $_SESSION["middleinitial"], $_SESSION["lastname"])) {
    header("Location: ../index.php");
    exit();
}

$firstName = $_SESSION["firstname"];
$middleInitial = $_SESSION["middleinitial"];
$lastName = $_SESSION["lastname"];

$stmt = $connection->prepare("SELECT id FROM tbl_patient WHERE firstname = ? AND middleinitial = ? AND lastname = ?");
$stmt->bind_param("sss", $firstName, $middleInitial, $lastName);
$stmt->execute();
$stmt->bind_result($patientId);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_id = $_POST['id_date'];
    $serviceId = $_POST['service'];
    $time = $_POST['time'];

 
    $currentDate = date('Ymd');
    $randomDigits = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $transactionNumber = 'TR-' . $currentDate . '-' . $randomDigits;
    $status = 'Pending';


    $stmt = $connection->prepare("INSERT INTO tbl_transaction (transaction_number, fk_service_id, time_slot, fk_schedule_id, fk_patient_id, status) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error in preparing SQL statement: " . $connection->error);
    }
    $stmt->bind_param("ssssss", $transactionNumber, $serviceId, $time, $date_id, $patientId, $status);

    if ($stmt->execute()) {
  
        $stmt->close();
        $stmt = $connection->prepare("UPDATE tbl_schedule SET slots = slots - 1 WHERE id = ?");
        $stmt->bind_param("i", $date_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Successful!";
            header("Location: ../patient/index.php");
    exit();
        } else {
            echo "Error updating slots: " . $stmt->error;
        }
        exit();
    } else {
        echo "Error inserting transaction: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>
