<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<?php
		session_start();
		$institutionId = 0;
		if(isset($_POST['institution']) && !empty($_POST['institution'])){
			$institutionId = (int)$_POST['institution'];
			if(isset($_SESSION['institutionId']) && !empty($_SESSION['institutionId'])){
				session_unset($_SESSION['institutionId']);
			}
		}
		if(isset($_SESSION['institutionId']) && !empty($_SESSION['institutionId'])){
			$institutionId = $_SESSION['institutionId'];
		}
		else{
			if(!empty($institutionId)){
				$_SESSION['institutionId'] = $institutionId;
			}
		}
		if(isset($_SESSION['semesterId'])){
			session_unset($_SESSION['semesterId']);
		}
		$con = mysqli_connect("localhost","root","","badgergrades");
		$sql = "SELECT Institution FROM badgergrades.institution WHERE InstitutionID = $institutionId;";
		$result = mysqli_query($con,$sql);
		$institutionName = "";
		while($institution = mysqli_fetch_array($result)){
			$institutionName = $institution['Institution'];
			break;
		}
	?>
	<title>Career Grades - <?php echo $institutionName; ?></title>
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
	<h2 style="color:red"><?php echo $institutionName; ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Edit Institution" onclick="location.href='edit_institution.php'" style="height:25px; width:100px"></h2>
	<form action="course.php" method="post">
		<label for 'course'>Select a course to update the grade:&nbsp;&nbsp;</label>
		<select name='course'>
			<option value=''>Select a course...</option>
			<?php
				$sql = "SELECT CourseID, CourseCode FROM badgergrades.class WHERE class.InstitutionID = $institutionId ORDER BY CourseCode;";
				$result = mysqli_query($con,$sql);
				while($class = mysqli_fetch_array($result)){
					echo "<option value='" . $class['CourseID'] . "'>" . $class['CourseCode'] . "</option>";
				}
			?>
		</select>
		<input type="submit" value="Go to Course">&nbsp;&nbsp;<input type="button" value="Delete Course" onclick="location.href='remove_course.php'">
	</form><br>
	(Scroll down for GPA...)
	<br><br>
	<?php
		$semesterSql = "SELECT semester.SemesterID, Semester FROM badgergrades.semester INNER JOIN badgergrades.class ON semester.SemesterID = class.SemesterID WHERE InstitutionID = $institutionId GROUP BY class.SemesterID ORDER BY class.SemesterID DESC;";
		$semesterResult = mysqli_query($con,$semesterSql);
		$totalCredits = 0.00;
		$totalQualityPoints = 0.00;
		$gpaAvailable = false;
		while($semester = mysqli_fetch_array($semesterResult)){
			$semesterId = (int)$semester['SemesterID'];
			echo "<h4>" . $semester['Semester'] . "</h4>";
			echo "<table border='1' style='width:750px'><tr><th>Course</th><th>Title</th><th>Grade</th><th>Credits</th><th>Quality Points</th></tr>";	
			$courseSql = "SELECT CourseID, CourseCode, CourseName, Credits FROM badgergrades.class WHERE InstitutionID = $institutionId AND SemesterID = $semesterId ORDER BY CourseCode;";
			$courseResult = mysqli_query($con,$courseSql);
			while($class = mysqli_fetch_array($courseResult)){
				$finalGrade = getFinalGrade($con,(int)$class['CourseID']);
				if(strcmp($finalGrade, "N/A")==0){
					echo "<tr><td>" . $class['CourseCode'] . "</td><td>" . $class['CourseName'] . "</td><td>" . $finalGrade . "</td><td>" . $class['Credits'] . "</td><td>" . "N/A" . "</td></tr>";
				}
				else{
					$gpaAvailable = true;
					$credits = floatval($class['Credits']);
					$totalCredits += $credits;
					$qualityPoints = getQualityPoints($con,$finalGrade,$credits);
					$totalQualityPoints += $qualityPoints;
					echo "<tr><td>" . $class['CourseCode'] . "</td><td>" . $class['CourseName'] . "</td><td>" . $finalGrade . "</td><td>" . $class['Credits'] . "</td><td>" . $qualityPoints . "</td></tr>";
				}
			}
			echo "</table>";
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
		
		function getQualityPoints($con,$finalGrade,$credits){
			$qualityPoints = 0.00;
			switch($finalGrade){
				case "A":
					$qualityPoints = $credits * 4.00;
					break;
				case "AB":
					$qualityPoints = $credits * 3.50;
					break;
				case "B":
					$qualityPoints = $credits * 3.00;
					break;
				case "BC":
					$qualityPoints = $credits * 2.50;
					break;
				case "C":
					$qualityPoints = $credits * 2.00;
					break;
				case "CD":
					$qualityPoints = $credits * 1.50;
					break;
				case "D":
					$qualityPoints = $credits * 1.00;
					break;
				case "F":
					$qualityPoints = $credits * 0.00;
					break;
			}
			return $qualityPoints;
		}
	?>
	<br>
	<h2>
		<?php
			if($totalCredits!==0.00){
				echo "<p><b>Your GPA at this institution is: <font style=\"color:red\">" . round($totalQualityPoints/$totalCredits,3) . "</font></b></p>";
			}
			else{
				if(!($gpaAvailable)){
					echo "<p><b>Your GPA is not yet available.</b></p>";
				}
				else{
					echo "<p><b>You have not yet added any courses for this semester.</b></p>";
				}
			}
		?>
	</h2>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>