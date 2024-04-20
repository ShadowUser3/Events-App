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
    'date' => $event->Date,
    'time' => $event->Time,
    'location' => $event->Location,
    'desc' => html_entity_decode($event->Description),
    'rate' => $event->AverageRating,
    'A.ID' => $event->AdminID
);

//Make JSON
print_r(json_encode($event_arr));