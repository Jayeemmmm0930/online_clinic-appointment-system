<?php
include ("db_config.php");

$id = $_POST['id'];


$sql = "UPDATE tbl_transaction SET status = 'Unsuccessful' WHERE id = $id";

if ($connection->query($sql) === TRUE) {
  echo "Status complete successfully";
} else {
  echo "Error updating status: " . $connection->error;
}

$connection->close();
?>
