<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ups_monitoring";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct device IDs
$result = $conn->query("SELECT DISTINCT device_id FROM power_data ORDER BY device_id ASC");
$devices = [];
while($row = $result->fetch_assoc()) {
    $devices[] = $row['device_id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Devices Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logout-container">
        <form method="post" action="logout.php">
            <input type="submit" value="Logout">
        </form>
    </div>

    <h1>Available UPS Devices</h1>

    <div class="dashboard">
        <?php foreach($devices as $device_id): ?>
            <div class="card">
                <h3>UPS Device <?php echo $device_id; ?></h3>
                <a href="index.php?device_id=<?php echo $device_id; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
