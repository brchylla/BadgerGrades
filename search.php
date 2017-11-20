<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Search - "<?php echo $_POST['search']; ?>"</title>
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
		session_start();
		session_unset();
		$con = mysqli_connect("localhost","root","","badgergrades");
		$search = "";
		if(isset($_POST['search']) && !empty($_POST['search'])){
			$search = mysql_real_escape_string($_POST['search']);
		}
		$courseResults = array();
		$courseCodeResults = searchByCourseCode($con, $search);
		if(!empty($courseCodeResults)){
			foreach($courseCodeResults as $courseId=>$courseCode){
				$courseResults[$courseId] = $courseCode;
			}
		}
		$courseNameResults = searchByCourseName($con,$search);
		if(!empty($courseNameResults)){
			foreach($courseNameResults as $courseId=>$courseCode){
				$courseResults[$courseId] = $courseCode;
			}
		}
		$instructorResults = searchByInstructor($con,$search);
		if(!empty($instructorResults)){
			foreach($instructorResults as $courseId=>$courseCode){
				$courseResults[$courseId] = $courseCode;
			}
		}
		
		function searchByCourseCode($con,$search){
			$sql = "SELECT CourseID, CourseCode FROM badgergrades.class WHERE CourseCode LIKE '%" . $search . "%';";
			$result = mysqli_query($con,$sql);
			$courseResults = array();
			while($class = mysqli_fetch_array($result)){
				$courseResults[strval($class['CourseID'])] = $class['CourseCode'];
			}
			return $courseResults;
		}
				
		function searchByCourseName($con,$search){
			$sql = "SELECT CourseID, CourseCode FROM badgergrades.class WHERE CourseName LIKE '%" . $search . "%';";
			$result = mysqli_query($con,$sql);
			$courseResults = array();
			while($class = mysqli_fetch_array($result)){
				$courseResults[strval($class['CourseID'])] = $class['CourseCode'];
			}
			return $courseResults;
		}
				
		function searchByInstructor($con,$search){
			$sql = "SELECT CourseID, CourseCode FROM badgergrades.class WHERE Instructor LIKE '%" . $search . "%';";
			$result = mysqli_query($con,$sql);
			$courseResults = array();
			while($class = mysqli_fetch_array($result)){
				$courseResults[strval($class['CourseID'])] = $class['CourseCode'];
			}
			return $courseResults;
		}
	?>
	<h2><?php echo count($courseResults); ?> result<?php if(count($courseResults)!==1){echo "s";} ?> for "<?php echo $_POST['search']; ?>"</h2>
	<form action="course.php" method="post">
		<label for 'course'>Select a course:&nbsp;</label>
		<select name="course">
			<option value=''>Select a course...</option>
			<?php
				if(!empty($courseResults)){
					foreach($courseResults as $courseId=>$courseCode){
						echo "<option value='" . $courseId . "'>" . $courseCode . "</option>";
					}
				}
			?>
		</select>
		<input type="submit" value="Go to Course">
	</form><br><br>
	<?php
		if(!empty($courseResults)){
			echo "<table border='1' style='width:750px'><tr><th>Course</th><th>Title</th><th>Instructor(s)</th><th>Grade</th><th>Credits</th></tr>";
			foreach($courseResults as $courseId=>$courseCode){
				$courseId = (int)$courseId;
				$sql = "SELECT CourseCode, CourseName, Instructor, Credits FROM badgergrades.class WHERE CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($class = mysqli_fetch_array($result)){
					$letterGrade = getFinalGrade($con,$courseId);
					echo "<tr><td>" . $class['CourseCode'] . "</td><td>" . $class['CourseName'] . "</td><td>" . $class['Instructor'] . "</td><td>" . $letterGrade . "</td><td>" .  $class['Credits'] . "</td></tr>";		
				}
			}
			echo "</table>";
		}
		else{
			echo "<h3>No results found.</h3>";
		}
		
		function getFinalGrade($con,$courseId){
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
				return $letterGrade;
			}
			else{
				return "N/A";
			}
		}
	?>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>