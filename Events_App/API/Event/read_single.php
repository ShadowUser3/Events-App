<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database -> connect();

$event = new Event($db);

//Get ID
$event->EventID = isset($_GET['id']) ? $_GET['id'] : die();

//Get Event
$event->read();

//Create Array
$event_arr = array(
    'id' => $event->EventID,
    'title' => $event->Title,
    'location' => $event->Location,
    'desc' => html_entity_decode($event->Description),
    'rate' => $event->AverageRating,
    'category' => $event->Category,
    'cover_picture' => $event->CoverPicture,
    'date_time' => $event->DateTime,
    'duration' => $event->Duration,
    'interested' => $event->Interested,
    'going' => $event->Going,
    'organizer' => $event->Organizer,
    'location_link' => $event->LocationLink
);

//Make JSON
print_r(json_encode($event_arr));