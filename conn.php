<?php 
$serverename = "localhost";
$username = "root";
$password = "";
$dbname = "farmingdb";

$conn = new mysqli($serverename, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connecton Failed: " . $conn->connect_error);

}
?>