<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "techblog";
 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (mysqli_ping($conn)) {
    echo "Connection to MySQL database is active.";
}
?>