<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS headers specifically configured for PUT requests
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include database connection
require_once 'database.php';

class ParkingUpdateHandler {
    private $db;
    private $connection;

    public function __construct() {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function handleRequest() {
        // Verify the request method
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            $this->sendResponse(405, false, "Method not allowed. Only PUT requests are accepted.");
            exit;
        }

        // Read the raw input data
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        // Validate the required input fields
        if (!$this->validateInput($data)) {
            $this->sendResponse(400, false, "Invalid input. Required fields: sensor_id, durasi, biaya");
            exit;
        }

        // Update the parking record
        $this->updateParkingRecord($data);
    }

    private function validateInput($data) {
        return isset($data['sensor_id']) && 
               isset($data['durasi']) && 
               isset($data['biaya']) && 
               is_numeric($data['durasi']) && 
               is_numeric($data['biaya']);
    }

    private function updateParkingRecord($data) {
        // Get the latest parking record for the sensor
        $query = "SELECT id FROM parkir 
                 WHERE sensor_id = ? AND status = 'Selesai' 
                 ORDER BY created_at DESC LIMIT 1";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $data['sensor_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Update the existing record with duration and cost
            $updateQuery = "UPDATE parkir 
                          SET durasi = ?, biaya = ?, updated_at = NOW() 
                          WHERE id = ?";
            
            $updateStmt = $this->connection->prepare($updateQuery);
            $updateStmt->bind_param("iii", 
                $data['durasi'],
                $data['biaya'],
                $row['id']
            );

            if ($updateStmt->execute()) {
                $this->sendResponse(200, true, "Parking record updated successfully", [
                    'sensor_id' => $data['sensor_id'],
                    'durasi' => $data['durasi'],
                    'biaya' => $data['biaya']
                ]);
            } else {
                $this->sendResponse(500, false, "Failed to update parking record: " . $updateStmt->error);
            }
            $updateStmt->close();
        } else {
            $this->sendResponse(404, false, "No completed parking record found for the specified sensor");
        }
        $stmt->close();
    }

    private function sendResponse($httpCode, $success, $message, $data = null) {
        http_response_code($httpCode);
        $response = [
            'status' => $success,
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
    $handler = new ParkingUpdateHandler();
    $handler->handleRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'message' => 'Internal Server Error: ' . $e->getMessage()
    ]);
}
?>