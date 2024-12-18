<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'database.php';
$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $conn = $db->getConnection();
    $data = file_get_contents("php://input");
    $json = json_decode($data, true);

    if (isset($json['Ultrasonik'][0]['id']) && isset($json['Ultrasonik'][0]['value'])) {
        $id_parkir = $json['Ultrasonik'][0]['id'];
        $value = $json['Ultrasonik'][0]['value'];
        $status = $value == 1 ? "Parkir" : "Tidak Parkir";
        $plat_nomor = "BA 1010 AB";
        
        if ($value == 1) {
            // Jika value = 1, simpan waktu mulai
            $sql = "INSERT INTO parkir (id_parkir, status, plat_nomor, waktu_mulai) 
                   VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $id_parkir, $status, $plat_nomor);
        } else {
            // Jika value = 0, update waktu selesai, hitung durasi dan biaya
            $sql = "UPDATE parkir 
                   SET status = ?, 
                       waktu_selesai = CURRENT_TIMESTAMP,
                       durasi = TIMESTAMPDIFF(SECOND, waktu_mulai, CURRENT_TIMESTAMP),
                       biaya = CASE 
                           WHEN TIMESTAMPDIFF(SECOND, waktu_mulai, CURRENT_TIMESTAMP) <= 60 THEN 2000
                           WHEN TIMESTAMPDIFF(SECOND, waktu_mulai, CURRENT_TIMESTAMP) <= 120 THEN 4000
                           WHEN TIMESTAMPDIFF(SECOND, waktu_mulai, CURRENT_TIMESTAMP) <= 180 THEN 6000
                           WHEN TIMESTAMPDIFF(SECOND, waktu_mulai, CURRENT_TIMESTAMP) <= 240 THEN 8000
                           WHEN TIMESTAMPDIFF(SECOND, waktu_mulai, CURRENT_TIMESTAMP) <= 300 THEN 10000
                           ELSE 12000
                       END
                   WHERE id_parkir = ? 
                   AND waktu_selesai IS NULL
                   ORDER BY waktu_mulai DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $status, $id_parkir);
        }

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["message" => "Data berhasil disimpan"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Gagal menyimpan data"]);
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Data tidak valid. Pastikan ID dan value tersedia."]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Metode tidak diizinkan"]);
}
?>