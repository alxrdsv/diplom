<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');

    $mysqli = new mysqli("localhost", "root", "123", "bd");

    $par1 = $_POST['par-select1'];
    $par2 = $_POST['par-select2'];
    $par3 = $_POST['par-select3'];
    $par4 = $_POST['par-select4'];
    $par5 = $_POST['par-select5'];
    $age = $_POST['age'];
    $bool = $_POST['bool'];



    


//    if ( запрос на совершеннолетних ) {
//        $sql = "SELECT fname, student.name as name, lname, DATE_FORMAT(birth,"%d.%m.%Y") as birth, team.name as id_team, town, formtr.name as id_ftr,
//        branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
//        concat("+7 (", substring(phone, 1, 3), ") ", substring(phone, -7, 3), "-", substring(phone, -4, 2), "-", substring(phone, -2, 2)) as phone,
//        id_prec FROM team, formtr, branch, department, profession, student 
//        WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr AND branch.id_branch = student.id_branch 
//        AND department.id_dep = student.id_dep AND profession.id_prof = student.id_prof 
//        AND ( (YEAR(CURRENT_DATE) - YEAR(birth)) - (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birth, '%m%d')) ) > 18";
//    }



    $sql = "SELECT fname, student.name as name, lname, DATE_FORMAT(birth,"%d.%m.%Y") as birth, team.name as id_team, town,
    formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
    concat("+7 (", substring(phone, 1, 3), ") ", substring(phone, -7, 3), "-", substring(phone, -4, 2), "-", substring(phone, -2, 2)) as phone,
    id_prec 
    FROM team, formtr, branch, department, profession, student 
    WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
    AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
    AND profession.id_prof = student.id_prof";


    $result = $mysqli->query($sql);

    if(!$result) {
        echo "Произошла ошибка: " . $mysqli->error . "\n" . "Запрос: $sql";
        return;
    }


    header("Location: /diplom/listst")

?>
