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

    $response = ["message" => "Memproses data", "details" => []];
    $success = true;

    // Loop through each ultrasonic sensor data
    foreach ($json['Ultrasonik'] as $sensor) {
        if (isset($sensor['id']) && isset($sensor['value'])) {
            $id_parkir = $sensor['id'];
            $value = $sensor['value'];
            $status = $value == 1 ? "Parkir" : "Tidak Parkir";
            
            // Set plat nomor berdasarkan ID sensor
            $plat_nomor = ($id_parkir == "ULTRASONIC_01") ? "BA 1010 AB" : "BA 2020 CD";
            
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
                $response["details"][] = [
                    "id_parkir" => $id_parkir,
                    "status" => "sukses",
                    "message" => "Data berhasil disimpan"
                ];
            } else {
                $success = false;
                $response["details"][] = [
                    "id_parkir" => $id_parkir,
                    "status" => "gagal",
                    "message" => "Gagal menyimpan data"
                ];
            }

            $stmt->close();
        } else {
            $success = false;
            $response["details"][] = [
                "status" => "error",
                "message" => "Data tidak valid. Pastikan ID dan value tersedia."
            ];
        }
    }

    if ($success) {
        http_response_code(200);
        $response["status"] = "success";
    } else {
        http_response_code(500);
        $response["status"] = "error";
    }
    
    echo json_encode($response);
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Metode tidak diizinkan"
    ]);
}
?>