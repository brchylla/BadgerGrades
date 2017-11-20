<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Grading Criteria - 
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
	<script type="text/javascript" src="add_textbox.js"></script>
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
	<form action="edit_grading_criteria_result.php" method="post">
		<p><b>Enter the grading criteria as outlined in the syllabus.*</b><br><b>Graded "item types" can include homework assignments, tests, labs, etc.*</b><br>You may leave some fields blank.</p>
		Graded Item Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Portion of Grade<br>
		<?php
			$sql = "SELECT GradedItemTypeID FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			$gradedItemTypeIds = array();
			while($gradedItemType = mysqli_fetch_array($result)){
				$gradedItemTypeIds[] = (int)$gradedItemType['GradedItemTypeID'];
			}
			foreach($gradedItemTypeIds as $gradedItemTypeId){
				$sql = "SELECT GradedItemType, PortionOfGrade FROM badgergrades.graded_item_type WHERE GradedItemTypeID = $gradedItemTypeId;";
				$result = mysqli_query($con,$sql);
				$gradedItemType = "";
				$portionOfGrade = 0.00;
				while($row = mysqli_fetch_array($result)){
					$gradedItemType = $row['GradedItemType'];
					$portionOfGrade = floatval($row['PortionOfGrade']);
				}
				echo "<input type=\"text\" id=\"graded_item_type\" name=\"graded_item_type[]\" value=\"$gradedItemType\" placeholder=\"$gradedItemType\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"portion_of_grade\" name=\"portion_of_grade[]\" value=\"" . $portionOfGrade*100 . "\" placeholder=\"" . $portionOfGrade*100 . "\">%<br>";
			}
		?>
		<!--
		<input type="text" name="graded_item_type1" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade1" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type2" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade2" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type3" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade3" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type4" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade4" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type5" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade5" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type6" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade6" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type7" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade7" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type8" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade8" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type9" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade9" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type10" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade10" id="portion_of_grade">%<br>
		-->
		<div id="content" ></div>
		<br>
		<input type="button" value="Add Additional Item Type" onclick="addElement()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel Additional Item Type" onclick="removeElement()">
		<br><br>
		<input type="button" value="Remove Existing Item Type" onclick="location.href='remove_existing_item_type.php'">
		<br><br><br>
		<input type="submit" value="Change Criteria" style="height:48px; width:120px; font-weight: bold;">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>