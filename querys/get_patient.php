<?php
include("db_config.php");

function calculateAge($birthday) {
  $birthDate = new DateTime($birthday);
  $today = new DateTime();
  $age = $today->diff($birthDate)->y;
  return $age;
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $qry = mysqli_query($connection, "
    SELECT tbl_patient.id, tbl_patient.firstname, tbl_patient.middleinitial, tbl_patient.lastname, tbl_patient.gender, tbl_patient.birthday, tbl_patient.contactnumber, tbl_patient.presentaddress, tbl_patient.type_user, tbl_patient.image_url, tbl_login_info.username
    FROM tbl_patient 
    LEFT JOIN tbl_login_info ON tbl_patient.id = tbl_login_info.fk_patient_id 
    WHERE tbl_patient.id='$id'
  ");

  if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $response = array(
      'id' => $row['id'],
      'firstname' => $row['firstname'],
      'middleinitial' => $row['middleinitial'],
      'lastname' => $row['lastname'],
      'gender' => $row['gender'],
      'birthday' => $row['birthday'],
      'age' => calculateAge($row['birthday']),
      'contactnumber' => $row['contactnumber'],
      'presentaddress' => $row['presentaddress'],
      'username' => $row['username'],
      'type_user' => $row['type_user'],
      'image_url' => $row['image_url']
    );
    echo json_encode($response);
  } else {
    echo json_encode(array('error' => 'Patient not found'));
  }
}
?>
