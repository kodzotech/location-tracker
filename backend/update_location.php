<?php
require_once 'config.php';

// Simple shared secret token to secure your endpoint from public spam
$expected_token = "jessica_tracker";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Robust header extraction that works on all servers (including Wasmer)
    $token = '';
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $token = trim(str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']));
    } elseif (function_exists('getallheaders')) {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = trim(str_replace('Bearer ', '', $headers['Authorization']));
        }
    }

    if ($token !== $expected_token) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Unauthorized"]);
        exit;
    }

    $latitude  = $_POST['latitude']  ?? null;
    $longitude = $_POST['longitude'] ?? null;
    $device_id = $_POST['device_id'] ?? 'sister_phone';

    if ($latitude && $longitude) {
        $stmt = $pdo->prepare("INSERT INTO locations (device_id, latitude, longitude, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$device_id, $latitude, $longitude]);

        echo json_encode(["status" => "success", "message" => "Location logged"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Missing coordinates"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}