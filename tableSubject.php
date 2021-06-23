<?	
	if (isset($_GET['studentOne'])){
	   setcookie("studentOne", $_GET['studentOne'], time()+1000);
	   $studentOne = $_GET['studentOne'];	

	}else{
	   $studentOne = $_COOKIE['studentOne'];	
	}

	if (isset($_GET['subjectOne'])){
	   setcookie("subjectOne", $_GET['subjectOne'], time()+1000);
	   $subjectOne = $_GET['subjectOne'];	

	}else{
	   $subjectOne = $_COOKIE['subjectOne'];	
	}

	if (isset($_GET['columOne'])){
	   setcookie("columOne", $_GET['columOne'], time()+1000);
	   $columOne = $_GET['columOne'];	

	}else{
	   $columOne = $_COOKIE['columOne'];	
	}
	if (isset($_GET['sortOne'])){
		setcookie("sortOne", $_GET['sortOne'], time()+1000);
	   $sortOne = $_GET['sortOne'];	

	}else{
	   $sortOne = $_COOKIE['sortOne'];	
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
	$subjectData = explode(',', $subjectOne);

	if(isset($sortOne)){
		$sorting = "ORDER BY     
					{$numberToColum[$columOne]} {$sortOne}";
	}


	$query ="SELECT students.first_name, students.second_name, 
					subjects.name, grades.grade, grades.data
			FROM 
					grades
			JOIN  
					students
				ON 
					students.group = $studentOne AND grades.id_student = students.id
			JOIN  subjects
				ON subjects.id = $subjectData[0] AND grades.id_subject = subjects.id
			$sorting";

	$nextSort = (($_GET['sortOne'] == "ASC") ? "DESC" : "ASC");
					
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
	<?echo "Результаты по: $subjectData[1] $studentOne группы";?>
	<table class='table'>
		<thead id="tHead">
			<tr>
				<?
					foreach ($columsName as $key => $value) {
						echo "<th><a href='tableSubject.php?columOne=$key&sortOne=$nextSort'>$value  ";
						if (($key == $columOne)&&($sortOne != NULL))				
							echo (($sortOne == 'ASC')? '🠓':'🠑');
						echo "</a></th>";
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