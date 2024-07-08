<?php
include ("db_config.php");
// Check if 'id' parameter is set
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Prepare and bind
  $stmt = $connection->prepare("SELECT id, date_schedule, slots FROM tbl_schedule WHERE id = ?");
  $stmt->bind_param("i", $id);

  // Execute the query
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc();
      echo json_encode($data);
    } else {
      echo json_encode(['error' => 'No schedule found with the given ID']);
    }
  } else {
    echo json_encode(['error' => 'Query execution failed']);
  }

  $stmt->close();
} else {
  echo json_encode(['error' => 'ID parameter missing']);
}

$connection->close();
?>
