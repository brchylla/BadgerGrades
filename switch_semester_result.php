<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Switch Semester - Result 
		<?php
			session_start();
			$courseId = $_SESSION['courseId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				echo " (" . $class['CourseCode'] . ")";
				break;
			}
		?>
	</title>
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
	<?php
		$semesterId = 0;
		if(!empty($_POST['semester'])){
			$semesterId = (int)$_POST['semester'];
			$sql = "UPDATE badgergrades.class SET SemesterID = $semesterId WHERE CourseID = $courseId;";
			if(isset($_SESSION['semesterId'])){
				$_SESSION['semesterId'] = $semesterId;
			}
			mysqli_query($con,$sql);
			
			echo "<h4>You have successfully switched the course to a different semester.</h4>";
			$sql = "SELECT CourseCode, CourseName, Semester, Institution, Credits FROM badgergrades.class INNER JOIN badgergrades.semester ON semester.SemesterID = class.SemesterID INNER JOIN badgergrades.institution ON institution.InstitutionID = class.InstitutionID WHERE CourseID = $courseId ORDER BY CourseCode;";
			$result = mysqli_query($con,$sql);
			echo "<table border='1' style='width:750px'><tr><th>Course Code</th><th>Course Name</th><th>Semester</th><th>Institution</th><th>Credits</th></tr>";
			while($class = mysqli_fetch_array($result)){
				echo "<tr><td>" . $class['CourseCode'] . "</td><td>" . $class['CourseName'] . "</td><td>" . $class['Semester'] . "</td><td>" . $class['Institution'] . "</td><td>" . $class['Credits'] . "</td></tr>";
			}
			echo "</table>";
		}
	else{
		echo "<h4>ERROR:</h4><h5>You have not selected a semester.</h5>";
	}
	?>
	<br><br>
	<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>