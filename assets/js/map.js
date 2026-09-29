let map = L.map('map').setView([0, 0], 2);
let marker = null;

// Load OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

function fetchLatestLocation() {
    fetch('get_location.php')
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                let lat = parseFloat(result.data.latitude);
                let lng = parseFloat(result.data.longitude);
                let time = result.data.created_at;

                document.getElementById('status').innerText = `Last updated: ${time}`;

                if (!marker) {
                    // First time loading pin, center map
                    marker = L.marker([lat, lng]).addTo(map);
                    map.setView([lat, lng], 16);
                } else {
                    // Move marker smoothly to new position
                    marker.setLatLng([lat, lng]);
                }
            } else {
                document.getElementById('status').innerText = 'No location data available yet.';
            }
        })
        .catch(error => {
            console.error('Error fetching location:', error);
            document.getElementById('status').innerText = 'Error connecting to server.';
        });
}

// Fetch location immediately, then poll every 10 seconds
fetchLatestLocation();
setInterval(fetchLatestLocation, 10000);