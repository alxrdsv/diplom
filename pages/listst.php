<?php
$host = 'localhost';
$user = 'root';
$pass = '123';
$db_name = 'bd';
$mysqli = new mysqli($host, $user, $pass, $db_name);
?>

<script>
	//поиск по таблице
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

<script type="text/javascript">
	//скрипт выгрузки таблицы в виде excel

	var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,',
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
			base64 = function(s) {
				return window.btoa(unescape(encodeURIComponent(s)))
			},
			format = function(s, c) {
				return s.replace(/{(\w+)}/g, function(m, p) {
					return c[p];
				})
			}
		return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {
				worksheet: name || 'Worksheet',
				table: table.innerHTML
			}
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
		<form method="POST">
			<div class="par">
				<label>Филиал: </label>
				<select name="branch" class="par-sel1">
					<option value="" selected></option>
					<?php
					$query1 = "SELECT name FROM `branch`";
					$result1 = $mysqli->query($query1) or die("Ошибка " . mysqli_error($link));
					while ($branch = $result1->fetch_assoc()) {
						echo "<option value='" . $branch['name'] . "'>" . $branch['name'] . "</option>";
					}

					?>
				</select>
			</div>

			<div class="par">
				<label>Курс: </label>
				<select name="course" class="par-sel2">
					<option value="" selected></option>
					<?php
					$query2 = "SELECT name FROM `course`";
					$result2 = $mysqli->query($query2) or die("Ошибка " . mysqli_error($link));
					while ($course = $result2->fetch_assoc()) {
						echo "<option value='" . $course['name'] . "'>" . $course['name'] . "</option>";
					}
					?>
				</select>
			</div>


			<div class="par">
				<label>Отделение: </label>
				<select name="department" class="par-sel3">
					<option value="" selected></option>
					<?php
					$query3 = "SELECT name FROM `department`";
					$result3 = $mysqli->query($query3) or die("Ошибка " . mysqli_error($link));
					while ($dep = $result3->fetch_assoc()) {
						echo "<option value='" . $dep['name'] . "'>" . $dep['name'] . "</option>";
					}

					?>
				</select>
			</div>

			<div class="par">
				<label>Специальность: </label>
				<select name="profession" class="par-sel4">
					<option value="" selected></option>
					<?php
					$query4 = "SELECT name FROM `profession`";
					$result4 = $mysqli->query($query4) or die("Ошибка " . mysqli_error($link));
					while ($prof = $result4->fetch_assoc()) {
						echo "<option value='" . $prof['name'] . "'>" . $prof['name'] . "</option>";
					}

					?>
				</select>
			</div>


			<div class="par">
				<label>Форма обучения: </label>
				<select name="formtr" class="par-sel5">
					<option value="" selected></option>
					<?php
					$query5 = "SELECT name FROM `formtr`";
					$result5 = $mysqli->query($query5) or die("Ошибка " . mysqli_error($link));
					while ($ftr = $result5->fetch_assoc()) {
						echo "<option value='" . $ftr['name'] . "'>" . $ftr['name'] . "</option>";
					}
					?>
				</select>
			</div>

			<div class="checkpan">
				<input type="checkbox" name="age" value="1" />
				<label>Совершеннолетние</label></br>
				<input type="checkbox" name="bool" value="1" />
				<label>Идут на выборы</label>
			</div>
			<div class="filter-sub">
				<input class="filter-apply apply" type="submit" name="apply" value="Применить" />
			</div>
		</form>
	</div>
</div>

	<?php
		$search_filters = array();
		foreach($_GET as $key => $value) {
			if($value === "") continue;
			switch($key) {
			case "branch":
			array_push($search_filters, "id_branch ='$value'");
			break;
			
			case "course":
			array_push($search_filters, "id_course = '$value'");
			break;

			case "department":
			array_push($search_filters, "id_dep = '$value'");
			break;
			
			case "profession":
			array_push($search_filters, "id_prof='$value'");
			break;
			
			case "formtr":
			array_push($search_filters, "id_ftr='$value'");
			break;
			
			case "age":
			array_push($search_filters, "((YEAR(CURRENT_DATE) - YEAR(birth)) - (DATE_FORMAT(CURRENT_DATE,'%m%d') < DATE_FORMAT(birth, '%m%d')) ) > 18");
			break;
			
			case "bool":
			array_push($search_filters, "bool = '1'");
			break;
			}
		}

		$filter_query = count($search_filters) > 0 ? "AND " . implode(" AND ", $search_filters) : "";
		$query = "SELECT fname, student.name as name, lname, DATE_FORMAT(birth,'%d.%m.%Y') as birth, team.name as id_team, town,
		formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
		concat('+7 (', substring(phone, 1, 3), ') ', substring(phone, -7, 3), '-', substring(phone, -4, 2), '-', substring(phone, -2, 2)) as phone,
		id_prec as id_precinct, bool
		FROM team, formtr, branch, department, profession, student 
		WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
		AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
		AND profession.id_prof = student.id_prof {$filter_query}";
		$result = $mysqli->query($query);
	?>

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
			function create_dropdown($column_key, $table)
			{
				global $mysqli;
			}

			$sql = $mysqli->query('SELECT id_stud, fname, student.name as name, lname, DATE_FORMAT(birth,"%d.%m.%Y") as birth, team.name as id_team, town,
			formtr.name as id_ftr, branch.name as id_branch, department.name as id_dep, profession.name as id_prof, id_course, 
			concat("+7 (", substring(phone, 1, 3), ") ", substring(phone, -7, 3), "-", substring(phone, -4, 2), "-", substring(phone, -2, 2)) as phone,
			id_prec as id_precinct, bool
			FROM team, formtr, branch, department, profession, student 
			WHERE team.id_team = student.id_team AND formtr.id_ftr = student.id_ftr 
			AND branch.id_branch = student.id_branch AND department.id_dep = student.id_dep 
			AND profession.id_prof = student.id_prof');

			while ($result = $sql->fetch_assoc()) {
				$id_stud = $result["id_stud"];
				echo "<tr>";
				foreach ($result as $key => $key_value) {
					$result_value = $key_value;
					// Если это не первичный ключ
					if ($key === "id_stud") continue;
					if ($key === "id_precinct") {
						$result_value = $result[$key];
						$fkeys = $mysqli->query("SELECT id, town as name FROM precinct");
						if ($fkeys) {
							$results = array();
							$result_value = "<select onchange='updateStudentStatus($id_stud, { id_prec: this.value })'><option value='null' selected>  </option>";
							// $value = "<select onchange='console.log(this.value, $id_stud)' name='$id_stud'>";
							while ($row = $fkeys->fetch_assoc()) {
								$id = $row["id"];
								// Если столбец имя присутствует, то он выводится в качестве текстовго читаемого значения, иначе id
								$name = $row["name"] ?? $id;
								$selected = $id === $key_value ? "selected" : "";
								$result_value .= "<option $selected  value='$id'>$id ($name)</option>";
							}
							$result_value .= "</select>";
						}
					}
					if ($key === "bool") {
						$v = $key_value ? "checked" : "";
						echo "<td> <input $v  type='checkbox' onchange='updateStudentStatus($id_stud, { bool: this.checked })' > </td>";
					} else {
						echo "<td> $result_value </td>";
					}
				}
			}
			echo "</tr>";
			?>
		</tbody>
	</table>
	<script>
		new Tablesort(document.getElementById('tablest'));
	</script>
</div>