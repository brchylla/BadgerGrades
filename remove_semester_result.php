<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Remove Semester - Result</title>
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
	<input type="button" value="Back to Remove Semester" onclick="location.href='remove_semester.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Return to Home" onclick="location.href='Home.php'">
	<?php
		session_start();
		if(isset($_POST['semester']) && !empty($_POST['semester'])){
			$semesters = $_POST['semester'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			foreach($semesters as $semester){
				$semesterId = (int)$semester;
				deleteCourse($con,$semesterId);
				$sql = "DELETE FROM badgergrades.semester WHERE SemesterID = $semesterId;";
				mysqli_query($con,$sql);
			}
			echo "<h3>Semester(s) successfully deleted!</h3>";
		}
		else{
			echo "<h4>ERROR:</h4><h5>You do not select any semesters.</h5>";
		}
		
		function deleteCourse($con,$semesterId){
			$sql = "SELECT CourseID FROM badgergrades.class WHERE SemesterID = $semesterId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				$courseId = (int)$class['CourseID'];
				deleteGradedItem($con,$courseId);
				deleteGradingScale($con,$courseId);
				$sql = "DELETE FROM badgergrades.class WHERE CourseID = $courseId;";
				mysqli_query($con,$sql);
			}
		}
		
		function deleteGradedItem($con,$courseId){
			$sql = "SELECT GradedItemTypeID FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($gradedItemType = mysqli_fetch_array($result)){
				$gradedItemTypeId = (int)$gradedItemType['GradedItemTypeID'];
				deleteByItemType($con,$gradedItemTypeId);
			}
		}
		
		function deleteByItemType($con,$itemTypeId){
			$sql = "DELETE FROM badgergrades.graded_item_type WHERE GradedItemTypeID = $itemTypeId;";
			mysqli_query($con,$sql);
			$sql = "DELETE FROM badgergrades.graded_item WHERE GradedItemTypeID = $itemTypeId;";
			mysqli_query($con,$sql);
		}
		
		function deleteGradingScale($con,$courseId){
			$sql = "DELETE FROM badgergrades.grading_scale WHERE CourseID = $courseId;";
			mysqli_query($con,$sql);
		}
	?>
</body>
</html>