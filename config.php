<?php
$servername = "26.189.202.230";
$username = "slyhark";
$password = "slyhark123";
$database = "latinbat_pvpgn";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
