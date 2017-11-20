<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>
		Add Course - Result 
		<?php
			if(isset($_POST['course_code']) && !empty($_POST['course_code'])){
				echo "(" . $_POST['course_code'] . ")";
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
		$institutionId = 0;
		$semesterId = 0;
		$courseCode = "";
		$courseName = "";
		$days = array();
		$startingLectureTime = "";
		$endingLectureTime = "";
		$discussionDays = array();
		$startingLabOrDiscussionTime = "";
		$endingLabOrDiscussionTime = "";
		$instructor = "";
		$credits = 0.00;
		if(!empty($_POST['institution'])){
			$institutionId = (int)$_POST['institution'];
		}
		if(!empty($_POST['semester'])){
			$semesterId = (int)$_POST['semester'];
		}
		if(isset($_POST['course_code']) && !empty($_POST['course_code'])){
			$courseCode = $_POST['course_code'];
		}
		if(isset($_POST['course_name']) && !empty($_POST['course_name'])){
			$courseName = $_POST['course_name'];
		}
		if(isset($_POST['day'])){
			$days = $_POST['day'];
		}
		if(!empty($_POST['starting_lecture_time'])){
			$startingLectureTime = $_POST['starting_lecture_time'];
		}
		if(!empty($_POST['ending_lecture_time'])){
			$endingLectureTime = $_POST['ending_lecture_time'];
		}
		if(isset($_POST['discussion_day'])){
			$discussionDays = $_POST['discussion_day'];
		}
		if(!empty($_POST['starting_lab_or_discussion_time'])){
			$startingLabOrDiscussionTime = $_POST['starting_lab_or_discussion_time'];	
		}
		if(!empty($_POST['ending_lab_or_discussion_time'])){
			$endingLabOrDiscussionTime = $_POST['ending_lab_or_discussion_time'];	
		}
		if(isset($_POST['instructor']) && !empty($_POST['instructor'])){
			$instructor = $_POST['instructor'];	
		}
		if(!empty($_POST['credits'])){
			$credits = floatval($_POST['credits']);	
		}
		
		$gradedItemTypes = array();
		$totalPercentage = 0.00;
		for($i=1; $i<=10; $i++){
			$gradedItemType = "graded_item_type" . $i;
			$portionOfGrade = "portion_of_grade" . $i;
			if(isset($_POST[$portionOfGrade]) && !empty($_POST[$portionOfGrade]) && isset($_POST[$gradedItemType]) && !empty($_POST[$gradedItemType])){
				$percentage = floatval($_POST[$portionOfGrade]);
				$totalPercentage += $percentage;
				$gradedItemTypes[$_POST[$gradedItemType]] = $percentage/100;
			}
		}
		
		$gradingScale = array();
		$letterGrades = array("A","AB","B","BC","C","CD","D");
		foreach($letterGrades as $letterGrade){
			$minimumPercentage = "grade_" . $letterGrade;
			if($_POST[$minimumPercentage]!=""){
				$percentage = floatval($_POST[$minimumPercentage]);
				$gradingScale[$letterGrade] = $percentage/100;
			}
		}
		$gradingScaleValid = true;
		$gradeKeys = array_keys($gradingScale);
		for($i=1; $i<count($gradingScale); $i++){
			if($gradingScale[$gradeKeys[$i]]>=$gradingScale[$gradeKeys[$i-1]]){
				$gradingScaleValid = false;
				break;
			}
		}
		
		/*echo $institutionId + 1 . "<br>";
		echo $semesterId + 1 . "<br>";
		echo $courseCode . "<br>";
		echo $courseName . "<br>";
		print_r(array_values($days));
		echo $startingLectureTime . "<br>";
		echo $endingLectureTime . "<br>";
		echo $startingLabOrDiscussionTime . "<br>";
		echo $endingLabOrDiscussionTime . "<br>";
		echo $instructor . "<br>";
		echo $credits + 1 . "<br>";
		print_r(array_values($gradedItemTypes));
		print_r(array_values($gradingScale));*/
		
		if(!empty($institutionId) && !empty($semesterId) && !empty($courseCode) && !empty($courseName) && !empty($credits) && !empty($gradedItemTypes) && $totalPercentage==100.00 && count($gradingScale)==7 && $gradingScaleValid){
			$con = mysqli_connect("localhost", "root", "", "badgergrades");
			$sql = sprintf("INSERT INTO badgergrades.class(CourseCode, CourseName, Schedule, Instructor, SemesterID, Credits, InstitutionID) VALUES ('%s','%s', '", mysql_real_escape_string($courseCode), mysql_real_escape_string($courseName));
			if(!empty($days)){
				foreach($days as $day){
					switch($day){
						case "Monday":
							$sql .= "Mo";
							break;
						case "Tuesday":
							$sql .= "Tu";
							break;
						case "Wednesday":
							$sql .= "We";
							break;
						case "Thursday":
							$sql .= "Th";
							break;
						case "Friday":
							$sql .= "Fr";
							break;
						case "Saturday":
							$sql .= "Sa";
							break;
						case "Sunday":
							$sql .= "Su";
							break;
					}
				}
				$sql .= " ";
				if(!empty($startingLectureTime) && !empty($endingLectureTime)){
					$sql .= $startingLectureTime . "-" . $endingLectureTime;
				}	
			}
			if(!empty($discussionDays)){
				$sql .= ", ";
				foreach($discussionDays as $day){
					switch($day){
						case "Monday":
							$sql .= "Mo";
							break;
						case "Tuesday":
							$sql .= "Tu";
							break;
						case "Wednesday":
							$sql .= "We";
							break;
						case "Thursday":
							$sql .= "Th";
							break;
						case "Friday":
							$sql .= "Fr";
							break;
						case "Saturday":
							$sql .= "Sa";
							break;
						case "Sunday":
							$sql .= "Su";
							break;
					}
				$sql .= " ";
				}
				if(!empty($startingLabOrDiscussionTime) && !empty($endingLabOrDiscussionTime)){
					$sql .= $startingLabOrDiscussionTime . "-" . $endingLabOrDiscussionTime;
				}	
			}
			$sql .= "','";
			if(!empty($instructor)){
				$sql .= $instructor;
			}
			$sql .= "'," . $semesterId . "," . $credits . "," . $institutionId . ");";
			$sqlCheck = sprintf("SELECT CourseCode FROM badgergrades.class INNER JOIN badgergrades.semester ON semester.SemesterID = class.SemesterID WHERE CourseCode = '%s' AND class.SemesterID = $semesterId AND class.InstitutionID = $institutionId;", mysql_real_escape_string($courseCode));
			$result = mysqli_query($con, $sqlCheck);
			if(mysqli_num_rows($result)==0){
				mysqli_query($con,$sql);
			
				$sql = sprintf("SELECT CourseID FROM badgergrades.class WHERE CourseCode = '%s';", mysql_real_escape_string($courseCode));
				$result = mysqli_query($con, $sql);
				$courseId = 0;
				while($course = mysqli_fetch_array($result)){
					$courseId = (int)$course['CourseID'];
					break;
				}
				
				foreach($gradedItemTypes as $gradedItemType=>$portionOfGrade){
					$sql = sprintf("INSERT INTO badgergrades.graded_item_type(GradedItemType,PortionOfGrade,CourseID) VALUES ('%s',$portionOfGrade,$courseId);", mysql_real_escape_string($gradedItemType));
					mysqli_query($con,$sql);
				}
				
				foreach($gradingScale as $letterGrade=>$minimumPercentage){
					$sql = "INSERT INTO badgergrades.grading_scale(LetterGrade,MinimumGrade,CourseID) VALUES ('$letterGrade',$minimumPercentage,$courseId);";
					mysqli_query($con,$sql);
				}
				
				$_SESSION['courseId'] = $courseId;
				//$_SESSION['semesterId'] = $semesterId;
				//$_SESSION['institutionId'] = $institutionId;
				
				echo "<h4>" . $courseCode . " (" . $courseName . ") has been succesfully added.</h4>";
				echo "<table border='1' style='width:750px'><tr><th>Course Code</th><th>Course Name</th><th>Schedule</th><th>Instructor(s)</th><th>Credits</th><th>Semester</th></tr>";
				$sql = "SELECT CourseCode, CourseName, Schedule, Instructor, Credits, Semester, Institution FROM badgergrades.class INNER JOIN badgergrades.semester ON semester.SemesterID = class.SemesterID INNER JOIN badgergrades.institution ON class.InstitutionID = institution.InstitutionID WHERE class.CourseID = $courseId AND class.SemesterID = $semesterId AND class.InstitutionID = $institutionId ORDER BY CourseCode;";
				$result = mysqli_query($con,$sql);
				while($course = mysqli_fetch_array($result)){
					echo "<tr><td>" . $course['CourseCode'] . "</td><td>" . $course['CourseName'] . "</td><td>" . $course['Schedule'] . "</td><td>" . $course['Instructor'] . "</td><td>" . $course['Credits'] . "</td><td>" . $course['Semester'] . "</td></tr>";
				}
				echo "</table><br><br>";
				echo "<input type=\"button\" value=\"Add Another Course\" onclick=\"location.href='add_course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Go to Course\" onclick=\"location.href='course.php'\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Return to Home\" onclick=\"location.href='Home.php'\"><br><br>";
			}
			else{
				echo "<h4>ERROR:</h4><h5>You have already entered this item.</h5>";
			}
		}
		else{
			echo "<h4>ERROR:</h4>";
			if(empty($institutionId)){
				echo "<p>You must select an institution.</p>";
			}
			if(empty($semesterId)){
				echo "<p>You must select a semester.</p>";
			}
			if(empty($courseCode)){
				echo "<p>You must enter the course code.</p>";
			}
			if(empty($courseName)){
				echo "<p>You must enter the course name.</p>";
			}
			if(empty($credits)){
				echo "<p>You need to select the number of credits.</p>";
			}
			if(empty($gradedItemTypes)){
				echo "<p>You need to enter at least one item type for the grading policy (as outlined in your syllabus).</p>";
			}
			if($totalPercentage!==100.00){
				echo "<p>The \"portion of grade\" for all item types in the grading policy must add up to 100%.</p>";
			}
			if(count($gradingScale)!==7){
				echo "<p>You need to enter the entire grading scale (as outlined in your syllabus).</p>";
			}
			if(!$gradingScaleValid){
				echo "<p>You need to enter a valid grading scale. (The minimum grade for an AB must be lower than the minimum grade for an A, etc.)</p>";
			}
			echo "<br><input type=\"button\" value=\"Back to Add Course\" onclick=\"location.href='add_course.php'\">";
		}
	?><br><br>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>