<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');

function check_request(array $required)
{
    foreach ($required as $value) {
        if (!isset($_REQUEST[$value]) || trim($_REQUEST[$value]) === "") {
            send_data("поле $value не задано.", 400);
            return false;
        }
    }
    return true;
}

function send_data($body, int $code = 200)
{
    http_response_code($code);
    if (!$body) return;

    if ($code >= 400)
        $response = json_encode(array("message" => $body, "error" => "Bad Request", "statusCode" => $code));
    else
        $response = json_encode($body);

    echo $response;
}

// Фильтрует данные удаляя пустые строки и пустые значения
function parse_request($request) {
    $result = array();
    foreach($request as $key => $value) {
        if(isset($value) && !empty($value)) $result[$key] = $value;
    }
    return $result;
}