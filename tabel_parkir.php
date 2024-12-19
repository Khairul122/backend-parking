<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'database.php'; 

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

// Helper function for duration formatting with additional validation
function formatDuration($seconds) {
    // Return early if seconds is not numeric or is 0/null
    if (!is_numeric($seconds) || $seconds <= 0) return "00:00:00";
    
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
}

// Helper function for cost formatting with improved validation
function formatCost($cost) {
    // Return early if cost is not numeric or is 0/null
    if (!is_numeric($cost) || $cost <= 0) return 'Rp 0';
    
    return 'Rp ' . number_format($cost, 0, ',', '.');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Validate sensor_id parameter
        if (!isset($_GET['sensor_id'])) {
            throw new Exception('Parameter sensor_id diperlukan');
        }

        $sensor_id = $conn->real_escape_string($_GET['sensor_id']);
        
        // Validate sensor_id values
        $valid_sensors = ['ULTRASONIC_01', 'ULTRASONIC_02'];
        if (!in_array($sensor_id, $valid_sensors)) {
            throw new Exception('Sensor ID tidak valid');
        }

        // Enhanced SQL query to filter out records with 0 duration or cost
        // We use COALESCE to handle NULL values and ensure proper comparison
        $sql = "SELECT 
                    id,
                    sensor_id,
                    created_at as waktu_masuk,
                    durasi,
                    biaya,
                    status 
                FROM parkir 
                WHERE sensor_id = ? 
                AND LOWER(status) = 'selesai'
                AND COALESCE(durasi, 0) > 0 
                AND COALESCE(biaya, 0) > 0
                ORDER BY created_at DESC";

        // Prepare and execute the query with proper error handling
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $conn->error);
        }

        $stmt->bind_param("s", $sensor_id);
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }
        
        $result = $stmt->get_result();

        $parkingHistory = array();
        $counter = 1;

        // Process results with enhanced validation
        while ($row = $result->fetch_assoc()) {
            // Additional validation to ensure data integrity
            if ($row['durasi'] > 0 && $row['biaya'] > 0) {
                $parkingHistory[] = array(
                    'no' => $counter++,
                    'tanggal' => date('Y-m-d H:i:s', strtotime($row['waktu_masuk'])),
                    'lahan_parkir' => $row['sensor_id'] === 'ULTRASONIC_01' ? 'Parkir 1' : 'Parkir 2',
                    'durasi' => formatDuration($row['durasi']),
                    'biaya' => formatCost($row['biaya'])
                );
            }
        }

        // Check if we found any valid records
        $responseMessage = count($parkingHistory) > 0 
            ? 'Data berhasil diambil' 
            : 'Tidak ada data parkir dengan durasi dan biaya valid';

        // Send response with appropriate message
        echo json_encode(array(
            'status' => true,
            'message' => $responseMessage,
            'data' => $parkingHistory
        ), JSON_PRETTY_PRINT);

        $stmt->close();

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(array(
            'status' => false,
            'message' => $e->getMessage()
        ));
    }
} else {
    http_response_code(405);
    echo json_encode(array(
        'status' => false,
        'message' => 'Metode tidak diizinkan'
    ));
}

$database->close();
?>