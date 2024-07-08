<?php
include("db_config.php");


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $qry = mysqli_query($connection, "SELECT id, type, fee FROM tbl_service WHERE id='$id'
  ");

  if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $response = array(
      'id' => $row['id'],
      'type' => $row['type'],
      'fee' => $row['fee']
     
    );
    echo json_encode($response);
  } else {
    echo json_encode(array('error' => 'Service not Found'));
  }
}
?>