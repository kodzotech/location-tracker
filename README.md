"# location-tracker" 
# Live Location Tracker (Android & PHP Backend)

A lightweight, self-hosted location-tracking system consisting of an Android background service that posts GPS coordinates to a secure PHP backend, visualized in real-time on a mobile-responsive web dashboard using Leaflet.js.

## 🚀 Tech Stack
* **Android App:** Java, OkHttp, Google Play Services (Fused Location Provider)
* **Backend API:** PHP (PDO), MySQL/PostgreSQL
* **Hosting / Deployment:** Wasmer Edge / Local WampServer
* **Frontend Dashboard:** HTML5, CSS3, Leaflet.js, OpenStreetMap

---

## 📁 Project Structure

```text
location-tracker/
├── backend/                # PHP Server API endpoints & database config
│   ├── config.php          # Database connection (supports Wasmer env vars)
│   ├── update_location.php # Receives POST data from Android app
│   ├── get_location.php    # Returns latest coordinates as JSON for map
│   └── database.sql        # MySQL table schema
├── frontend/               # Web Dashboard
│   ├── index.html          # Leaflet map container
│   └── assets/             # CSS and JS (Leaflet polling logic)
└── android-app/            # Android Studio Source Files
    └── app/src/main/java/...
