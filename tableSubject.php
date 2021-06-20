<?	
	if (isset($_GET['student'])){
	   setcookie("student", $_GET['student'], time()+9000);
	   $student = $_GET['student'];	

	}else{
	   $student = $_COOKIE['student'];	
	}

	if (isset($_GET['subject'])){
	   setcookie("subject", $_GET['subject'], time()+9000);
	   $subject = $_GET['subject'];	

	}else{
	   $subject = $_COOKIE['subject'];	
	}

	if (isset($_GET['colum'])){
	   setcookie("colum", $_GET['colum'], time()+9000);
	   $colum = $_GET['colum'];	

	}else{
	   $colum = $_COOKIE['colum'];	
	}
	if (isset($_GET['sortOne'])){
		setcookie("sortOne", $_GET['sortOne'], time()+9000);
	   $sortOne = $_GET['sortOne'];	

	}else{
	   $sort = $_COOKIE['sort'];	
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


	if(isset($_GET['sortOne'])){
		$sorting = "ORDER BY     
					{$numberToColum[$colum]} {$_GET['sortOne']}";
	}


	$query ="SELECT students.first_name, students.second_name, 
					subjects.name, grades.grade, grades.data
			FROM 
					grades
			JOIN  
					students
				ON 
					students.group = $student AND grades.id_student = students.id
			JOIN  subjects
				ON subjects.id = $subject AND grades.id_subject = subjects.id
			$sorting";

	$nextSort = (($_GET['sortOne'] == "ASC") ? "DESC" : "ASC");
					
	echo $sortOne;				
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
						echo "<th><a href='tableSubject.php?colum=$key&sortOne=$nextSort'>$value  ";
						if (($key == $colum)&&($sortOne != NULL))				
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