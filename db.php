<?php
$host = "sql211.infinityfree.com";       // InfinityFree MySQL host
$user = "if0_39778566";                  // Database username
$pass = "AY2526G06";                     // Database password
$dbname = "if0_39778566_ups_monitoring"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
