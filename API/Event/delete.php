<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Resquested-With');

include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database -> connect();

$event = new Event($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$event->EventID = $data->EventID;

//Update Event
if ($event->delete()) {
    echo json_encode(
        array('message => The Event was deleted successfully')
    );
} else {
    echo json_encode(
        array('message => Error while deleting the Event')
    );
}