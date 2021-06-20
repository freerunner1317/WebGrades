<?	
	if (isset($_GET['student'])){
	   setcookie("student", $_GET['student'], time()+9000);
	   $student = $_GET['student'];	

	}else{
	   $student = $_COOKIE['student'];	
	}

	if (isset($_GET['colum'])){
		setcookie("colum", $_GET['colum'], time()+9000);
	   $colum = $_GET['colum'];	

	}else{
	   $colum = $_COOKIE['colum'];	
	}

	if (isset($_GET['sort'])){
		setcookie("sort", $_GET['sort'], time()+9000);
	   $sort = $_GET['sort'];	

	}else{
	   $sort = $_COOKIE['sort'];	
	}

	if (isset($_GET['date_start'])){
	   setcookie("date_start", $_GET['date_start'], time()+9000);
	   $date_start = $_GET['date_start'];	

	}else{
	   $date_start = $_COOKIE['date_start'];	
	}

	if (isset($_GET['date_end'])){
	   setcookie("date_end", $_GET['date_end'], time()+9000);
	   $date_end = $_GET['date_end'];	

	}else{
	   $date_end = $_COOKIE['date_end'];	
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

	//var_dump($sort);

	if(isset($_GET['sort'])){
		$sorting = "ORDER BY     
					{$numberToColum[$colum]} {$_GET['sort']}";
	}

	$studentAll = explode(';', $student);

	$query = "SELECT  
					subjects.name, grades.grade, grades.data
			  FROM 
			  		grades
			  JOIN  
			  		subjects
	          ON 
	          		subjects.id = grades.id_subject AND 
	          		grades.id_student = $studentAll[0] AND
	          		grades.data < '$date_end' AND 
	          		grades.data > '$date_start'
	          		$sorting";

	$nextSort = (($_GET['sort'] == "ASC") ? "DESC" : "ASC");
					
	//echo $query;				
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	foreach ($result as $key => $value) {
		$grades_st[$key][0] = $value['name'];
		$grades_st[$key][1] = $value['grade'];		
		$grades_st[$key][2] = $value['data'];
	}  
?>


<body> 
	<?


	echo "Результаты по: $studentAll[1] для промежутка с $date_start по $date_end";?>
	<table class='table'>
		<thead id="tHead">
			<tr>
				<?
					foreach ($columsName as $key => $value) {
						echo "<th>";
						echo "<a href='tableOneStudent.php?colum=$key&sort=$nextSort'>$value ";
						if ($key == $colum)							
							echo (($sort == 'ASC')? '🠓':'🠑');
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