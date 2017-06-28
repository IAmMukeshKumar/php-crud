<?php
session_start();
if(!isset($_SESSION['email']))
{
    header('location:index.php');
}
else {
    echo "Registration done";
    echo "Check your mail for password";
}