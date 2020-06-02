<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once "request.php";

header("Content-Type: application/json");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "PUT": {
            if (check_request(array("id_stud"))) handle_put();
            break;
        }
    default: {
            send_data("Метод не найден.", 404);
            break;
        }
}

function handle_put()
{
    $id_stud = $_REQUEST["id_stud"];
    $id_prec = $_REQUEST["id_prec"];
    $bool = $_REQUEST["bool"];

    if (!isset($bool) && !isset($id_prec)) return send_data("Не задан обязательный параметр", 400);

    if (isset($bool)) $bool = $bool === "true" ? 1 : 0;
    if (isset($id_prec))
        $id_prec = $id_prec === "null" ? $id_prec : "'$id_prec'";

    $mysqli = new mysqli("localhost", "root", "123", "bd");
    $values = "";
    if (isset($id_prec)) $values .= " id_prec=$id_prec ";
    if (isset($bool)) $values .= " `bool`='$bool' ";


    $result = $mysqli->query("UPDATE student SET $values WHERE id_stud='$id_stud'");
    if (!$result) send_data("Произошла ошибка: " . $mysqli->error, 500);


    // send_data($response_data);
}
