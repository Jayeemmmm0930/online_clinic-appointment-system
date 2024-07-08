<?php

include 'db_config.php';


$functionId = $_POST['function_id'];
$checked = $_POST['checked'];


$sql = "UPDATE tbl_acc SET function = $checked WHERE id = $functionId";

if ($connection->query($sql) === TRUE) {
    echo json_encode(array('success' => 'Record updated successfully'));
} else {
    echo json_encode(array('error' => 'Error updating record: ' . $connection->error));
}

$connection->close();
?>
