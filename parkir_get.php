<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'database.php';
$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $conn = $db->getConnection();
    
    $sql = "SELECT * FROM parkir ORDER BY waktu_mulai DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $parkir_array = array();
        
        while($row = $result->fetch_assoc()) {
            $parkir_item = array(
                "id" => $row['id'],
                "id_parkir" => $row['id_parkir'],
                "status" => $row['status'],
                "plat_nomor" => $row['plat_nomor'],
                "waktu_mulai" => $row['waktu_mulai'],
                "waktu_selesai" => $row['waktu_selesai'],
                "durasi" => $row['durasi'],
                "biaya" => $row['biaya']
            );
            array_push($parkir_array, $parkir_item);
        }
        
        http_response_code(200);
        echo json_encode([
            "status" => true,
            "message" => "Data ditemukan",
            "data" => $parkir_array
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "status" => false,
            "message" => "Tidak ada data parkir",
            "data" => []
        ]);
    }
    
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode([
        "status" => false,
        "message" => "Metode tidak diizinkan"
    ]);
}
?>