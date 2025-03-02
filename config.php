<?php
$servername = "localhost";
$username = "slyhark";
$password = "slyhark123";
$database = "latinbattles";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
