<?php
require_once 'config.php';

header('Content-Type: application/json');

// Fetch the most recent location record
$stmt = $pdo->query("SELECT device_id, latitude, longitude, created_at FROM locations ORDER BY id DESC LIMIT 1");
$location = $stmt->fetch();

if ($location) {
    echo json_encode(["status" => "success", "data" => $location]);
} else {
    echo json_encode(["status" => "error", "message" => "No locations found"]);
}