<?php

	$host = 'localhost';  
	$user = 'root';  
	$pass = '123'; 
	$db_name = 'bd';   
	$link = mysqli_connect($host, $user, $pass, $db_name); 

?>

	<script>//поиск по таблице
		function tableSearch() {
		var phrase = document.getElementById('search-pr');
		var table = document.getElementById('tableprec');
		var regPhrase = new RegExp(phrase.value, 'i');
		var flag = false;
		for (var i = 1; i < table.rows.length; i++) {
			flag = false;
			for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
				flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
				if (flag) break;
			}
			if (flag) {
				table.rows[i].style.display = "";
			} else {
				table.rows[i].style.display = "none";
			}

		}
	}
	</script>


	<script type="text/javascript">//скрипт выгрузки таблицы в виде excel
		
		var tableToExcel = (function() {
			var uri = 'data:application/vnd.ms-excel;base64,',
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
			return function(table, name) {
				if (!table.nodeType) table = document.getElementById(table)
				var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
				window.location.href = uri + base64(format(template, ctx))
			}
		})()
	</script>

	<div class="containerpr">	

		<div class="containertab">
			
			<table class="tablepr" id="tableprec">
				<caption class="cap">Список избирательных участков</caption>
				
				<thead>
					<tr>
						<th id="col1">№</th>
						<th id="col2">Место нахождения</th>
						<th id="col3">Город</th>
						<th id="col4">Улица</th>
						<th data-sort-method='none' id="col5">Дом</th>
					</tr>
					
				</thead>
				<tbody>
					<?php
					$sql = mysqli_query($link, 'SELECT `id`, `name`, `town`, `street`, `house` FROM `precinct`');
					while ($result = mysqli_fetch_array($sql)) {
						echo "
					<tr>
					<td>{$result['id']}</td>
					<td>{$result['name']}</td>
					<td>{$result['town']}</td>
					<td>{$result['street']}</td>
					<td>{$result['house']}</td>
					</tr>";}
					?>

				</tbody>
			</table>
			<script>new Tablesort(document.getElementById('tableprec'));</script>
		</div>

		<div class="panel">
			<div class="search">
				<input class="form-search" type="text" placeholder="Поиск по таблице" id="search-pr" onkeyup="tableSearch()">
			</div>
			<div class="upd">
				<h3>Редактирование записи</h3>
				<form action="/diplom/core/update.php" onsubmit="return onFormSubmit(this)" method="POST" class="updform">
					<p>
						<label for="id">Выберите № участка:</label>
						<input type="number" id="id" name="id" required>
					</p>
					<p>
						<label for="name">Место нахождения:</label>
						<input type="text" id="name" name="name">
					</p>
					<p>
						<label for="town">Город:</label>
						<input type="text" id="town" name="town">
					</p>
					<p>
						<label for="street">Улица:</label>
						<input type="text" id="street" name="street">
					</p>
					<p>
						<label for="house">Дом:</label>
						<input type="text" id="house" name="house">
					</p>
					<input type="submit" value="Обновить запись">
				</form>
			</div>
		
			<div class="delete">
				<h3>Удаление записи</h3>
				<form action="/diplom/core/delete.php" method="POST">
					Удалить участок под №
					<input type="text" id="id" name="id" size="6">
					<input type="submit" value="OK">
				</form>
			</div>
		
			<div class="down">
				<h3>Выгрузка таблицы в виде MS Excel</h3>
				<a href="#" onclick="tableToExcel('tableprec', 'W3C Example Table')" class="download">Скачать файл</a>
			</div>
		</div>
	</div>