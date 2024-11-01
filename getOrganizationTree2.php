<?php
// Mengatur header respons sebagai JSON
header('Content-Type: application/json');

// URL API dan token autentikasi
$apiUrl = "http://103.115.29.43:81/wapi/organization/getOrganizationTree2";
$token = "eyJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3Mjg5NzQ3NzAsInN1YiI6ImFkbWluIiwibG9naW5Vc2VyIjoie1wiaWRcIjpcIjE4MTc4MzgyNDM5NzkxOTg0NjRcIixcImFjY291bnRcIjpcIlBUX1NPR19JbmRvbmVzaWFcIixcIm5hbWVcIjpcIlNPRzMyMFwiLFwidHlwZVwiOlwiQkxPQ1wiLFwib2lkXCI6XCIxMlwiLFwicHdkRXhwaXJlZFwiOmZhbHNlfSJ9.t80GmAB8xLlHpGzr16k6VaZz08dJS1ReWmXlsc35OZo";

// Mengatur cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'token: ' . $token, // Menyertakan token dalam header kustom
    'Content-Type: application/json'
]);

// Menjalankan permintaan dan mendapatkan respons
$response = curl_exec($ch);

// Memeriksa apakah ada kesalahan saat menjalankan cURL
if (curl_errno($ch)) {
    echo json_encode([
        "status" => 500,
        "message" => "Error during cURL request: " . curl_error($ch)
    ]);
} else {
    // Menutup sesi cURL
    curl_close($ch);

    // Menampilkan respons langsung
    echo $response;
}
?>
