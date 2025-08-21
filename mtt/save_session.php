<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$servername = "https://mtt.orgmodejournal.blog/";
$username = "jderoucheyutt";
$password = "6@L9qJ93y";
$dbname = "u746111986_mtt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id) && !empty($data->session)) {
    $user_id = $data->user_id;
    $session = $data->session;
    
    $machine = $conn->real_escape_string($session->machine);
    $start_time = $conn->real_escape_string($session->startTime);
    $end_time = $conn->real_escape_string($session->endTime);
    $duration = $session->duration;
    $objective_achieved = $session->objectiveAchieved ? 1 : 0;
    $notes = $conn->real_escape_string($session->notes);
    
    $sql = "INSERT INTO sessions (user_id, machine, start_time, end_time, duration, objective_achieved, notes) 
            VALUES ('$user_id', '$machine', '$start_time', '$end_time', '$duration', '$objective_achieved', '$notes')";
    
    if ($conn->query($sql)) {
        http_response_code(201);
        echo json_encode(array("message" => "Session saved successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error saving session"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields"));
}

$conn->close();
?>