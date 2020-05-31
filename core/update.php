<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');

    require_once "request.php";

    header("Content-Type: application/json");

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "POST": {
                if (check_request(array("id"))) handle_get();
                break;
            }
        default: {
                send_data("Метод не найден.", 404);
                break;
            }
    }

    function handle_get() {
        $geocode = "г. " . $_REQUEST["town"] . ", ул. " . $_REQUEST["street"] . ", д." . $_REQUEST["house"];
        $query = http_build_query(array(
            "apikey" => "84314dca-6af9-430d-b2e5-1faac3126fa8",
            "geocode" => $geocode,
            "format" => "json"
        ));
        $url = "https://geocode-maps.yandex.ru/1.x/?$query";

        $curl = curl_init();
     
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // получаем HTML в качестве результата
        $response = curl_exec($curl);
        // закрываем соединение
        curl_close($curl);

    $mysqli = new mysqli("localhost", "root", "123", "bd");

    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $town   = $_POST['town'];
    $street = $_POST['street'];
    $house  = $_POST['house'];
    $points = $response_data["response"]["GeoObjectCollection"]["featureMember"];

    if(count($points) === 0) { echo "<script>alert('Адрес отсутствует!')</script>"; return; }

    $point = explode(" ", $points[0]["GeoObject"]["Point"]["pos"]);

    $lon = $point[0];
    $lat = $point[1];

    if(!isset($id)){
        echo "Вы не задали номер участка!";
        return;
    }

    $values = array();

    foreach($_POST as $key => $value) {
        if($key !== "id" && isset($value) && !empty($value))
            array_push($values, "$key='$value'");
    }

    $sql_values = implode(", ", $values);

    $sql = "UPDATE precinct SET $sql_values WHERE id='$id'";
    $result = $mysqli->query($sql);

    if(!$result) {
        echo "Произошла ошибка: " . $mysqli->error . "\n" . "Запрос: $sql";
        return;
    };
    print_r($_REQUEST);

    header("Location: /diplom/listpr");
}
?>