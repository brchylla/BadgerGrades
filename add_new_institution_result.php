<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Add New Institution - Result</title>
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
	  <li id="search"><form action="search.php" method="post" class="arrange_right"><b>Search:</b>	<input type="text" name="search" placeholder="Course or Instructor"><input type="submit" value="Submit"></form></li>
	</ul>
	<br><br>
	<?php
		session_start();
		$con = mysqli_connect("localhost","root","","badgergrades");
		$institutionId = $_SESSION['institutionId'];
		$institutionName = "";
		$city = "";
		$state = "";
		if(isset($_POST['institution']) && !empty($_POST['institution'])){
			$institutionName = $_POST['institution'];
		}
		if(isset($_POST['city']) && !empty($_POST['city'])){
			$city = $_POST['city'];
		}
		if(isset($_POST['state']) && !empty($_POST['state'])){
			$state = $_POST['state'];
		}
		if(!empty($institutionName)){
			$sql = sprintf("INSERT INTO badgergrades.institution(Institution, City, State) VALUES ('%s','%s','%s');", mysql_real_escape_string($institutionName), mysql_real_escape_string($city), mysql_real_escape_string($state));
			mysqli_query($con,$sql);
			if(isset($_SESSION['semesterId']) && !empty($_SESSION['semesterId'])){
				header('Location: semester_grades.php');
			}
			else{
				if(isset($_SESSION['institutionId']) && !empty($_SESSION['institutionId'])){
					header('Location: career_grades.php');
				}
			}
			echo "<h4>Your changes have been made successfully.</h4>";
		}
		else{
			echo "<h4>ERROR:</h4>";
			if(empty($institutionName)){
				echo "<h5>You must enter the name of the institution.</h5>";
			}
			if(empty($city)){
				echo "<h5>You must enter the city.</h5>";
			}
			if(empty($state)){
				echo "<h5>You must enter the state.</h5>";
			}
		}
	?>
	<br><br>
	<input type="button" value="Return to Add Course" onclick="location.href='add_course.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Return to Home" onclick="location.href='Home.php'"><br><br>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>