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

// Get User
$user->read();

// Create Array
$user_arr = array(
    'UserID' => $user->UserID,
    'Password' => $user->Password,
    'Name' => $user->Name,
    'Email' => $user->Email,
    'Role' => $user->Role,
    'ProfilePic' => $user->ProfilePic
);

// Make JSON
print_r(json_encode($user_arr));