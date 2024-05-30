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

// Get Going Events
$goingEvents = $user->getGoingEvents();

// Make JSON
echo json_encode($goingEvents);