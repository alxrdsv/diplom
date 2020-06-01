<?php
error_reporting(E_ERROR | E_PARSE);
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

function handle_get()
{
    $id = $_REQUEST["id"];

    $mysqli = new mysqli("localhost", "root", "123", "bd");

    $current_data_response = $mysqli->query("SELECT * FROM precinct WHERE id='$id'");
    if (!$current_data_response) {
        send_data("Неверный id!", 400);
        return;
    }

    $current_data = $current_data_response->fetch_assoc();

    $request = parse_request($_REQUEST);

    $town = $request["town"]  ?? $current_data["town"];
    $street = $request["street"] ?? $current_data["street"];
    $house = $request["house"] ?? $current_data["house"];

    $geocode = "г. $town, ул. $street,  д. $house";
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

    
    $response_data = json_decode($response, true);
    $points = $response_data["response"]["GeoObjectCollection"]["featureMember"];

    if (count($points) === 0) {
        send_data("Адрес отсутствует!", 400);
        return;
    }

    $point = explode(" ", $points[0]["GeoObject"]["Point"]["pos"]);



    $lon = $point[0];
    $lat = $point[1];

    // Присваиваем переменной $reques_data данные, отправляемые в бд
    $request_data = array("town" => $town, "street" => $street, "house" => $house, "lon" => $lon, "lat" => $lat);

    $values = array();

    foreach ($request_data as $key => $value) {
        if ($key !== "id" && isset($value) && !empty($value))
            array_push($values, "$key='$value'");
    }

    $sql_values = implode(", ", $values);

    $sql = "UPDATE precinct SET $sql_values WHERE id='$id'";
    $result = $mysqli->query($sql);

    

    if (!$result) {
        send_data("Произошла ошибка: " . $mysqli->error . "\n" . "Запрос: $sql", 500);
        return;
    };

    send_data($response_data);
}
