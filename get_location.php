<?php
header('Content-Type: application/json');

// Endpoint API dan token untuk autentikasi
$apiUrl = "http://103.115.29.43:81/wapi/organization/getOrganizationTree2";
$token = "eyJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3Mjg5NzQ3NzAsInN1YiI6ImFkbWluIiwibG9naW5Vc2VyIjoie1wiaWRcIjpcIjE4MTc4MzgyNDM5NzkxOTg0NjRcIixcImFjY291bnRcIjpcIlBUX1NPR19JbmRvbmVzaWFcIixcIm5hbWVcIjpcIlNPRzMyMFwiLFwidHlwZVwiOlwiQkxPQ1wiLFwib2lkXCI6XCIxMlwiLFwicHdkRXhwaXJlZFwiOmZhbHNlfSJ9.t80GmAB8xLlHpGzr16k6VaZz08dJS1ReWmXlsc35OZo";

// Set up cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);

// Execute request and handle error
$response = curl_exec($ch);
if(curl_errno($ch)) {
    echo json_encode(['error' => 'Error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Convert response to JSON
$data = json_decode($response, true);

// Adjust according to actual data structure
if (isset($data['latitude']) && isset($data['longitude'])) {
    echo json_encode([
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude']
    ]);
} else {
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
?>
