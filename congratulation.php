<?php
require 'includes/index.php';

if (!isset($_SESSION['email'])) {
    echo "<h2 style='color:green;text-align:center;'>Registration done <br>  Check your mail for password</h2>";
    echo "<h1 style='text-align:center;'><a href='https://mail.google.com'>Mail</a></h1>";

} else {
    $email = $_SESSION['email'];
    $query = "select email,role from users where email='$email'";

    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_assoc($result);
    $role = $rows["role"];
    $_SESSION['role'] = $role;
    echo "<h1 style='text-align:center;background-color:green'>Updation done </h1> <br>";
    echo "<h2 style='text-align:center;'><a href='home.php'> Home</a> </h2>";

}


