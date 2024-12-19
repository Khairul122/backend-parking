<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS and JSON headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database connection
require_once 'database.php';

class ParkingSensorHandler {
    private $db;
    private $connection;

    public function __construct() {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];

        // Only allow POST requests
        if ($method !== 'POST') {
            $this->sendResponse(405, false, "Method not allowed.");
            exit;
        }

        // Read raw POST data
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        // Validate input
        if (empty($data) || !isset($data['Ultrasonik'])) {
            $this->sendResponse(400, false, "Invalid input or no data provided.", ['raw_input' => $rawData]);
            exit;
        }

        // Handle both array and object formats
        $sensor = is_array($data['Ultrasonik']) 
            ? (isset($data['Ultrasonik'][0]) ? $data['Ultrasonik'][0] : $data['Ultrasonik'])
            : $data['Ultrasonik'];

        // Validate sensor data
        if (!isset($sensor['id']) || !isset($sensor['value'])) {
            $this->sendResponse(400, false, "Incomplete sensor data.", ['sensor_data' => $sensor]);
            exit;
        }

        // Extract sensor details
        $id = $sensor['id'];
        $value = $sensor['value'];

        // Determine parking status
        $status_parkir = ($value == 1) ? "Parkir" : "Tidak Parkir";
        $status = ($value == 1) ? "Proses" : "Selesai";

        // Check last recorded status
        $last_status = $this->getLastStatus($id);

        // Only insert if status has changed
        if ($this->hasStatusChanged($last_status, $status_parkir, $status)) {
            $this->insertParkingStatus($id, $status_parkir, $status);
        } else {
            $this->sendResponse(200, true, "No changes detected, no data inserted.", [
                'id' => $id,
                'last_status_parkir' => $last_status['status_parkir'] ?? null,
                'last_status' => $last_status['status'] ?? null
            ]);
        }
    }

    private function getLastStatus($sensor_id) {
        $query = "SELECT status_parkir, status FROM parkir WHERE sensor_id = ? ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $sensor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $last_status = $result->fetch_assoc();
        $stmt->close();
        return $last_status;
    }

    private function hasStatusChanged($last_status, $new_status_parkir, $new_status) {
        // If no previous status exists, consider it changed
        if ($last_status === null) {
            return true;
        }

        // Check if either status has changed
        return $last_status['status_parkir'] !== $new_status_parkir 
            || $last_status['status'] !== $new_status;
    }

    private function insertParkingStatus($id, $status_parkir, $status) {
        $query = "INSERT INTO parkir (sensor_id, status_parkir, status, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sss", $id, $status_parkir, $status);

        if ($stmt->execute()) {
            $this->sendResponse(200, true, "Data successfully inserted.", [
                'id' => $id,
                'status_parkir' => $status_parkir,
                'status' => $status
            ]);
        } else {
            $this->sendResponse(500, false, "Failed to insert data: " . $stmt->error);
        }
        $stmt->close();
    }

    private function sendResponse($httpCode, $success, $message, $data = null) {
        http_response_code($httpCode);
        $response = [
            'success' => $success,
            'message' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        echo json_encode($response);
    }
}

// Execute the script
try {
    $handler = new ParkingSensorHandler();
    $handler->handleRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal Server Error: ' . $e->getMessage()
    ]);
}
?>