<?php

	$host = 'localhost';  
	$user = 'root';  
	$pass = '123'; 
	$db_name = 'bd';   
	$link = mysqli_connect($host, $user, $pass, $db_name); 

?>

	

	<script>//поиск по таблице
		function tableSearch() {
		var phrase = document.getElementById('search-st');
		var table = document.getElementById('tablest');
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

	<div class="com-panel">
		
		<div class="dep">
			<div style="margin-right: 10px">
				<a href="#" onclick="tableToExcel('tablest', 'W3C Example Table')" class="download">Скачать таблицу</a>
				<input class="form-search" type="text" placeholder="Поиск по таблице" id="search-st" onkeyup="tableSearch()">
			</div>	
		</div>
		
		<div class="panel-filter">
			<form action="/diplom/core/filter.php" method="POST">
			<div class="par">
				<label>Филиал: </label>
				<select name="par-select1" class="par-sel1">
					<option value="" selected></option>
					<?php
					$query1 ="SELECT name FROM `branch`";
					$result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
					while ($branch = mysqli_fetch_array($result1, MYSQLI_ASSOC))
					{ 
						echo "<option value='" . $branch['name'] . "'>".$branch['name']."</option>";
					}

				?>
				</select>
			</div>

			<div class="par">
				<label>Курс: </label>
				<select name="par-select2" class="par-sel2">
					<option value="" selected></option>
					<?php
					$query2 ="SELECT name FROM `course`";
					$result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link));
					while ($course = mysqli_fetch_array($result2, MYSQLI_ASSOC))
					{ 
						echo "<option value='" . $course['name'] . "'>".$course['name']."</option>";
					}
				?>
				</select>
			</div>
			

			<div class="par">
				<label>Отделение: </label>
				<select name="par-select3" class="par-sel3">
					<option value="" selected></option>
					<?php
					$query3 ="SELECT name FROM `department`";
					$result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
					while ($dep = mysqli_fetch_array($result3, MYSQLI_ASSOC)) 
					
					{ 
						echo "<option value='" . $dep['name'] . "'>".$dep['name']."</option>";
					}

				?>
				</select>
			</div>
			
			<div class="par">
				<label>Специальность: </label>
				<select name="par-select4" class="par-sel4">
					<option value="" selected></option>
					<?php
					$query4 ="SELECT name FROM `profession`";
					$result4 = mysqli_query($link, $query4) or die("Ошибка " . mysqli_error($link));
					while ($prof = mysqli_fetch_array($result4, MYSQLI_ASSOC)) 
					
					{ 
						echo "<option value='" . $prof['name'] . "'>".$prof['name']."</option>";
					}

				?>
				</select>
			</div>
			
			
			<div class="par">
				<label>Форма обучения: </label>
				<select name="par-select5" class="par-sel5">
				<option value="" selected></option>
				<?php
					$query5 ="SELECT name FROM `formtr`";
					$result5 = mysqli_query($link, $query5) or die("Ошибка " . mysqli_error($link));
					while ($ftr = mysqli_fetch_array($result5, MYSQLI_ASSOC))
					{ 
						echo "<option value='" . $ftr['name'] . "'>".$ftr['name']."</option>";
					}
				?>
				</select>
			</div>

			<div class="checkpan">		
				<input type="checkbox" name="age" value="Yes"/>
				<label>Совершеннолетние</label></br>
				<input type="checkbox" name="bool" value="Yes"/>
				<label>Идут на выборы</label>
			</div>
			<div class="filter-sub">
				<input class="filter-apply apply" type="submit" name="apply" value="Применить"/>	
			</div>
				</form>
		</div>	
	</div>	

<div class="conttabst">
	<table class="tablest" id="tablest">	
		<thead class="thead">
			<tr>
				<th style="width: 7%">Фамилия</th>
				<th style="width: 6%">Имя</th>
				<th style="width: 7%">Отчество</th>
				<th data-sort-method='none' style="width: 6%">Дата рождения</th>
				<th style="width: 6%">Группа</th>
				<th style="width: 6%">Город проживания</th>
				<th style="width: 5%">Форма обучения</th>
				<th style="width: 5%">Филиал</th>
				<th style="width: 15%">Отделение</th>
				<th style="width: 15%">Специальность</th>
				<th style="width: 3%">Курс</th>
				<th data-sort-method='none' style="width: 8%">Телефон</th>
				<th style="width: 7%">Избирательный участок</th>
				<th data-sort-method='none' style="width: 5%">Идет на выборы</th>
			</tr>
		</thead>

		<tbody>
			<?php
			$sql = mysqli_query($link, 'SELECT fname, student.name as name, lname, DATE_FORMAT(birth,"%d.%m.%Y") as birth, team.name as id_team, town,
			formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
			concat("+7 (", substring(phone, 1, 3), ") ", substring(phone, -7, 3), "-", substring(phone, -4, 2), "-", substring(phone, -2, 2)) as phone,
			id_prec 
			FROM team, formtr, branch, department, profession, student 
			WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
			AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
			AND profession.id_prof = student.id_prof');
			while ($result = mysqli_fetch_array($sql)) {
				echo "
			<tr>
			<td>{$result['fname']}</td>
			<td>{$result['name']}</td>
			<td>{$result['lname']}</td>
			<td>{$result['birth']}</td>
			<td>{$result['id_team']}</td>
			<td>{$result['town']}</td>
			<td>{$result['id_ftr']}</td>
			<td>{$result['id_branch']}</td>
			<td>{$result['id_dep']}</td>
			<td>{$result['id_prof']}</td>
			<td>{$result['id_course']}</td>
			<td>{$result['phone']}</td>
			<td>{$result['id_prec']}</td>
			<td></td>
			</tr>";}
			?>
		</tbody>
	</table>
	<script>
			$("td").click(function() {
				
				$(this).toggleClass("colored");
			  });
	</script>
	<script>new Tablesort(document.getElementById('tablest'));</script>
</div>