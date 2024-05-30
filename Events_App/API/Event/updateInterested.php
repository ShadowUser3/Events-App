<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database->connect();

$event = new Event($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Update
$event->EventID = $data->EventID;

if ($event->EventID === null) {
    echo json_encode(
        array('message' => 'EventID not provided')
    );
    exit; // Terminate script execution
}

$event->Interested = $data->Interested;

// Update Interested
if ($event->updateInterested()) {
    echo json_encode(
        array('message' => 'Interested count updated successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Error updating interested count')
    );
}