<?php
// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and User class files
include_once('../../config/index.php');
include_once '../../models/user.php';
include_once '../../models/event.php';

// Instantiate the database object
$database = new Database();
$db = $database->connect();

// Initialize the User and Event objects
$user = new User($db);
$event = new Event($db);

// Get the UserID from the request
$user->UserID = $_GET['userID'];

// Check if UserID is provided
if (empty($user->UserID)) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request. Please provide UserID."));
    exit;
}

$user_ratings = $user->getUserRatings();

// Check if any ratings exist
if (!empty($user_ratings)) {
    // Ratings found, return them as JSON
    http_response_code(200);
    echo json_encode($user_ratings);
} else {
    // No ratings found
    http_response_code(404);
    echo json_encode(array("message" => "No ratings found for the user."));
}