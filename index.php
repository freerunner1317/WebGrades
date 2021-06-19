<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
	<?
		$link = mysqli_connect('localhost', 'root', 'root','libraryweb') 
	    or die("Ошибка " . mysqli_error($link));

	    if(isset($_GET['student'])){
	    	$query ="INSERT INTO grades (id_subject, id_student, grade, data) VALUES ('{$_GET['subject']}', '{$_GET['student']}', '{$_GET['grade']}', '{$_GET['date']}');
";	 
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	    }
	?>

<body> 
	<form method="GET" action="index.php">
		<div class="grade">
			<?
				$query ="SELECT * FROM students;";
				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
				foreach ($result as $key => $value) {
					$students[$key][0] = $value['id'];
					$students[$key][1] = $value['first_name'];
					$students[$key][2] = $value['second_name'];
					$students[$key][3] = $value['group'];
					$group[$key] = $value['group'];
					$student[0][$key] = $value['first_name']." ".$value['second_name'];
					$student[1][$key] = $value['id'];
				}

			?>
			<select name="student">	
				<?
				    foreach ($students as $key => $value) {
				    	echo "<option value='$value[0]'>$value[1] $value[2]; $value[3] Группа</option>";	
				    }	   	 		   		
				?>
			</select>

			<?
				$query ="SELECT * FROM subjects;";
				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
				foreach ($result as $key => $value) {
					$subjects[$key][0] = $value['id'];
					$subjects[$key][1] = $value['name'];
				}

			?>
			<select name="subject">	
				<?
				    foreach ($subjects as $key => $value) {
				    	echo "<option value='$value[0]'>$value[1]</option>";	
				    }	   	 		   		
				?>
			</select>

			<p>Оценка
			<input type="number" name="grade" min="1" max="5" required>
			Дата
			<input type="data" name="date" required>	
			</p>
			<p><input type="submit" value="Занести запись"></p>
		</div>
	</form>	

	

	<form method="GET" action="tableSubject.php">
		<div class="grade">
			<p style="text-align: center;">Формы на вывод в таблицу</p>
			<select name="subject">	
					<?
					    foreach ($subjects as $key => $value) {
					    	echo "<option value='$value[0]'>$value[1]</option>";	
					    }	   	 		   		
					?>
			</select>

			<select name="student">	
					<?										
						$students_unique = array_unique($group);
					    foreach ($students_unique as $key => $value) {
					    	echo "<option value='$value'>$value Группа</option>";	
					    }	   	 		   		
					?>
			</select>
			<input type="submit" value="Показать студентов">
		</div>

	</form>

	<form method="GET" action="tableOneStudent.php">
		<div class="grade">
			<select name="student">	
					<?										
						$students_unique = array_unique($student[0]);
					    foreach ($students_unique as $key => $value) {
					    	echo "<option value='$student[1][$key]'>$value</option>";	
					    }	   	 		   		
					?>
			</select>
			Начало
			<input type="data" name="date_start" required>
			Конец
			<input type="data" name="date_end" required>
			<p><input type="submit" value="Показать оценки"></p>
		</div>

	</form>

</body>
<style type="text/css">	

</style>
</html>