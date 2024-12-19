<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'database.php'; // Pastikan file database.php sudah ada
$db = new Database();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    // Ambil data input dari body (JSON)
    $input = json_decode(file_get_contents('php://input'), true);

    // Validasi input
    if (!isset($input['palang']) || !isset($input['value'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
        exit;
    }

    $palang = $input['palang'];
    $value = intval($input['value']);

    // Cek apakah palang sudah ada di database
    $queryCheck = "SELECT * FROM servo WHERE palang = '$palang'";
    $result = $db->query($queryCheck);

    if ($result->num_rows > 0) {
        // Jika data ditemukan, perbarui data lama
        $queryUpdate = "UPDATE servo SET value = $value WHERE palang = '$palang'";
        if ($db->query($queryUpdate)) {
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data.']);
        }
    } else {
        // Jika data tidak ditemukan, masukkan data baru
        $queryInsert = "INSERT INTO servo (palang, value) VALUES ('$palang', $value)";
        if ($db->query($queryInsert)) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
        }
    }

    $db->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
