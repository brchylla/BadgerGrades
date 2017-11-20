<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>
		Add New Graded Item - Result 
		<?php
			if(isset($_POST['item_name']) && !empty($_POST['item_name'])){
				echo "(" . $_POST['item_name'] . ")";
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
		session_start();
		$courseId = (int)$_SESSION['courseId'];
		$gradedItemTypeId = 0;
		if(!empty($_POST['item_type'])){
			$gradedItemTypeId = (int)$_POST['item_type'];
		}
		$gradedItemName = "";
		if(isset($_POST['item_name']) && !empty($_POST['item_name'])){
			$gradedItemName = $_POST['item_name'];
		}
		$pointsEarned = 0.00;
		$pointsWorth = 0.00;
		if(isset($_POST['points_earned']) && isset($_POST['points_worth']) && !empty($_POST['points_worth'])){
			$pointsEarned = floatval($_POST['points_earned']);
			$pointsWorth = floatval($_POST['points_worth']);
		}
		else{
			if(isset($_POST['letter_grade']) && !empty($_POST['letter_grade']) && isset($_POST['points_worth_scaled']) && !empty($_POST['points_worth_scaled'])){
				$pointsWorth = floatval($_POST['points_worth_scaled']);
				$pointsEarned = (getPointsByLetterGrade($_POST['letter_grade'],$courseId)/100)*$pointsWorth;
			}
		}
		$date = "";
		if(isset($_POST['date']) && !empty($_POST['date'])){
			$date = $_POST['date'];
		}
		
		if(!empty($gradedItemTypeId) && !empty($gradedItemName) && !empty($pointsWorth)){
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = sprintf("SELECT graded_item.GradedItem, graded_item_type.GradedItemTypeID FROM badgergrades.graded_item INNER JOIN badgergrades.graded_item_type ON graded_item.GradedItemTypeID = graded_item_type.GradedItemTypeID WHERE graded_item_type.CourseID = $courseId AND graded_item_type.GradedItemTypeID = $gradedItemTypeId AND graded_item.GradedItem = '%s';", mysql_real_escape_string($gradedItemName));
			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result)==0 && $pointsWorth!==0){
				if(!empty($date)){
					$sql = sprintf("INSERT INTO badgergrades.graded_item(GradedItem, PointsEarned, PointsWorth, GradedItemTypeID, Date) VALUES('%s',$pointsEarned,$pointsWorth,$gradedItemTypeId,'%s');",mysql_real_escape_string($gradedItemName),mysql_real_escape_string($date));
				}
				else{
					$sql = sprintf("INSERT INTO badgergrades.graded_item(GradedItem, PointsEarned, PointsWorth, GradedItemTypeID) VALUES('%s',$pointsEarned,$pointsWorth,$gradedItemTypeId);",mysql_real_escape_string($gradedItemName));
				}
				mysqli_query($con,$sql);
				
				$sql = sprintf("SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, CourseCode, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE class.CourseID = $courseId AND graded_item_type.GradedItemTypeID = $gradedItemTypeId AND graded_item.GradedItem = '%s' ORDER BY graded_item.GradedItemID;", mysql_real_escape_string($gradedItemName));
				$result = mysqli_query($con,$sql);
				if(mysqli_num_rows($result)!==0){
					echo "<h4>New graded item successfully added!</h4>";
					echo "<table border='1' style='width:750px'><tr><th>Item</th><th>Grade</th><th>Type</th><th>Course</th><th>Date</th></tr>";
					$result = mysqli_query($con,$sql);
					while($course = mysqli_fetch_array($result)){
						echo "<tr><td>" . $course['GradedItem'] . "</td><td>" . $course['PointsEarned'] . "/" . $course['PointsWorth'] . "</td><td>" . $course['GradedItemType'] . "</td><td>" . $course['CourseCode'] . "</td><td>" . $course['Date'] . "</td></tr>";
					}
					echo "</table><br><br>";
					echo "<input type=\"button\" value=\"Add Another Graded Item\" onclick=\"location.href='add_new_graded_item.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Return to Home' onclick='location.href=\'Home.php\''><br><br>";
				}
				else{
					echo "<h4>UNKNOWN ERROR:</h4><h5>The item was not entered into the database. For support, send questions to brchylla@wisc.edu.</h5>";
					echo "<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Return to Home' onclick='location.href=\'Home.php\''><br><br>";
				}	
			}
			else{
				if($pointsWorth==0){
					echo "<h4>ERROR:</h4><h5>The item must be worth more than 0 points.</h5>";
					echo "<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Return to Home' onclick='location.href=\'Home.php\''><br><br>";
				}
				else{
					echo "<h4>ERROR:</h4><h5>You have already entered this item.</h5>";
					echo "<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Return to Home' onclick='location.href=\'Home.php\''><br><br>";
				}
			}
		}
		else{
			echo "<h4>ERROR:</h4>";
			if(empty($gradedItemTypeId)){
				echo "<h5>You must select the item type.</h5>";
			}
			if(empty($gradedItemName)){
				echo "<h5>You must input the item name.</h5>";
			}
			if(empty($pointsWorth)){
				echo "<h5>You must enter how well you scored or the grade that you receive.</h5>";
			}
			echo "<input type=\"button\" value=\"Back to 'Add Graded Item'\" onclick=\"location.href='add_new_graded_item.result.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Return to Home' onclick='location.href=\'Home.php\''><br><br>";
		}
		
		function getPointsByLetterGrade($letterGrade,$courseId){
			$con = mysqli_connect("localhost","root","","badgergrades");	
			$pointsEarned = 0.00;	
			if($letterGrade == "A"){
				$pointsEarned = 99.99;
			}
			else{
				if(!(strcmp($letterGrade,"F")==0)){
					$letterGradesSql = "SELECT LetterGradeRangeID, LetterGrade, MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId;";
					//echo $sql . "<br>";
					$letterGradesResult = mysqli_query($con,$letterGradesSql);
					while($grade = mysqli_fetch_array($letterGradesResult)){
						if(strcmp($letterGrade,$grade['LetterGrade'])==0){
							$letterGradeRangeId = (int)$grade['LetterGradeRangeID'] - 1;
							$higherGradeSql = "SELECT MinimumGrade FROM badgergrades.grading_scale WHERE LetterGradeRangeID = $letterGradeRangeId;";
							//echo $higherGradeSql;
							$higherGradeResult = mysqli_query($con,$higherGradeSql);
							while($higherGrade = mysqli_fetch_array($higherGradeResult)){
								$pointsEarned = (floatval($higherGrade['MinimumGrade'])*100) - 0.01;
							}
						}
					}
				}
				else{
					$sql = "SELECT MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId AND LetterGrade = 'D';";
					$result = mysqli_query($con,$sql);
					while($grade = mysqli_fetch_array($result)){
						$pointsEarned = (floatval($grade['MinimumGrade'])*100) - 0.01;
						break;
					}
				}
			}
			return $pointsEarned;			
		}
	?>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>