<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>
		<?php
			session_start();
			$courseId = 0;
			if(isset($_POST['course']) && !empty($_POST['course'])){
				$courseId = (int)$_POST['course'];
				$_SESSION['courseId'] = $courseId;	
			}
			else{
				$courseId = (int)$_SESSION['courseId'];
			}
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
	<h1>
		<?php
			if(isset($_SESSION['semesterId']) && !empty($_SESSION['semesterId'])){
				echo "<input type=\"button\" value=\"Back to Semester Grades\" onclick=\"location.href='semester_grades.php'\"><br><br>";
			}
			else{
				if(isset($_SESSION['institutionId']) && !empty($_SESSION['institutionId'])){
					echo "<input type=\"button\" value=\"Back to Career Grades\" onclick=\"location.href='career_grades.php'\"><br><br>";
				}
			}
			$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['CourseCode'];
				break;
			}
		?>
	</h1>
	<h2>
		<?php
			$sql = "SELECT CourseName FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['CourseName'];
				break;
			}
		?>
	</h2>
	<h3><i>
		<?php
			$sql = "SELECT Institution, Semester FROM badgergrades.class INNER JOIN badgergrades.institution ON class.InstitutionID = institution.InstitutionID INNER JOIN badgergrades.semester ON class.SemesterID = semester.SemesterID WHERE class.CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['Institution'] . ", " . $class['Semester'];
			}
		?>
	</i></h3>
	<input type="button" value="Switch to different College/University" onclick="location.href='switch_institution.php'">&nbsp;
	<input type="button" value="Switch to different Semester" onclick="location.href='switch_semester.php'">
	<br><br>
	<h4>Credits: 
		<?php
			$sql = "SELECT Credits FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			$credits = 0.00;
			while($class = mysqli_fetch_array($result)){
				$credits = floatval($class['Credits']);
				break;
			}
			echo $credits;
		?>
	</h4>
	<p>Instructor(s): 
		<?php
			$sql = "SELECT Instructor FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			$instructor = "";
			while($class = mysqli_fetch_array($result)){
				if(!empty($class['Instructor'])){
					$instructor = $class['Instructor'];
					break;
				}
				else{
					$instructor = "N/A";
					break;
				}
			}
			echo $instructor;
		?>
	</p>
	<p>Schedule: 
		<?php
			$sql = "SELECT Schedule FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			$schedule = "";
			while($class = mysqli_fetch_array($result)){
				if(!empty($class['Schedule'])){
					$schedule = $class['Schedule'];	
					break;
				}
				else{
					$schedule = "N/A";
					break;
				}
			}
			echo $schedule;
		?>	
	</p>
	<input type="button" value="Edit Course Info" onclick="location.href='edit_course.php'">
	<br><br><br>
	<h2>Overall Grade:</h2><h1>
	<?php
		$sql = "SELECT GradedItemTypeID, PortionOfGrade FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
		$result = mysqli_query($con,$sql);
		$gradedItemTypeIds = array();
		while($itemType = mysqli_fetch_array($result)){
			$gradedItemTypeIds[$itemType['GradedItemTypeID']] = floatval($itemType['PortionOfGrade']);
		}
		
		$sql = "SELECT GradedItemTypeID, PortionOfGrade FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
		$result = mysqli_query($con,$sql);
		$gradedItemTypeIds = array();
		while($itemType = mysqli_fetch_array($result)){
			$gradedItemTypeIds[$itemType['GradedItemTypeID']] = floatval($itemType['PortionOfGrade']);
		}
			
		$sql = "SELECT GradedItem FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)!==0){
			$totalWeightedAverage = 0.00;
			$totalOfCategoryPortions = 0.00;
			$usedGradedItemTypes = array();
			foreach($gradedItemTypeIds as $gradedItemTypeId=>$portionOfGrade){
				$gradedItemTypeId = (int)$gradedItemTypeId;
				$gradedItemTypeUsed = false;
				$sql = "SELECT GradedItem, graded_item.GradedItemTypeID FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($item = mysqli_fetch_array($result)){
					if((int)$item['GradedItemTypeID'] == $gradedItemTypeId){
						$gradedItemTypeUsed = true;
						break;
					}
				}
				if($gradedItemTypeUsed){
					$usedGradedItemTypes[strval($gradedItemTypeId)] = $portionOfGrade;
				}
				$sql = "SELECT PointsEarned, PointsWorth FROM badgergrades.graded_item WHERE GradedItemTypeID = $gradedItemTypeId;";
				$result = mysqli_query($con,$sql);
				if(mysqli_num_rows($result)!==0){
					$totalPointsEarned = 0.00;
					$totalPointsWorth = 0.00;
					while($item = mysqli_fetch_array($result)){
						$totalPointsEarned += floatval($item['PointsEarned']);
						$totalPointsWorth += floatval($item['PointsWorth']);
					}
					$categoryAverage = $totalPointsEarned/$totalPointsWorth;
					$weightedAverage = $categoryAverage*$portionOfGrade;
					$totalWeightedAverage += $weightedAverage;
				}
			}
			foreach($usedGradedItemTypes as $gradedItemTypeId=>$portionOfGrade){
				$totalOfCategoryPortions += $portionOfGrade;
			}
			$weightedGrade = $totalWeightedAverage/$totalOfCategoryPortions;
			
			$sql = "SELECT LetterGrade, MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId ORDER BY LetterGrade;";
			$result = mysqli_query($con,$sql);
			$letterGrade = "";
			while($grade = mysqli_fetch_array($result)){
				if($weightedGrade>=$grade['MinimumGrade']){
					$letterGrade = $grade['LetterGrade'];
					break;
				}
			}
			if(empty($letterGrade)){
				$letterGrade = "F";
			}
			echo round($weightedGrade*100,2) . "% (" . $letterGrade . ")";
		}
		else{
			echo "N/A";
		}
	?></h1>
	<br>
	<input type="button" value="Add New Graded Item" onclick="location.href='add_new_graded_item.php'">
	<br><br>
	<form action="edit_graded_item.php" method="post">
		<label for 'item'>Edit Item/Grade:&nbsp;</label>
		<select name='item'>
			<option value=''>Select item to edit...</option>
			<?php
				$courseOrder = "";
				if(isset($_POST['course_order']) && !empty($_POST['course_order'])){
					$courseOrder = $_POST['course_order'];
				}
				else{
					$courseOrder = "Course Order";
				}
				$sql = "";
				switch($courseOrder){
					case "Course Order":
						$sql = "SELECT GradedItemID, GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.GradedItemID;";
						break;
					case "Due Date Latest First":
						$sql = "SELECT GradedItemID, GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.Date DESC;";
						break;
					case "Due Date Oldest First":
						$sql = "SELECT GradedItemID, GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.Date;";
						break;
					case "Alphabetical":
						$sql = "SELECT GradedItemID, GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.GradedItem;";
						break;
				}
				$result = mysqli_query($con, $sql);
				while($gradedItem = mysqli_fetch_array($result)){
					echo "<option value='" . $gradedItem['GradedItemID'] . "'>" . $gradedItem['GradedItem'] . "</option>";
				}
			?>
		</select>
		<br><input type="submit" value="Edit">&nbsp;&nbsp;<input type="button" value="Remove Item" onclick="location.href='remove_graded_item.php'">
	</form>
	<br>
	<form action="course.php" method="post">
		<label for 'course_order'>Order by:&nbsp;</label>
		<select name='course_order'>
			<option value='Course Order'>Course Order (default)</option>
			<option value='Due Date Latest First'>Due Date (Latest First)</option>
			<option value='Due Date Oldest First'>Due Date (Oldest First)</option>
			<option value='Alphabetical'>Alphabetical</option>
			<option value='Item Type'>Item Type</option>
		</select>&nbsp;
		<input type="submit" value="Order"><br>(currently in order by: 
		<?php
			echo $courseOrder;
		?>)
	</form><br>
	<table border='1' style='width:750px'>
		<tr><th>Item</th><th>Type</th><th>Date Submitted</th><th>Grade</th></tr>
		<?php
			$sql = "";
			switch($courseOrder){
				case "Course Order":
					$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.GradedItemID;";
					break;
				case "Due Date Latest First":
					$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.Date DESC;";
					break;
				case "Due Date Oldest First":
					$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.Date;";
					break;
				case "Alphabetical":
					$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY graded_item.GradedItem;";
					break;
				case "Item Type":
					$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId ORDER BY GradedItemType;";
					break;
			}
			$result = mysqli_query($con,$sql);
			while($gradedItem = mysqli_fetch_array($result)){
				echo "<tr><td>" . $gradedItem['GradedItem'] . "</td><td>" . $gradedItem['GradedItemType'] . "</td><td>" . $gradedItem['Date'] . "</td><td>" . $gradedItem['PointsEarned'] . "/" . $gradedItem['PointsWorth'] . "</td></tr>"; 
			}
		?>
	</table><br>
	<br><br>
	<h2>Grading Criteria</h2>
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
	<input type="button" value="Edit Criteria" onclick="location.href='edit_grading_criteria.php'"><br>
	<br><br>
	<h2>Grading Scale</h2>
	<table border='1' style='width:750px'>
		<tr><th>Letter Grade</th><th>Minimum Required</th></tr>
		<?php
			$sql = "SELECT LetterGrade, MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($grade = mysqli_fetch_array($result)){
				echo "<tr><td>" . $grade['LetterGrade'] . "</td><td>" . $grade['MinimumGrade'] * 100 . "%</td></tr>";
			}
		?>
	<tr><td>F</td><td>0%</td></tr></table><br>
	<input type="button" value="Edit Scale" onclick="location.href='edit_grading_scale.php'"><br>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>