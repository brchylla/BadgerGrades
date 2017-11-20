<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Remove Existing Criteria - Reset Criteria
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
	<input type="button" value="Back to Edit Criteria" onclick="location.href='edit_grading_criteria.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br><br>
	<?php
		$gradedItemTypeIds = array();
		$_SESSION['gradedItemTypeIds'] = array();
		$_SESSION['otherGradedItemTypeIds'] = array();
		if(isset($_POST['graded_item_type']) && !empty($_POST['graded_item_type'])){
			foreach($_POST['graded_item_type'] as $gradedItemTypeId){
				$gradedItemTypeIds[] = (int)$gradedItemTypeId;
			}
		}
		if(!empty($gradedItemTypeIds)){
			$_SESSION['gradedItemTypeIds'] = $gradedItemTypeIds;
			$sql = "SELECT GradedItemTypeID, GradedItemType FROM badgergrades.graded_item_type WHERE CourseID = $courseId";
			foreach($gradedItemTypeIds as $gradedItemTypeId){
				$sql .= " AND GradedItemTypeID != $gradedItemTypeId";
			}
			$sql .= ";";
			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result)!==0){
				echo "<h4>Reenter the criteria for the remaining item types.</h4><form action=\"remove_existing_item_type_result.php\" method=\"post\">Portions of Grade:<br><br>";
				while($itemType = mysqli_fetch_array($result)){
					array_push($_SESSION['otherGradedItemTypeIds'],(int)$itemType['GradedItemTypeID']);
					echo $itemType['GradedItemType'] . ":&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" name=\"portion_of_grade[]\" id=\"portion_of_grade\">%<br><br>";
				}
				echo "<input type=\"submit\" value=\"Finish\" style=\"height:48px; width:120px; font-weight: bold;\"></form>";
			}
			else{
				echo "<h4>ERROR:</h4><h5>You are not allowed to delete all of the existing item types.<br><br><u>Hint:</u> You may add a new item type, then delete the remainder.</h5>";
			}
		}
		else{
			echo "<h4>ERROR:</h4><h5>You have not selected any graded item types to delete.</h5>";
		}
	?>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>