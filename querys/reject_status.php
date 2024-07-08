<?php
include ("db_config.php");

$id = $_POST['id'];


$sql = "UPDATE tbl_transaction SET status = 'Reject' WHERE id = $id";

if ($connection->query($sql) === TRUE) {
  echo "Status updated successfully";
} else {
  echo "Error updating status: " . $connection->error;
}

$connection->close();
?>
