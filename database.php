<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "online_shopping";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
