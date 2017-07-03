<?php

// Database connection
$config = require 'config.php';

$conn = mysqli_connect($config["DB_HOST"], $config["DB_USER"], $config["DB_PASSWORD"], $config["DB_NAME"]);
