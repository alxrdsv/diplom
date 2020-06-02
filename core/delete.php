
<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');

    $mysqli = new mysqli("localhost", "root", "123", "bd");

    $id = $_POST['id'];


    if(!isset($id)){
        echo "<script>alert('Вы не задали номер участка!')</script>";
        return;
    }

    $sql = "DELETE FROM precinct WHERE id = '$id'";
    $result = $mysqli->query($sql);

    if(!$result) {
        echo "Произошла ошибка: " . $mysqli->error . "\n" . "Запрос: $sql";
        return;
    }

  header("Location: /diplom/listpr")
?>