<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once "request.php";

header("Content-Type: application/json");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "PUT": {
            if (check_request(array("id_stud", "id_precinct"))) handle_put();
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
    $id_precinct = $_REQUEST["id_precinct"];
    $id_precinct = $id_precinct === "null" ? $id_precinct : "'$id_precinct'";

    $mysqli = new mysqli("localhost", "root", "123", "bd");

    $result = $mysqli->query("UPDATE student SET id_prec=$id_precinct WHERE id_stud='$id_stud'");
    if (!$result) send_data("Произошла ошибка: " . $mysqli->error, 500);


    // send_data($response_data);
}
