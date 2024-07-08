<?php

include("db_config.php");


if (isset($_GET['date'])) {
    $date = $_GET['date'];

 
    $sql = "SELECT id FROM tbl_schedule WHERE date_schedule = ?";
    $stmt = $connection->prepare($sql);
    
    if ($stmt === false) {
   
        die("Error in preparing SQL statement: " . $connection->error);
    }

    $stmt->bind_param("s", $date);
    $stmt->execute();

    if ($stmt->error) {
    
        die("Error executing SQL statement: " . $stmt->error);
    }

    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();


    echo $id;
} else {
  
    echo "Date parameter is missing";
}
?>
