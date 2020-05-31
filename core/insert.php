<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');


require_once "request.php";

header("Content-Type: application/json");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST": {
            if (check_request(array("id", "name", "town", "street", "house"))) handle_get();
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

    //echo $response;

    //занесение данных в бд
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');

    $mysqli = new mysqli("localhost", "root", "123", "bd");

    $response_data = json_decode($response, true);

    // echo(json_encode($response_data["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]));

    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $town = $_REQUEST['town'];
    $street = $_REQUEST['street'];
    $house = $_REQUEST['house'];
    $points = $response_data["response"]["GeoObjectCollection"]["featureMember"];
    

    if(count($points) === 0) { echo "<script>alert('Адрес отсутствует!')</script>"; return; }

    $point = explode(" ", $points[0]["GeoObject"]["Point"]["pos"]);

    $lon = $point[0];
    $lat = $point[1];
    
    if(empty($id) || empty($name) || empty($town) || empty($street) || empty($house)){
        echo "<script>alert('Заполните все поля!')</script>";
        return;
    }
    $values = array();
    $sql = "INSERT INTO precinct (`id`, `name`, `town`, `street`, `house`, `lon`, `lat`) VALUES ('$id', '$name', '$town', '$street', '$house', '$lon', '$lat')";
    $result = $mysqli->query($sql);
    if(!$result) {
        echo "Произошла ошибка: " . $mysqli->error . "\n" . "Запрос: $sql";
        return;
    };
    print_r($_REQUEST);

    //header("Location: /diplom/map");
}
?>