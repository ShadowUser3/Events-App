<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/index.php');
include_once('../../models/user.php');

$database = new Database();
$db = $database->connect();

$user = new User($db);

// Get ID
$user->UserID = isset($_GET['id']) ? $_GET['id'] : die();

// Get Interested Events
$interestedEvents = $user->getInterestedEvents();

// Make JSON
echo json_encode($interestedEvents);