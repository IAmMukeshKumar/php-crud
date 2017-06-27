<?php
require 'includes/index.php';

if(!isset($_SESSION['email']))
    header('location:index.php');

$key=$_GET["delete_key"];
$query="DELETE FROM users
WHERE id='$key'";
$result=mysqli_query($conn,$query);


