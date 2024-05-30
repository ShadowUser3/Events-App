<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/index.php');
include_once('../../models/event.php');

$database = new Database();
$db = $database->connect();

$event = new Event($db);

// Get the event ID from the query parameters
$eventID = isset($_GET['id']) ? $_GET['id'] : die(json_encode(array('message' => 'Event ID is missing.')));

// Retrieve the event gallery images
$gallery = $event->getGalleryImages($eventID);

if ($gallery === null) {
    // Event ID doesn't exist in the database
    die(json_encode(array('message' => 'Invalid event ID.')));
}

if (empty($gallery)) {
    // No photos found for the event ID
    echo json_encode(array('message' => 'No photos found for the event.'));
} else {
    // Create an array to hold the gallery image URLs
    $galleryUrls = array();

    foreach ($gallery as $image) {
        $galleryUrls[] = $image['ImageURL'];
    }

    // Output the gallery image URLs as JSON
    echo json_encode($galleryUrls);
}