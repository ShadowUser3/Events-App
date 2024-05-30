<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/index.php');
include_once('../../models/user.php');

$database = new Database();
$db = $database->connect();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

// Check if the required fields are provided
if (!empty($data->userID)) {
    // Set user ID
    $user->UserID = $data->userID;

    // Attempt to log out the user
    if ($user->logout()) {
        // Logout successful
        http_response_code(200);
        echo json_encode(array("message" => "Logout successful."));
    } else {
        // Logout failed
        http_response_code(500);
        echo json_encode(array("message" => "Failed to log out the user."));
    }
} else {
    // Required data not provided
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request. Please provide User ID."));
}