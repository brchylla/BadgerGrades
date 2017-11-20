<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>
		Edit Graded Item - Result 
		<?php
			session_start();
			$courseId = $_SESSION['courseId'];
			$gradedItemId = $_SESSION['gradedItemId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT GradedItem FROM badgergrades.graded_item WHERE GradedItemID = $gradedItemId;";
			$result = mysqli_query($con,$sql);
			$gradedItemName = "";
			while($item = mysqli_query($result)){
				$gradedItemName = $item['GradedItem'];
				break;
			}
			echo $gradedItemName;
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
		$newGradedItemName = "";
		if(isset($_POST['item_name']) && !empty($_POST['item_name'])){
			$newGradedItemName = $_POST['item_name'];
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
		$gradedItemTypeId = 0;
		if(isset($_POST['item_type']) && !empty($_POST['item_type'])){
			$gradedItemTypeId = (int)$_POST['item_type'];
		}
		$date = "";
		if(isset($_POST['date']) && !empty($_POST['date'])){
			$date = $_POST['date'];
		}
		
		if(!empty($gradedItemId) && !empty($newGradedItemName) && !empty($pointsWorth) && !empty($gradedItemTypeId)){
			$sql = "";
			if(!empty($date)){
				$sql = sprintf("UPDATE badgergrades.graded_item SET GradedItem = '%s', PointsEarned = $pointsEarned, PointsWorth = $pointsWorth, GradedItemTypeID = $gradedItemTypeId, Date = '$date' WHERE GradedItemID = $gradedItemId;", mysql_real_escape_string($newGradedItemName));
			}
			else{
				$sql = sprintf("UPDATE badgergrades.graded_item SET GradedItem = '%s', PointsEarned = $pointsEarned, PointsWorth = $pointsWorth, GradedItemTypeID = $gradedItemTypeId WHERE GradedItemID = $gradedItemId;", mysql_real_escape_string($newGradedItemName));
			}
			mysqli_query($con,$sql);
			echo "<h4>Item successfully updated!</h4>";
			echo "<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Return to Home\" onclick=\"Home.php\"><br><br>";
			echo "<table border='1' style='width:750px'><tr><th>Item</th><th>Type</th><th>Score</th><th>Date</th><th>Course</th></tr>";
			$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemType, CourseCode, Date FROM badgergrades.graded_item_type INNER JOIN badgergrades.graded_item ON graded_item_type.GradedItemTypeID = graded_item.GradedItemTypeID INNER JOIN badgergrades.class ON graded_item_type.CourseID = class.CourseID WHERE graded_item.GradedItemID = $gradedItemId;";
			$result = mysqli_query($con,$sql);
			while($item = mysqli_fetch_array($result)){
				echo "<tr><td>" . $item['GradedItem'] . "</td><td>" . $item['GradedItemType'] . "</td><td>" . $item['PointsEarned'] . "/" . $item['PointsWorth'] . "</td><td>" . $item['Date'] . "</td><td>" . $item['CourseCode'] . "</td></tr>";
			}
			echo "</table>";
		}
		else{
			echo "<h4>ERROR:</h4>";
			if(empty($gradedItemTypeId)){
				echo "<h5>You must select the item type.</h5>";
			}
			if(empty($newGradedItemName)){
				echo "<h5>You must enter the new name for the item.</h5>";
			}
			if(empty($pointsWorth)){
				echo "<h5>You must enter the number of points that the item is worth.</h5>";
			}
			echo "<input type=\"button\" value=\"Back to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Return to Home\" onclick=\"Home.php\"><br><br>";
		}
		
		function getPointsByLetterGrade($letterGrade,$courseId){
			$con = mysqli_connect("localhost","root","","badgergrades");	
			$pointsEarned = 0.00;	
			if($letterGrade == "A"){
				$pointsEarned = 100.00;
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
								break;
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