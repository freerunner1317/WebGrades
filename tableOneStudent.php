<?	
	if (isset($_GET['student'])){
	   setcookie("student", $_GET['student'], time()+600);
	   $student = $_GET['student'];	

	}else{
	   $student = $_COOKIE['student'];	
	}

	if (isset($_GET['data_start'])){
	   setcookie("data_start", $_GET['data_start'], time()+600);
	   $data_start = $_GET['data_start'];	

	}else{
	   $data_start = $_COOKIE['data_start'];	
	}

	if (isset($_GET['data_end'])){
	   setcookie("data_end", $_GET['data_end'], time()+600);
	   $data_end = $_GET['data_end'];	

	}else{
	   $data_end = $_COOKIE['data_end'];	
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<?
	$columsName = array('Предмет','Оценки','Дата');
	$numberToColum = array(
							'0' => 'subjects.name',
							'1' => 'grades.grade',
							'2'	=> 'grades.data');

	$link = mysqli_connect('localhost', 'root', 'root','libraryweb') 
	    or die("Ошибка " . mysqli_error($link));


	if(isset($_GET['sort'])){
		$sorting = "ORDER BY     
					{$numberToColum[$colum]} {$_GET['sort']}";
	}

	$query = "SELECT  
					subjects.name, grades.grade, grades.data
			  FROM 
			  		libraryweb.grades
			  JOIN  
			  		libraryweb.subjects
	          ON 
	          		subjects.id = grades.id_subject AND grades.id_student = $student
	          		$sorting";

	$nextSort = (($_GET['sort'] == "ASC") ? "DESC" : "ASC");
					
	echo $query;				
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