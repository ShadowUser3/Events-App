<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Resquested-With');

include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database -> connect();

$event = new Event($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$event->Title = $data->Title;
$event->DateTime = $data->DateTime;
$event->Location = $data->Location;
$event->Description = $data->Description;
$event->AverageRating = $data->AverageRating;
$event->Category = $data->Category;
$event->CoverPicture = $data->CoverPicture;
$event->Duration = $data->Duration;
$event->Interested = $data->Interested;
$event->Going = $data->Going;
$event->Organizer = $data->Organizer; 
$event->LocationLink = $data->LocationLink;

//Create Event
if ($event->create()) {
    echo json_encode(
        array('message => Event created successfully')
    );
} else {
    echo json_encode(
        array('message => Error creating Event')
    );
}