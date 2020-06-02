<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', '1'); 
    ini_set('display_startup_errors', '1');

    $mysqli = new mysqli("localhost", "root", "123", "bd");





    
    //значения из селекторов, не уверена, что прописала  названияименно тех полей
    $par1 = $_REQUEST["par-select1"];
    $par2 = $_REQUEST["par-select2"];
    $par3 = $_REQUEST["par-select3"];
    $par4 = $_REQUEST["par-select4"];
    $par5 = $_REQUEST["par-select5"];
    //2 чекбокса
    $age = $_REQUEST["age"];
    $bool = $_REQUEST["bool"];


    //не уверена, что прописывать условие нужно именно так, но здесь логика такая: если селект 1 под именем par1(задала это название выше)
    //не пустой, то делать выборку с условием, где(последняя строка запроса) значение столбца из бд будет равно выбранному значению(тоже не знаю как это написать)
    //и так все 5 запросов ниже, они все подобны этому
    if ( $_REQUEST["$par1"] !== '') {
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
            formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
            concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
            id_prec as id_precinct, bool
            FROM team, formtr, branch, department, profession, student 
            WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
            AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
            AND profession.id_prof = student.id_prof
            AND id_branch = ");
    } 
    else if ( $_REQUEST["$par2"] !== ''){
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
            formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
            concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
            id_prec as id_precinct, bool
            FROM team, formtr, branch, department, profession, student 
            WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
            AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
            AND profession.id_prof = student.id_prof
            AND id_course = ");
    } 
    else if ( $_REQUEST["$par3"] !== '') {
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
            formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
            concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
            id_prec as id_precinct, bool
            FROM team, formtr, branch, department, profession, student 
            WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
            AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
            AND profession.id_prof = student.id_prof
            AND id_dep = ");
    } 
    else if ( $_REQUEST["$par4"] !== ''){
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
            formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
            concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
            id_prec as id_precinct, bool
            FROM team, formtr, branch, department, profession, student 
            WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
            AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
            AND profession.id_prof = student.id_prof
            AND id_prof = ");

    } else if ( $_REQUEST["$par5"] !== ''){
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
            formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
            concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
            id_prec as id_precinct, bool
            FROM team, formtr, branch, department, profession, student 
            WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
            AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
            AND profession.id_prof = student.id_prof
            AND id_ftr = ");
    } 
    //если чекбокс из формы(метод post) под именем age не пустой, то сделать выборку
    else if ( $_REQUEST["$age"] !== '')
    {
        //запрос рабочий(проверила в sql), выбирает только совершеннолетних
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
			formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
			concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
			id_prec as id_precinct, bool
			FROM team, formtr, branch, department, profession, student 
			WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
			AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
			AND profession.id_prof = student.id_prof
            AND ( (YEAR(CURRENT_DATE) - YEAR(birth)) - (DATE_FORMAT(CURRENT_DATE,'%m%d') < DATE_FORMAT(birth, '%m%d')) ) > 18");
    } 
    else if ($_REQUEST["$bool"] !== '') {
        //запрос рабочий(проверила в sql), выбирает только те поля из бд, где bool=1 т.е. поставлена галочка в таблице на сайте
        $result = $mysqli->query("SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
			formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
			concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
			id_prec as id_precinct, bool
			FROM team, formtr, branch, department, profession, student 
			WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
			AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
			AND profession.id_prof = student.id_prof
            AND bool = '1'");
    }

    if(!$result) {
        echo "Произошла ошибка: " . $mysqli->error . "\n" . "Запрос: $sql";
        return;
    }
    header("Location: /diplom/listst")
?>