<?php
include 'db.php';

$voltage = $_POST['voltage'] ?? 0;
$current = $_POST['current'] ?? 0;
$frequency = $_POST['frequency'] ?? 0;

$stmt = $conn->prepare("INSERT INTO ups_data (voltage, current, frequency) VALUES (?, ?, ?)");
$stmt->bind_param("ddd", $voltage, $current, $frequency);
$stmt->execute();
echo "Data inserted";
?>