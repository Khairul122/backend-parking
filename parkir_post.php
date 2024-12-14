<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Set timezone
date_default_timezone_set('Asia/Jakarta');

require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Set timezone MySQL
$conn->query("SET time_zone = '+07:00'");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    try {
        // Ambil dan decode JSON input
        $jsonInput = file_get_contents('php://input');
        $input = json_decode($jsonInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON format');
        }

        // Validasi input JSON
        if (!isset($input['plat']) || !isset($input['biaya']) || !isset($input['status'])) {
            throw new Exception('Missing required fields');
        }

        // Sanitasi input
        $plat = $conn->real_escape_string($input['plat']);
        $biaya = intval($input['biaya']);
        $status = $conn->real_escape_string($input['status']);
        
        // Generate waktu otomatis
        $waktu = date('Y-m-d H:i:s');

        // Cek apakah plat sudah ada
        $queryCheck = "SELECT * FROM parkir WHERE plat = '$plat'";
        $result = $db->query($queryCheck);

        if (!$result) {
            throw new Exception($conn->error);
        }

        if ($result->num_rows > 0) {
            // Update data
            $queryUpdate = "UPDATE parkir SET biaya = $biaya, waktu = '$waktu', status = '$status' WHERE plat = '$plat'";
            if (!$db->query($queryUpdate)) {
                throw new Exception($conn->error);
            }
            echo json_encode([
                'status' => 'success', 
                'message' => 'Data updated successfully',
                'data' => [
                    'plat' => $plat,
                    'biaya' => $biaya,
                    'waktu' => $waktu,
                    'status' => $status
                ]
            ]);
        } else {
            // Insert data baru
            $queryInsert = "INSERT INTO parkir (plat, biaya, waktu, status) VALUES ('$plat', $biaya, '$waktu', '$status')";
            if (!$db->query($queryInsert)) {
                throw new Exception($conn->error);
            }
            echo json_encode([
                'status' => 'success', 
                'message' => 'Data inserted successfully',
                'data' => [
                    'plat' => $plat,
                    'biaya' => $biaya,
                    'waktu' => $waktu,
                    'status' => $status
                ]
            ]);
        }

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    } finally {
        $db->close();
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>