<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Remove Existing Item Type - Result
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
	<br><br>
	<?php
		$gradedItemTypeIds = array();
		if(isset($_SESSION['gradedItemTypeIds']) && !empty($_SESSION['gradedItemTypeIds'])){
			$gradedItemTypeIds = $_SESSION['gradedItemTypeIds'];
		}
		$otherGradedItemTypeIds = array();
		if(isset($_SESSION['otherGradedItemTypeIds']) && !empty($_SESSION['otherGradedItemTypeIds'])){
			$otherGradedItemTypeIds = $_SESSION['otherGradedItemTypeIds'];
		}
		$portionsOfGrade = array();
		$totalPercentage = 0.00;
		if(isset($_POST['portion_of_grade']) && !empty($_POST['portion_of_grade'])){
			foreach($_POST['portion_of_grade'] as $portionOfGrade){
				$percentage = floatval($portionOfGrade);
				$totalPercentage += $percentage;
				$portionsOfGrade[] = $percentage/100;
			}
		}
		if(count($otherGradedItemTypeIds)==count($portionsOfGrade)){
			if($totalPercentage==100.00){
				$otherGradedItemTypes = array();
				for($i=0; $i<count($otherGradedItemTypeIds); $i++){
					$otherGradedItemTypes[strval($otherGradedItemTypeIds[$i])] = $portionsOfGrade[$i];
				}
				foreach($otherGradedItemTypes as $itemTypeId=>$portionOfGrade){
					$itemTypeId = (int)$itemTypeId;
					$sql = "UPDATE badgergrades.graded_item_type SET PortionOfGrade = $portionOfGrade WHERE GradedItemTypeID = $itemTypeId;";
					mysqli_query($con,$sql);
				}
				foreach($gradedItemTypeIds as $itemTypeId){
					$sql = "DELETE FROM badgergrades.graded_item_type WHERE GradedItemTypeID = $itemTypeId;";
					mysqli_query($con,$sql);
					$sql = "DELETE FROM badgergrades.graded_item WHERE GradedItemTypeID = $itemTypeId;";
					mysqli_query($con,$sql);
				}
				echo "<h4>Item type (and corresponding items) deleted successfully!</h4><h5>Here is the remaining criteria:</h5><table border='1' style='width:750px'><tr><th>Item Type</th><th>Portion of Grade</th></tr>";
				$sql = "SELECT GradedItemType, PortionOfGrade FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($itemType = mysqli_fetch_array($result)){
					echo "<tr><td>" . $itemType['GradedItemType'] . "</td><td>" . $itemType['PortionOfGrade']*100 . "%</td></tr>";
				}
				echo "</table>";
			}
			else{
				echo "<h4>ERROR:</h4><h5>Make sure that the grade proportions (percentage) for the remaining item types sum up to 100%.</h5>";
			}
		}
		else{
			echo "<h4>ERROR:</h4><h5>Make sure all fields are filled out when submitting criteria for remaining item types.</h5>";
		}
	?>
	<br><br>
	<input type="button" value="Back to Edit Criteria" onclick="location.href='edit_criteria.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Back to Course" onclick="location.href='course.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Return to Home" onclick="location.href='Home.php'">
	<br><br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>