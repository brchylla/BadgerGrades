<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Semester</title>
	<meta name="author" content="Benjamin" />
	<!-- Date: 2015-08-15 -->
</head>
<body>
	<a href="Home.php"><img src="BuckyBadger.svg.png" alt="Bucky Badger" id="buckey" class="arrange_left"></a>
	<a href="Home.php" style="text-decoration : none"><p style="font-size:500%;color:red">BadgerGrades</p></a>
	<ul>
	  <li id="home"><a href="Home.php"><font color="red">Help</font></a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <li id="add_course"><a href="add_course.php"><font color="red">Add Course</font></a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <li id="semester"><a href="semester_institution.php"><font color="red">Semester</font></a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <li id="career"><a href="career_institution.php"><font color="red">Career</font></a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <li id="course_history"><a href="course_history.php"><font color="red">Course History</font></a></li>
	  <li id="search"><form action="search.php" method="post" class="arrange_right"><img src="ic_search_48px-128.png" height="25" width="25"><input type="text" name="search" placeholder="Course or Instructor"><input type="submit" value="Submit"></form></li>
	</ul>
	<br><
	<?php
		session_start();
		$semesterId = $_SESSION['semesterId'];
		$con = mysqli_connect("localhost","root","","badgergrades");
		$sql = "SELECT Semester, Year FROM badgergrades.semester WHERE SemesterID = $semesterId;";
		$result = mysqli_query($con,$sql);
		$semesterName = "";
		$year = 0;
		while($semester = mysqli_fetch_array($result)){
			$semesterName = $semester['Semester'];
			$year = (int)$semester['Year'];
		}
	?>
	<?php
		if(isset($_SESSION['semesterId']) && !empty($_SESSION['semesterId'])){
			echo "<input type=\"button\" value=\"Back to Semester Grades\" onclick=\"location.href='semester_grades.php'\"><br><br>";
		}
		else{
			if(isset($_SESSION['institutionId']) && !empty($_SESSION['institutionId'])){
				echo "<input type=\"button\" value=\"Back to Career Grades\" onclick=\"location.href='career_grades.php'\"><br><br>";
			}
		}
	?>
	<input type="button" value="Return to Home" onclick="location.href='Home.php'">
	<br><br>
	<h1>Edit Semester - <?php echo $semesterName; ?></h1>
	<form action="edit_semester_result.php" method="post">
		<label for 'season'>Select the season:&nbsp;</label>
		<select name='season'>
			<option value=''>Select a season...</option>
			<option value='Fall'>Fall</option>
			<option value='Spring'>Spring</option>
			<option value='Winter'>Winter</option>
			<option value='Summer'>Summer</option>
		</select><br><br>
		<label for 'year'>Enter the year:&nbsp;</label>
		<input type="text" name="year" id="year" id="year" value="<?php echo $year; ?>" placeholder="<?php echo $year; ?>" style="width:40px;"><br><br>
		<input type="submit" value="Edit Semester">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>