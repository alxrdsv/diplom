
<!doctype>
<html>

    <head>
        <title>Диплом</title> 
		
        <link rel="stylesheet" type="text/css" href="/diplom/css/style.css">
    
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
		<script src="https://api-maps.yandex.ru/2.1/?apikey=84314dca-6af9-430d-b2e5-1faac3126fa8&lang=ru_RU" type="text/javascript"></script>

		<script src="jquery.min.js"></script>
		<script src="main.js"> </script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tablesort/5.0.2/tablesort.min.js"</script>
		
		<script language="JavaScript">
			function setVisibility(id, visibility) {
			document.getElementById(id).style.display = visibility;
			}
		</script>
		

		<script type="text/javascript">
		// Функция, проверяющая форму на корректность
		// form - элемент формы
		// required - массив с именами полей, которые должны быть введены пользователем
		function checkForm(form, required = []) {
			// Возвращается объект с отправляемыми данными формы
			const data = new FormData(form);
			// Прогоняется массив с полями, обязательными для ввода
			for (let name of required) {
				// Получаем значение из данных формы
				const value = data.get(name);
				// Если значение не задано, либо оно является пустой строкой
				if (!value || value.trim() === "") {
				// Выводится сообщение об ошибке
				alert("Заполните все поля!");
				// Возвращается false, который обработчик onsubmit в форме интерпретирует как отмену отправки формы
				return false;
				}
		}
		// Если массив прогнался без ошибок - выводится true, можно отправить форму
		return true;
		}
	</script>

    </head> 
     
    
    <body> 
	<?php

		$host = 'localhost'; 
		$user = 'root';   
		$pass = '123'; 
		$db_name = 'bd'; 
		$link = mysqli_connect($host, $user, $pass, $db_name);

		
		if (!$link) {
			echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
		exit;
		}
		
   ?>
<div class="header" id="header">
	<div class="nav">
		<a class="nav-link" href="/diplom/">Карта</a>
	</div>
	<div class="nav">
		<a class="nav-link" onclick="setVisibility('pre', 'inline')" href="javascript:void(0)">Добавить участок</a>
	</div>
	<div class="nav">
		<a class="nav-link" href="/diplom/listpr">Избирательные участки</a>
	</div>
	<div class="nav">
		<a class="nav-link" href="/diplom/listst">Список студентов</a>
	</div>
	<div class="out">
		<a class="logout" href="/diplom/auth/?act=logout">Выйти</a>
	</div>
	
	<script type="text/javascript">

		function setVisibility(id){
			display = document.getElementById(id).style.display;
			if(display=='none'){
			document.getElementById(id).style.display='block';
			}else{
			document.getElementById(id).style.display='none';
			}
		}
	</script>





	<div id="pre">
		<form onsubmit="return onFormSubmit(this)" action="/diplom/core/insert.php" method="POST" class="form">
			<div class="pr-title">
				Добавить участок
				<span class="close" onclick="setVisibility('pre', 'none')">&times;</span>
			</div>
			<div style="text-align: center;">
				<p>
					<label>Участковая избирательная комиссия №</label>
					<input type="text" class="input1" id="id" name="id">
				</p>
				<p>
					<label>Место нахождения</label></p>
				<p>
					<input type="text" class="input2" id="name" name="name"></p>
				<p><label>Адрес</label></p>
				<p>
				<input type="text" class="input3" id="town" name="town" placeholder="город">
				<input type="text" class="input4" id="street" name="street" placeholder="улица">
				<input type="text" class="input5" id="house" name="house" placeholder="дом">
				<p><input class="subpre" name="sub" type="submit" value="Добавить"/></p>
			</div>
		</form>
	</div>
	
</div>

<div class="content">
