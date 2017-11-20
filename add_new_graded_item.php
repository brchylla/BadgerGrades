<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<script type="text/javascript" src="assign_grade.js"></script>
	<title>New Item - 
		<?php
			session_start();
			$courseId = $_SESSION['courseId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con, $sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['CourseCode'];
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
	<h1>New Item - 
		<?php
			$courseId = $_SESSION['courseId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con, $sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['CourseCode'];
			}
		?>	
	</h1>
	<form action="add_new_graded_item_result.php" method="post">
		<label for 'item_type'><b>Select the type of item being graded*:</b>&nbsp;</label>
		<select name='item_type'>
			<option value=''>Select the type...</option>
			<?php
				$sql = "SELECT GradedItemTypeID, GradedItemType FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($gradedItemType = mysqli_fetch_array($result)){
					echo "<option value='" . $gradedItemType['GradedItemTypeID'] . "'>" . $gradedItemType['GradedItemType'] . "</option>";
				}
			?>
		</select><br><br>
		<label for 'item_name'><b>Enter the name of the assignment, test, lab, etc. being graded*:</b>&nbsp;</label>
		<input type="text" name="item_name" id="item_name"><br><br>
		
		<label for 'grade type'>Is the grade scaled (based on your classmates' performances)?</label>
		<select name="grade type" id="target">
			<option value="">Select...</option>
			<option value="points">No</option>
			<option value="letter">Yes</option>
		</select><br><br>
		
		<div id="points" class="inv">
			<label for 'points_earned'><b>How many points did you earn?*</b>&nbsp;</label><input type="text" name="points_earned"><br><br>
			<label for 'points_worth'><b>How many points was it worth?*</b>&nbsp;</label><input type="text" name="points_worth"><br><br>
		</div>
		
		<div id="letter" class="inv">
			<label for 'letter_grade' id='letter'><b>Which letter grade did you receive?</b>&nbsp;</label>
			<select name="letter_grade" id="letter">
				<option value="">Select...</option>
				<option value="A">A</option>
				<option value="AB">AB</option>
				<option value="B">B</option>
				<option value="BC">BC</option>
				<option value="C">C</option>
				<option value="CD">CD</option>
				<option value="D">D</option>
				<option value="F">F</option>
			</select><br><br>
			<label for 'points_worth_scaled' id='letter'><b>How many points was it worth?</b>&nbsp;</label>
			<input type="text" name="points_worth_scaled" id="letter"><br><br>
		</div>
		
		<script>
            document
                .getElementById('target')
                .addEventListener('change', function () {
                    'use strict';
                    var vis = document.querySelector('.vis'),   
                        target = document.getElementById(this.value);
                    if (vis !== null) {
                        vis.className = 'inv';
                    }
                    if (target !== null ) {
                        target.className = 'vis';
                    }
            });
        </script>
		
		<label for 'date'><b>Enter the date on which you received the grade (YYYY-MM-DD)*:&nbsp;</b></label>
		<input type="text" name="date" id="date"><br><br>
		<p style="font-size:8">Note: Unless you received extra credit, the number of points earned on an assignment, test, lab, etc. should not be greater than the number of points that it's worth.</p><br>
		<input type="submit" value="Add Grade" style="height:48px; width:120px; font-weight: bold;">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>