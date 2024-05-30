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
if (!empty($data->userID) && !empty($data->password)) {
    // Set user properties
    $user->UserID = $data->userID;
    $user->Password = $data->password;

    // Attempt to log in the user
    if ($user->login()) {
        // Login successful
        http_response_code(200);
        echo json_encode(array("message" => "Login successful."));
    } else {
        // Login failed
        http_response_code(401);
        echo json_encode(array("message" => "Invalid User ID or password."));
    }
} else {
    // Required data not provided
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request. Please provide User ID and password."));
}