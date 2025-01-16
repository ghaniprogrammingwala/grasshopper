<?php
$servername = "localhost";
$username = "ujqchwqxt5tqa";
$password = "zxq7grgklgs9";
$dbname = "dbcakkevhaycw1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
