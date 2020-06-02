<script src="https://api-maps.yandex.ru/2.1/?apikey=84314dca-6af9-430d-b2e5-1faac3126fa8&lang=ru_RU" type="text/javascript"></script>
<script src="main.js"></script>

<?php
$mysqli = new mysqli("localhost", "root", "123", "bd");
$result = $mysqli->query("SELECT * FROM precinct"); ?>
<script>
    const placemarks = [<?php while ($row = $result->fetch_assoc()) {
                            $lat = $row["lat"];
                            $lon = $row["lon"];
                            $id = $row["id"];
                            $name = $row["name"];
                            $address = "г. " . $row["town"] . ", ул. " . $row["street"] . ", д. " . $row["house"];
                            echo "{ lat: $lat, lon: $lon, hintContent: '№ $id', balloonContent: '$name. Адрес: $address' },";
                        } ?>];
    $(document).ready(function() {
        mapPage(placemarks);
    })
</script>



<!-- контейнер для карты -->
<div id="map" class="map"></div>

<!-- контейнер для меток -->
<div id="maplist">
</div>