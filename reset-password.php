<?php
require 'includes/index.php';

$token = $_REQUEST["key"];

$sql = "select email from users where token='$token'";

$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_assoc($result);

if ($rows) {
    $_SESSION['email'] = $rows['email'];
    header('location:update-password.php');
} else {
    echo "<h1> Page Not Found";
}

