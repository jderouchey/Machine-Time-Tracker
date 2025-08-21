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

if (!empty($data->username) && !empty($data->password)) {
    $username = $data->username;
    $password = $data->password;
    
    $sql = "SELECT id, username, password, fullname FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            http_response_code(200);
            echo json_encode(array(
                "message" => "Login successful",
                "user" => array(
                    "id" => $user['id'],
                    "username" => $user['username'],
                    "fullname" => $user['fullname']
                )
            ));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid credentials"));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "User not found"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields"));
}

$conn->close();
?>