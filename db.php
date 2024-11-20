<?php

$host = 'localhost';   
$dbname = 'a2project';
$username = 'root';     
$password = '';         

$db = new mysqli($host, $username, $password, $dbname);


if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
