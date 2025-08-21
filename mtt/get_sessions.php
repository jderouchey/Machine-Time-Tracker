<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$servername = "https://mtt.orgmodejournal.blog/";
$username = "u746111986_jderoucheyutt";
$password = "6@L9qJ93y";
$dbname = "u746111986_mtt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    $sql = "SELECT machine, start_time, end_time, duration, objective_achieved, notes 
            FROM sessions WHERE user_id = '$user_id' ORDER BY start_time DESC";
    $result = $conn->query($sql);
    
    $sessions = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
    }
    
    http_response_code(200);
    echo json_encode(array("sessions" => $sessions));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "User ID required"));
}

$conn->close();
?>