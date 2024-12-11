<?php
// Mengatur header untuk mengizinkan akses dari mana saja dan menerima JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once 'database.php'; // Pastikan Anda memiliki file database.php untuk koneksi database
$db = new Database();

// Mengambil semua data dari tabel servo
$query = "SELECT * FROM servo";
$result = $db->query($query);

// Jika data ditemukan
if ($result->num_rows > 0) {
    $servo = [];
    while ($row = $result->fetch_assoc()) {
        $servo[] = $row;
    }
    // Mengembalikan data dalam format JSON
    echo json_encode([
        "status" => "success",
        "data" => $servo
    ]);
} else {
    // Jika tidak ada data ditemukan
    echo json_encode([
        "status" => "success",
        "data" => []
    ]);
}

// Tutup koneksi database
$db->close();
?>
