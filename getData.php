<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ups_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$device_id = isset($_GET['device_id']) ? intval($_GET['device_id']) : 1;
$filter = isset($_GET['filter']) ? $_GET['filter'] : '24h';

$from = date('Y-m-d H:i:s', strtotime('-24 hours'));
if($filter == '7d') $from = date('Y-m-d H:i:s', strtotime('-7 days'));
if($filter == '30d') $from = date('Y-m-d H:i:s', strtotime('-30 days'));

$sql = "SELECT * FROM power_data WHERE device_id=$device_id AND timestamp >= '$from' ORDER BY timestamp ASC";
$result = $conn->query($sql);

$data = [];
while($row = $result->fetch_assoc()) $data[] = $row;

header('Content-Type: application/json');
echo json_encode($data);
?>
