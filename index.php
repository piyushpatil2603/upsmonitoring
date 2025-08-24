<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
    exit;
}

// Get device ID from URL
$device_id = isset($_GET['device_id']) ? intval($_GET['device_id']) : 1;

// Default time filter: last 24 hours
$defaultFilter = '24h';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPS Monitoring Dashboard - Device <?php echo $device_id; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Back Button -->
    <div style="margin-bottom: 10px;">
        <a href="devices.php" class="back-button">&larr; Back to Devices</a>
    </div>

    <!-- Logout -->
    <div class="logout-container">
        <form method="post" action="logout.php">
            <input type="submit" value="Logout">
        </form>
    </div>

    <h1>UPS Monitoring - Device <?php echo $device_id; ?></h1>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card">Main Voltage: <span id="currentVoltage">--</span> V</div>
        <div class="card">Battery Level: <span id="currentBattery">--</span> %</div>
        <div class="card">Load Frequency: <span id="currentFrequency">--</span> Hz</div>
    </div>

    <!-- Historical Filter -->
    <div style="text-align:center; margin-bottom:20px;">
        <button onclick="setFilter('24h')">Last 24 Hours</button>
        <button onclick="setFilter('7d')">Last 7 Days</button>
        <button onclick="setFilter('30d')">Last 30 Days</button>
    </div>

    <!-- Graphs -->
    <div class="dashboard">
        <div class="card"><canvas id="mainVoltageChart"></canvas></div>
        <div class="card"><canvas id="mainCurrentChart"></canvas></div>
        <div class="card"><canvas id="batteryVoltageChart"></canvas></div>
        <div class="card"><canvas id="batteryCurrentChart"></canvas></div>
        <div class="card"><canvas id="batteryLevelChart"></canvas></div>
        <div class="card"><canvas id="loadFrequencyChart"></canvas></div>
    </div>

    <!-- External JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="dashboard.js"></script>

</body>
</html>
