<?php
// connects to database 
$dbServerName = "localhost";
$dbUsername = "id15585397_eggy";
$dbPassword = "A]f8(/B5d#\EaM!j";
$dbName = "id15585397_ryeviews";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}
