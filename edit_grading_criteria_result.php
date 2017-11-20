<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Grading Criteria - Result
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
		$inputGradedItemTypes = array();
		$additionalInputGradedItemTypes = array();
		$portionsOfGrade = array();
		if(isset($_POST['graded_item_type']) && !empty($_POST['graded_item_type']) && isset($_POST['portion_of_grade']) && !empty($_POST['portion_of_grade'])){
			if(isset($_POST['graded_item_type'])&&!empty($_POST['graded_item_type'])){
				$inputGradedItemTypes = $_POST['graded_item_type'];
			}
			if(isset($_POST['additional_graded_item_type'])&&!empty($_POST['additional_graded_item_type'])){
				$additionalInputGradedItemTypes = $_POST['additional_graded_item_type'];
			}
			if(isset($_POST['portion_of_grade'])&&!empty($_POST['portion_of_grade'])){
				$portionsOfGrade = $_POST['portion_of_grade'];
			}	
			$gradedItemTypes = array();
			$totalPercentage = 0.00;
			for($i=0; $i<count($portionsOfGrade); $i++){
				$percentage = floatval($portionsOfGrade[$i]);
				$totalPercentage += $percentage;
				if(isset($inputGradedItemTypes[$i])&&!empty($inputGradedItemTypes[$i])){
					$gradedItemTypes[$inputGradedItemTypes[$i]] = $percentage/100;
				}
			}
			$additionalGradedItemTypes = array();
			if((count($portionsOfGrade)-count($inputGradedItemTypes))!==0){
				$i = count($portionsOfGrade)-count($additionalInputGradedItemTypes);
				foreach($additionalInputGradedItemTypes as $additionalInputGradedItemType){
					$additionalGradedItemTypes[$additionalInputGradedItemType] = floatval($portionsOfGrade[$i])/100;
					$i++;
				}
			}
			if(!empty($gradedItemTypes) && $totalPercentage==100.00){
				$sql = "SELECT GradedItemTypeID FROM badgergrades.graded_item_type WHERE CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				$gradedItemTypeIds = array();
				while($row = mysqli_fetch_array($result)){
					$gradedItemTypeIds[] = (int)$row['GradedItemTypeID'];
				}
				$i = 0;
				foreach($gradedItemTypes as $gradedItemType=>$portionOfGrade){
					$sql = sprintf("UPDATE badgergrades.graded_item_type SET GradedItemType = '%s', PortionOfGrade = $portionOfGrade WHERE GradedItemTypeID = $gradedItemTypeIds[$i];", mysql_real_escape_string($gradedItemType));
					mysqli_query($con,$sql);
					$i++;
				}
				if(!empty($additionalInputGradedItemTypes)){	
					foreach($additionalGradedItemTypes as $additionalGradedItemType=>$portionOfGrade){
						$sql = sprintf("INSERT INTO badgergrades.graded_item_type(GradedItemType,PortionOfGrade,CourseID) VALUES ('%s',$portionOfGrade,$courseId);", mysql_real_escape_string($additionalGradedItemType));
						mysqli_query($con,$sql);
					}
				}
				echo "<h4>Your changes have been made successfully.</h4>";
				echo "<table border='1' style='width:750px'><tr><th>Item Type</th><th>Portion Of Grade</th><th>Course</th></tr>";
				$sql = "SELECT GradedItemType, PortionOfGrade, CourseCode FROM badgergrades.graded_item_type INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE graded_item_type.CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($item = mysqli_fetch_array($result)){
					echo "<tr><td>" . $item['GradedItemType'] . "</td><td>" . $item['PortionOfGrade']*100 . "%</td><td>" . $item['CourseCode'] . "</td></tr>";
				}
				echo "<input type=\"button\" value=\"Back to Edit Criteria\" onclick=\"location.href='edit_criteria.php'\"><input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Return to Home\" onclick=\"Home.php\">";
			}
			else{
				if($totalPercentage!==100.00){
					echo "<h4>ERROR:</h4><h5>Make sure that the \"Portion of Grade\" for all items adds up to 100%.</h5>";
					echo "<input type=\"button\" value=\"Back to Edit Grading Criteria\" onclick=\"location.href='edit_grading_criteria.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Return to Home\" onclick=\"Home.php\">";
				}
				else{
					echo "<h4>ERROR:</h4><h5>Please reenter your changes and try again.</h5>";
					echo "<input type=\"button\" value=\"Back to Edit Grading Criteria\" onclick=\"location.href='edit_grading_criteria.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Return to Home\" onclick=\"Home.php\">";
				}
			}
		}
		else{
			echo "<h4>ERROR:</h4><h5>Please reenter your changes and try again.</h5>";
			echo "<input type=\"button\" value=\"Back to Edit Grading Criteria\" onclick=\"location.href='edit_grading_criteria.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" value=\"Return to Home\" onclick=\"Home.php\">";
		}
	?>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>