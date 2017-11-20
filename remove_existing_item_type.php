<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Remove Existing Item Type - 
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
	<input type="button" value="Back to Edit Criteria" onclick="location.href='edit_grading_criteria.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br><br>
	<h4>WARNING:</h4><h5>Removing a graded item type will also remove all graded items under this type in the class.</h5>
	<form action="remove_existing_item_type_reset_criteria.php" method="post">
		<label for 'graded_item_type[]'>Select the item type(s) that you would like to delete:&nbsp;</label>
		<select name='graded_item_type[]' multiple='multiple'>
			<?php
				$sql = "SELECT GradedItemTypeID, GradedItemType FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($itemType = mysqli_fetch_array($result)){
					echo "<option value='" . $itemType['GradedItemTypeID'] . "'>" . $itemType['GradedItemType'] . "</option>";
				}
			?>
		</select><br><br><input type="submit" value="Continue to Delete Type">
	</form><br><br>
	<table border='1' style='width:750px'>
		<tr><th>Graded Item Type</th><th>Portion of Grade</th></tr>
		<?php
			$sql = "SELECT GradedItemType, PortionOfGrade FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
			$result = mysqli_query($con, $sql);
			while($gradedItemType = mysqli_fetch_array($result)){
				echo "<tr><td>" . $gradedItemType['GradedItemType'] . "</td><td>" . $gradedItemType['PortionOfGrade']*100 . "%</td></tr>";
			}
		?>
	</table><br>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>