let charts = {};
let deviceId = parseInt(document.location.search.split('device_id=')[1]) || 1;
let filter = '24h';

const voltageMin = 210;
const voltageMax = 240;

function setFilter(f) {
    filter = f;
    fetchAndUpdateCharts();
}

function fetchAndUpdateCharts() {
    fetch(`getData.php?device_id=${deviceId}&filter=${filter}`)
    .then(res => res.json())
    .then(data => {
        if(data.length === 0) return;

        const timestamps = data.map(r => r.timestamp);

        // Update summary cards
        const latest = data[data.length-1];
        document.getElementById('currentVoltage').innerText = latest.main_voltage;
        document.getElementById('currentBattery').innerText = latest.battery_level;
        document.getElementById('currentFrequency').innerText = latest.load_frequency;

        function createOrUpdateChart(id, label, dataset, color, alertMin=null, alertMax=null) {
            dataset = dataset.map(v => parseFloat(v) || 0);
            let pointColors = dataset.map(v => {
                if(alertMin !== null && alertMax !== null) return (v < alertMin || v > alertMax) ? 'red' : color;
                return color;
            });

            if(charts[id]){
                charts[id].data.labels = timestamps;
                charts[id].data.datasets[0].data = dataset;
                charts[id].data.datasets[0].pointBackgroundColor = pointColors;
                charts[id].update();
            } else {
                charts[id] = new Chart(document.getElementById(id), {
                    type: 'line',
                    data: {
                        labels: timestamps,
                        datasets: [{
                            label: label,
                            data: dataset,
                            borderColor: color,
                            pointBackgroundColor: pointColors,
                            fill: false,
                            tension: 0.2
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: { duration: 1000, easing: 'easeInOutQuart' },
                        scales: {
                            x: { display: true, title: { display: true, text: 'Timestamp' } },
                            y: { display: true, title: { display: true, text: label } }
                        }
                    }
                });
            }
        }

        createOrUpdateChart('mainVoltageChart', 'Main Voltage (V)', data.map(r => r.main_voltage), 'blue', voltageMin, voltageMax);
        createOrUpdateChart('mainCurrentChart', 'Main Current (A)', data.map(r => r.main_current), 'green');
        createOrUpdateChart('batteryVoltageChart', 'Battery Voltage (V)', data.map(r => r.battery_voltage), 'red');
        createOrUpdateChart('batteryCurrentChart', 'Battery Current (A)', data.map(r => r.battery_current), 'orange');
        createOrUpdateChart('batteryLevelChart', 'Battery Level (%)', data.map(r => r.battery_level), 'purple');
        createOrUpdateChart('loadFrequencyChart', 'Load Frequency (Hz)', data.map(r => r.load_frequency), 'brown');
    })
    .catch(err => console.error(err));
}

fetchAndUpdateCharts();
setInterval(fetchAndUpdateCharts, 5000);
