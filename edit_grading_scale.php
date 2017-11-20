<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Grading Scale - 
		<?php
			session_start();
			$courseId = $_SESSION['courseId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['CourseCode'];
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
	<br><br>
	<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br>
	<p><b>Enter the minimum percentage required to receive each letter grade, as outlined in your syllabus.*</b></p>
	<form action="edit_grading_scale_result.php" method="post">
		<?php
			$_SESSION['gradedItemTypeIds'] = array();
			$_SESSION['otherGradedItemTypeIds'] = array();
			$sql = "SELECT LetterGrade, MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($grade = mysqli_fetch_array($result)){
				$letterGrade = $grade['LetterGrade'];
				$minimumGrade = $grade['MinimumGrade'];
				echo $letterGrade .":&nbsp;&nbsp;&nbsp;&nbsp;" . "<input type=\"text\" name=\"grade_" . $letterGrade . "\" id=\"grade_" . $letterGrade . "\" value=\"" . $minimumGrade*100 . "\" placeholder=\"" . $minimumGrade*100 . "\">%<br>";
			}
		?>
		<!--
		A:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_A" id="grade_A">%<br>
		AB:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_AB" id="grade_AB">%<br>
		B:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_B" id="grade_B">%<br>
		BC:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_BC" id="grade_BC">%<br>
		C:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_C" id="grade_C">%<br>
		CD:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_CD" id="grade_CD">%<br>
		D:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_D" id="grade_D">%<br>
		-->
		<br>
		<input type="submit" value="Change Scale" style="height:48px; width:120px; font-weight: bold;">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>