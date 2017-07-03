<?php
require 'includes/index.php';

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    http_response_code(401);
    die;
}

$key = $_GET["id"];

$key = mysqli_real_escape_string($conn,$key);

$query = "DELETE FROM users WHERE id='$key'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => true]);
} else {
    http_response_code(400);
}
die;


