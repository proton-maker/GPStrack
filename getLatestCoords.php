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
        const _0x36d215=_0x593f;function _0x2cc7(){const _0x2fc7e4=['4MzgyNDM5N','ie1wiaWRcI','lHpGzr16k6','hbHNlfSJ9.','zaWFcIixcI','CIxMlwiLFw','cIlNPRzMyM','14Wlkiso','wZVwiOlwiQ','uIiwibG9na','.eyJpYXQiO','2UYskGV','99hcLddM','iI6ImFkbWl','cIlBUX1NPR','zkxOTg0NjR','cIixcImFjY','jpcIjE4MTc','t80GmAB8xL','19JbmRvbmV','icHdkRXhwa','JIUzI1NiJ9','9368OxFGvT','OZo','106424hBGrmr','VaZz08dJS1','FwiLFwidHl','jE3Mjg5NzQ','W5Vc2VyIjo','eyJhbGciOi','ib2lkXCI6X','493530fnViIL','3811104EjDGTc','4163675sARzQB','3NzAsInN1Y','XJlZFwiOmZ','ReWmXlsc35','kxPQ1wiLFw','291bnRcIjp','169070VnBQaG','m5hbWVcIjp','2316975tVIiOs'];_0x2cc7=function(){return _0x2fc7e4;};return _0x2cc7();}(function(_0x30673e,_0xb1c90a){const _0x101895=_0x593f,_0x4c81e7=_0x30673e();while(!![]){try{const _0x3ff9a7=parseInt(_0x101895(0xae))/(-0x1d09+-0x1*0x25a9+0x42b3)*(parseInt(_0x101895(0xb9))/(0x188a+-0x1e81+0x5f9))+parseInt(_0x101895(0xa2))/(0x15fb+0x23d*0x1+-0x1*0x1835)+-parseInt(_0x101895(0xbb))/(0x1a3d*0x1+0x164+-0x1b9d)+-parseInt(_0x101895(0xc4))/(-0x25c7*-0x1+-0xf9*0xb+-0x1b0f)+-parseInt(_0x101895(0xc2))/(-0x14ec+0x59+0x1499)*(parseInt(_0x101895(0xaa))/(-0x1*-0x14d3+0x1*-0x1b89+0x6bd*0x1))+parseInt(_0x101895(0xc3))/(-0x84f*0x2+0x3*-0xad+0x1*0x12ad)+parseInt(_0x101895(0xaf))/(-0xb06*-0x1+0x2f9+-0xdf6*0x1)*(parseInt(_0x101895(0xa0))/(0xeae*-0x1+-0x1*-0x1924+-0xa6c));if(_0x3ff9a7===_0xb1c90a)break;else _0x4c81e7['push'](_0x4c81e7['shift']());}catch(_0x5c01c2){_0x4c81e7['push'](_0x4c81e7['shift']());}}}(_0x2cc7,-0x2*0x325ad+-0x84fa3+0x15046c));function _0x593f(_0x5ce442,_0x193197){const _0x5633c1=_0x2cc7();return _0x593f=function(_0x25165e,_0x21efc2){_0x25165e=_0x25165e-(-0x2293+-0x1*-0x1c8f+0x6a0);let _0x303850=_0x5633c1[_0x25165e];return _0x303850;},_0x593f(_0x5ce442,_0x193197);}const token=_0x36d215(0xc0)+_0x36d215(0xb8)+_0x36d215(0xad)+_0x36d215(0xbe)+_0x36d215(0xc5)+_0x36d215(0xb0)+_0x36d215(0xac)+_0x36d215(0xbf)+_0x36d215(0xa4)+_0x36d215(0xb4)+_0x36d215(0xa3)+_0x36d215(0xb2)+_0x36d215(0xb3)+_0x36d215(0x9f)+_0x36d215(0xb1)+_0x36d215(0xb6)+_0x36d215(0xa7)+_0x36d215(0xa1)+_0x36d215(0xa9)+_0x36d215(0xbd)+_0x36d215(0xab)+_0x36d215(0x9e)+_0x36d215(0xc1)+_0x36d215(0xa8)+_0x36d215(0xb7)+_0x36d215(0x9c)+_0x36d215(0xa6)+_0x36d215(0xb5)+_0x36d215(0xa5)+_0x36d215(0xbc)+_0x36d215(0x9d)+_0x36d215(0xba);

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
        
    // Memanggil Google Maps API secara dinamis
    function _0xc519(){const _0x283db8=['ent','5fXf81Owfh','script','pis.com/ma','async','src','AiTyX1WHWU','ps/api/js?','5813048wsfvsg','2Djxsem','20MpMmrt','16860kUpYOW','https://ma','createElem','88008eEWpeY','6153260tVHALG','f44vA7RE2N','key=AIzaSy','12XbOWai','appendChil','1071203uOlBIF','head','150095abCsvU','6678baxOiL','2101GXXDnj','717720LSczdm','defer','ps.googlea','UdE&callba','ck=initMap'];_0xc519=function(){return _0x283db8;};return _0xc519();}const _0x1728e2=_0x56e5;(function(_0x23fe7b,_0x3c4c67){const _0x35dffc=_0x56e5,_0x2e4ee1=_0x23fe7b();while(!![]){try{const _0x5b2fa6=parseInt(_0x35dffc(0x1b7))/(0x1e*0x58+0xb*-0x2f5+0x1638)*(parseInt(_0x35dffc(0x1c8))/(0x1046+0x225+0x1*-0x1269))+parseInt(_0x35dffc(0x1ba))/(0x2b*0xb3+-0xc4*0x12+-0x1046)*(parseInt(_0x35dffc(0x1c9))/(-0x1aea+0x220a*0x1+-0x71c))+-parseInt(_0x35dffc(0x1b0))/(-0xfc0+-0x4f*0x27+0x1bce)+-parseInt(_0x35dffc(0x1b3))/(0x260d+0x2264+-0x486b)*(parseInt(_0x35dffc(0x1b5))/(0x268f+-0x224f*-0x1+0x283*-0x1d))+parseInt(_0x35dffc(0x1c7))/(0x1db2+0x3ed+-0x2197)+parseInt(_0x35dffc(0x1b8))/(0x1a*-0x3e+-0x1a8d+-0x7a*-0x45)*(-parseInt(_0x35dffc(0x1ac))/(0xa77+-0x1ae9+0x107c))+-parseInt(_0x35dffc(0x1b9))/(0x1*0x1bc1+-0xd+-0x1ba9)*(-parseInt(_0x35dffc(0x1af))/(0x2257+-0xd80+-0x1*0x14cb));if(_0x5b2fa6===_0x3c4c67)break;else _0x2e4ee1['push'](_0x2e4ee1['shift']());}catch(_0x5f4ba4){_0x2e4ee1['push'](_0x2e4ee1['shift']());}}}(_0xc519,0x11081f+-0x571ab+-0x8e*0x205));function _0x56e5(_0x448aee,_0x5bedf1){const _0x171410=_0xc519();return _0x56e5=function(_0x3e1912,_0x34e78d){_0x3e1912=_0x3e1912-(0x1495+0xf3d*-0x1+0x2*-0x1d6);let _0x59421c=_0x171410[_0x3e1912];return _0x59421c;},_0x56e5(_0x448aee,_0x5bedf1);}const script=document[_0x1728e2(0x1ae)+_0x1728e2(0x1bf)](_0x1728e2(0x1c1));script[_0x1728e2(0x1c4)]=_0x1728e2(0x1ad)+_0x1728e2(0x1bc)+_0x1728e2(0x1c2)+_0x1728e2(0x1c6)+_0x1728e2(0x1b2)+_0x1728e2(0x1c5)+_0x1728e2(0x1b1)+_0x1728e2(0x1c0)+_0x1728e2(0x1bd)+_0x1728e2(0x1be),script[_0x1728e2(0x1c3)]=!![],script[_0x1728e2(0x1bb)]=!![],document[_0x1728e2(0x1b6)][_0x1728e2(0x1b4)+'d'](script);
    </script>

</body>
</html>
