<?	
	if (isset($_GET['student'])){
	   setcookie("student", $_GET['student'], time()+600);
	   $student = $_GET['student'];	

	}else{
	   $student = $_COOKIE['student'];	
	}

	if (isset($_GET['subject'])){
	   setcookie("subject", $_GET['subject'], time()+600);
	   $subject = $_GET['subject'];	

	}else{
	   $subject = $_COOKIE['subject'];	
	}

	if (isset($_GET['colum'])){
	   setcookie("colum", $_GET['colum'], time()+600);
	   $colum = $_GET['colum'];	

	}else{
	   $colum = $_COOKIE['colum'];	
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<?
	$columsName = array('Имя','Фамилия','Оценка', 'Дата');
	$numberToColum = array(
							'0' => 'students.first_name',
							'1' => 'students.second_name',
							'2'	=> 'grades.grade',
							'3' => 'grades.data');

	$link = mysqli_connect('localhost', 'root', 'root','libraryweb') 
	    or die("Ошибка " . mysqli_error($link));


	if(isset($_GET['sort'])){
		$sorting = "ORDER BY     
					{$numberToColum[$colum]} {$_GET['sort']}";
	}


	$query ="SELECT students.first_name, students.second_name, 
					subjects.name, grades.grade, grades.data
			FROM 
					libraryweb.grades
			JOIN  
					libraryweb.students
				ON 
					students.group = $student AND grades.id_student = students.id
			JOIN  libraryweb.subjects
				ON subjects.id = $subject AND grades.id_subject = subjects.id
			$sorting";

	$nextSort = (($_GET['sort'] == "ASC") ? "DESC" : "ASC");
					
	//echo $query;				
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	foreach ($result as $key => $value) {
		$grades_st[$key][0] = $value['first_name'];
		$grades_st[$key][1] = $value['second_name'];		
		$grades_st[$key][2] = $value['grade'];
		$grades_st[$key][3] = $value['data'];
		$subject = $value['name'];
	}  
?>


<body> 
	<?echo "Результаты по: $subject $student группы";?>
	<table class='table'>
		<thead id="tHead">
			<tr>
				<?
					foreach ($columsName as $key => $value) {
						echo "<th><a href='tableSubject.php?colum=$key&sort=$nextSort'>$value</a></th>";
					}
				?>			
			</tr>
		
		</thead>
		<tbody id="tBody">
		<tr>
			<?
			if($grades_st){
				foreach ($grades_st as $line) {
					echo "<tr>";
					foreach ($line as $line_split_values) {
							echo "<td>".$line_split_values."</td>";
					}
					echo "</tr>";
				}
			}
			?>	
		</tr>

		</tbody>

	</table>
	<a href="index.php">Форма выбора</a>
</body>
<style type="text/css">	

</style>
</html>