<?php
// Mengatur header respons sebagai HTML
header('Content-Type: text/html; charset=UTF-8');

// Memeriksa apakah parameter 'uids' ada dalam query string
if (!isset($_GET['uids'])) {
    echo json_encode([
        "status" => 400,
        "message" => "Invalid input, 'uids' is required."
    ]);
    exit;
}

// Menguraikan 'uids' dari query string dan memastikan ini adalah array
$uids = json_decode($_GET['uids'], true);

if (!is_array($uids)) {
    echo json_encode([
        "status" => 400,
        "message" => "Invalid input, 'uids' must be an array."
    ]);
    exit;
}

// URL API dan token autentikasi
$apiUrl = "http://103.115.29.43:81/wapi/location/getLatestCoords";
$token = "eyJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3Mjg5NzQ3NzAsInN1YiI6ImFkbWluIiwibG9naW5Vc2VyIjoie1wiaWRcIjpcIjE4MTc4MzgyNDM5NzkxOTg0NjRcIixcImFjY291bnRcIjpcIlBUX1NPR19JbmRvbmVzaWFcIixcIm5hbWVcIjpcIlNPRzMyMFwiLFwidHlwZVwiOlwiQkxPQ1wiLFwib2lkXCI6XCIxMlwiLFwicHdkRXhwaXJlZFwiOmZhbHNlfSJ9.t80GmAB8xLlHpGzr16k6VaZz08dJS1ReWmXlsc35OZo";

// Mengatur cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'token: ' . $token, // Menyertakan token dalam header kustom
    'Content-Type: application/json'
]);

// Mengonversi data menjadi format JSON untuk dikirim
$requestBody = json_encode([
    "uids" => $uids
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

// Menjalankan permintaan dan mendapatkan respons
$response = curl_exec($ch);

// Memeriksa apakah ada kesalahan saat menjalankan cURL
if (curl_errno($ch)) {
    echo json_encode([
        "status" => 500,
        "message" => "Error during cURL request: " . curl_error($ch)
    ]);
    exit;
} else {
    // Menutup sesi cURL
    curl_close($ch);

    // Menguraikan respons
    $data = json_decode($response, true);

    if ($data['status'] == 200 && !empty($data['data'])) {
        // Menghasilkan HTML untuk menampilkan peta
        echo '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Peta Koordinat</title>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8YJE3aon6WyYJjNMp3GzTh5EUHPbcKC0"></script>
            <style>
                #map {
                    height: 500px;
                    width: 100%;
                }
            </style>
        </head>
        <body>
            <h1>Peta Koordinat</h1>
            <div id="map"></div>
            <script>
                function initMap() {
                    // Mengambil koordinat pusat dari data pertama
                    const center = { lat: ' . $data['data'][0]['y'] . ', lng: ' . $data['data'][0]['x'] . ' };
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 12,
                        center: center,
                    });

                    // Menandai lokasi berdasarkan data
                    ';
        
        // Loop melalui data untuk menandai setiap lokasi
        foreach ($data['data'] as $location) {
            echo 'new google.maps.Marker({
                position: { lat: ' . $location['y'] . ', lng: ' . $location['x'] . ' },
                map: map,
                title: "' . htmlspecialchars($location['userName']) . '",
                animation: google.maps.Animation.DROP,
            });';
        }

        echo '
                }
                window.onload = initMap;
            </script>
        </body>
        </html>
        ';
    } else {
        // Jika status bukan 200 atau tidak ada data
        echo json_encode($data);
    }
}
?>
