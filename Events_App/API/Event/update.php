// This file is not used
// It was the original file for updating events before deciding it was not needed
// It was replaced with the three other update methods

<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Resquested-With');

include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database -> connect();

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

$event->Title = $data->Title;
$event->Date = $data->Date;
$event->Time = $data->Time;
$event->Location = $data->Location;
$event->Description = $data->Description;
$event->AverageRating = $data->AverageRating;

//Update Event
if ($event->update()) {
    echo json_encode(
        array('message => Event updated successfully')
    );
} else {
    echo json_encode(
        array('message => Error updating Event')
    );
}