<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//initializing API
include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database -> connect();

$event = new Event($db);

$result = $event->readAll();
$num = $result->rowCount();

if ($num > 0) {
    $event_arr = array();
    $event_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $event_item = array(
            'id' => $EventID,
            'title' => $Title,
            'date' => $DateTime,
            'location' => $Location,
            'desc' => html_entity_decode($Description),
            'rate' => $AverageRating,
            'category' => $Category,
            'cover_picture' => $CoverPicture,
            'duration' => $Duration,
            'interested' => $Interested,
            'going' => $Going,
            'organizer' => $Organizer,
            'location_link' => $LocationLink
        );
        array_push($event_arr['data'], $event_item);
    }

    echo json_encode($event_arr);
}
else {
    echo json_encode(array('message' => 'No events found.'));
}