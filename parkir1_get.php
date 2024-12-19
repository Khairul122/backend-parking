<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS and JSON headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database connection
require_once 'database.php';

class LatestSensorDataRetriever {
    private $db;
    private $connection;

    public function __construct() {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function getLatestSensorData($sensor_id) {
        // Query to get the latest single record for the specific sensor
        $query = "SELECT id, sensor_id, status_parkir, status, created_at 
                  FROM parkir 
                  WHERE sensor_id = ? 
                  ORDER BY created_at DESC 
                  LIMIT 1";
        
        // Prepare and execute the statement
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $sensor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a record exists
        if ($result->num_rows === 0) {
            $this->sendResponse(404, false, "Tidak ada data untuk sensor ID: " . $sensor_id);
            $stmt->close();
            return;
        }

        // Fetch the latest record
        $latestData = $result->fetch_assoc();
        $stmt->close();

        // Prepare and send response with only the latest record
        $this->sendResponse(200, true, "Data berhasil diambil", $latestData);
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];

        // Only allow GET requests
        if ($method !== 'GET') {
            $this->sendResponse(405, false, "Metode tidak diizinkan.");
            exit;
        }

        // Check if sensor_id is provided
        if (!isset($_GET['sensor_id'])) {
            $this->sendResponse(400, false, "ID sensor diperlukan.");
            exit;
        }

        // Retrieve and sanitize sensor_id
        $sensor_id = filter_input(INPUT_GET, 'sensor_id', FILTER_SANITIZE_STRING);

        // Retrieve latest sensor data
        $this->getLatestSensorData($sensor_id);
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
    $handler = new LatestSensorDataRetriever();
    $handler->handleRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Kesalahan Server Internal: ' . $e->getMessage()
    ]);
}
?>