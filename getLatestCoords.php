<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Koordinat</title>
    <style>
                body {
            font-family: 'Roboto', sans-serif;
            margin: 20px;
        }
        #map {
            height: 500px;
            width: 100%;
        }
        #coordinateBox {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        #openMapButton {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #4285F4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #openMapButton:hover {
            background-color: #357AE8;
        }
        .updatedCoordinates {
            color: green; /* Warna hijau untuk data terbaru */
            opacity: 1;
            transition: opacity 0.5s; /* Animasi transisi */
        }
        .loading {
            display: none; /* Tersembunyi secara default */
            color: blue; /* Warna untuk animasi loading */
            font-weight: bold;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiTyX1WHWUf44vA7RE2N5fXf81OwfhUdE&callback=initMap" async defer loading="lazy"></script>
</head>
<body>
    <h1>Peta Koordinat</h1>
    <div id="map"></div>
    <div id="coordinateBox">
        <p id="coordinateDisplay">Koordinat: </p>
        <button id="openMapButton" style="display:none;">Buka di Google Maps</button>
        <div id="updatedCoordinates" class="updatedCoordinates" style="margin-top: 10px; font-weight: bold;"></div>
        <div id="loading" class="loading">Memuat data terbaru...</div> <!-- Elemen loading -->
    </div>

    <script>
        const uids = JSON.parse(new URLSearchParams(window.location.search).get('uids'));
        const apiUrl = "http://103.115.29.43:81/wapi/location/getLatestCoords";
        const token = "eyJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3Mjg5NzQ3NzAsInN1YiI6ImFkbWluIiwibG9naW5Vc2VyIjoie1wiaWRcIjpcIjE4MTc4MzgyNDM5NzkxOTg0NjRcIixcImFjY291bnRcIjpcIlBUX1NPR19JbmRvbmVzaWFcIixcIm5hbWVcIjpcIlNPRzMyMFwiLFwidHlwZVwiOlwiQkxPQ1wiLFwib2lkXCI6XCIxMlwiLFwicHdkRXhwaXJlZFwiOmZhbHNlfSJ9.t80GmAB8xLlHpGzr16k6VaZz08dJS1ReWmXlsc35OZo";

        let mapData = [];
        let markers = [];
        let map;

        // Fungsi untuk mendapatkan data dari API
        async function getDataFromApi(uids) {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'token': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ uids: uids })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.status !== 200 || !data.data) {
                throw new Error(data.message || 'Error retrieving data');
            }

            return data.data;
        }

        // Fungsi untuk inisialisasi peta
        function initMap() {
            if (mapData.length === 0) {
                console.warn("Tidak ada data untuk ditampilkan pada peta.");
                return;
            }

            const center = { lat: mapData[0].x, lng: mapData[0].y };
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: center,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            // Membuat marker awal
            mapData.forEach(location => {
                const marker = new google.maps.Marker({
                    position: { lat: location.x, lng: location.y },
                    map: map,
                    title: location.userName,
                    animation: google.maps.Animation.DROP
                });
                markers.push(marker);
                displayCoordinates(location);
            });

            // Memperbarui data setiap 15 detik
            setInterval(async () => {
                console.log("Memperbarui data...");
                document.getElementById('loading').style.display = 'block'; // Tampilkan loading
                try {
                    const updatedData = await getDataFromApi(uids);
                    updateMarkers(updatedData);
                    showUpdatedCoordinates();
                } catch (error) {
                    console.warn(error);
                } finally {
                    document.getElementById('loading').style.display = 'none'; // Sembunyikan loading
                }
            }, 15000);
        }

        // Fungsi untuk memperbarui marker
        function updateMarkers(updatedData) {
            updatedData.forEach((location, index) => {
                if (markers[index]) {
                    // Update posisi marker yang sudah ada
                    markers[index].setPosition({ lat: location.x, lng: location.y });
                    displayCoordinates(location);
                } else {
                    // Tambah marker baru jika tidak ada marker sebelumnya
                    const marker = new google.maps.Marker({
                        position: { lat: location.x, lng: location.y },
                        map: map,
                        title: location.userName,
                        animation: google.maps.Animation.DROP
                    });
                    markers.push(marker);
                }
                updateLatestCoordinates(location);
            });
        }

        function updateLatestCoordinates(location) {
            const updatedCoordinates = document.getElementById('updatedCoordinates');
            updatedCoordinates.innerHTML = `Data Terbaru: Latitude ${location.x}, Longitude ${location.y}`;
        }

        function displayCoordinates(location) {
            const coordinateDisplay = document.getElementById('coordinateDisplay');
            const openMapButton = document.getElementById('openMapButton');

            coordinateDisplay.innerHTML = `Koordinat: Latitude ${location.x}, Longitude ${location.y}`;
            openMapButton.onclick = function() {
                window.open(`https://www.google.com/maps?q=${location.x},${location.y}`, '_blank');
            };
            openMapButton.style.display = 'inline';
        }

        function showUpdatedCoordinates() {
            const updatedCoordinates = document.getElementById('updatedCoordinates');
            updatedCoordinates.style.opacity = '1'; // Tampilkan pesan
            updatedCoordinates.innerHTML = 'Data diperbarui!';

            // Sembunyikan setelah 3 detik
            setTimeout(() => {
                updatedCoordinates.style.opacity = '0'; // Sembunyikan pesan dengan efek transisi
            }, 3000);
        }

        // Ambil data awal
        getDataFromApi(uids)
            .then(data => {
                mapData = data;
                initMap();
            })
            .catch(error => {
                console.error("Error initializing map:", error);
            });
    </script>

</body>
</html>
