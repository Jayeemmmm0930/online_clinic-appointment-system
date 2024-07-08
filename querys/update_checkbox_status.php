<?php
// Include your database connection file
include 'db_config.php';

$functionStatuses = array();

// Define arrays for each id
$id1FunctionStatuses = array();
$id2FunctionStatuses = array();

$sql = "SELECT id, function FROM tbl_acc WHERE id IN (1, 2)";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Separate function statuses based on id
        if ($row['id'] == 1) {
            $id1FunctionStatuses[] = $row['function'];
        } elseif ($row['id'] == 2) {
            $id2FunctionStatuses[] = $row['function'];
        }
    }

    $connection->close();


    $functionStatuses['id1'] = $id1FunctionStatuses;
    $functionStatuses['id2'] = $id2FunctionStatuses;

    // Return the function statuses as JSON
    echo json_encode($functionStatuses);
} else {
    // If no data found
    echo json_encode(array('error' => 'No data found'));
}
?>

