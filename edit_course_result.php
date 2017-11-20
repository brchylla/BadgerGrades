<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>
		Edit Course - Result 
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
	<br><br>
	<?php
		session_start();
		$courseId = $_SESSION['courseId'];
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
		if(isset($_POST['instructor'])){
			$instructor = $_POST['instructor'];	
		}
		if(!empty($_POST['credits'])){
			$credits = floatval($_POST['credits']);	
		}
		
		if(!empty($courseCode) || !empty($courseName) || !empty($credits) || !empty($days) || !empty($startingLectureTime) || !empty($endingLectureTime) || !empty($startingLabOrDiscussionTime) || !empty($endingLabOrDiscussionTime) || !empty($discussionDays) || !empty($instructor)){
			$con = mysqli_connect("localhost","root","","badgergrades");
			if(!empty($courseCode)){
				$sql = sprintf("UPDATE badgergrades.class SET CourseCode = '%s' WHERE CourseID = $courseId;", mysql_real_escape_string($courseCode));
				mysqli_query($con,$sql);
			}
			if(!empty($courseName)){
				$sql = sprintf("UPDATE badgergrades.class SET CourseName = '%s' WHERE CourseID = $courseId;", mysql_real_escape_string($courseName));
				mysqli_query($con,$sql);
			}
			if(!empty($credits)){
				$sql = "UPDATE badgergrades.class SET Credits = $credits WHERE CourseID = $courseId;";
				mysqli_query($con,$sql);
			}
			
			if(!empty($days)){
				$sql = "UPDATE badgergrades.class SET Schedule = '";
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
				$sql .= "' WHERE CourseID = $courseId;";
				mysqli_query($con,$sql);
			}
			else{
				if(!empty($discussionDays)){
					$sql = "UPDATE badgergrades.class SET Schedule = '";
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
				$sql .= "' WHERE CourseID = $courseId;";
				mysqli_query($con,$sql);
				}
			}
			
			if(!empty($instructor)){
				$sql = "UPDATE badgergrades.graded_item SET Instructor = '$instructor' WHERE CourseID = $courseId;";
				mysqli_query($con,$sql);
			}
			
			echo "<h4>Your changes have been made successfully.</h4>";
			
			$sql = "SELECT semester.SemesterID FROM badgergrades.semester INNER JOIN badgergrades.class ON class.SemesterID = semester.SemesterID WHERE class.CourseID = $courseId;";
			$result = mysqli_query($con, $sql);
			$semesterId = 0;
			while($semester = mysqli_fetch_array($result)){
				$semesterId = (int)$semester['SemesterID'];
				break;
			}
			
			$sql = "SELECT institution.InstitutionID FROM badgergrades.institution INNER JOIN badgergrades.class ON class.InstitutionID = institution.InstitutionID WHERE class.CourseID = $courseId;";
			$result = mysqli_query($con, $sql);
			$institutionId = 0;
			while($institution = mysqli_fetch_array($result)){
				$institutionId = (int)$institution['InstitutionID'];
				break;
			}
			
			$sql = "SELECT CourseCode, CourseName, Schedule, Instructor, Credits, Semester, Institution FROM badgergrades.class INNER JOIN badgergrades.semester ON semester.SemesterID = class.SemesterID INNER JOIN badgergrades.institution ON class.InstitutionID = institution.InstitutionID WHERE class.CourseID = $courseId AND class.SemesterID = $semesterId AND class.InstitutionID = $institutionId ORDER BY CourseCode;";
			$result = mysqli_query($con,$sql);
			echo "<table border='1' style='width:750px'><tr><th>Course Code</th><th>Course Name</th><th>Schedule</th><th>Instructor</th><th>Credits</th><th>Semester</th><th>Institution</th></tr>";
			while($course = mysqli_fetch_array($result)){
				echo "<tr><td>" . $course['CourseCode'] . "</td><td>" . $course['CourseName'] . "</td><td>" . $course['Schedule'] . "</td><td>" . $course['Instructor'] . "</td><td>" . $course['Credits'] . "</td><td>" . $course['Semester'] . "</td><td>" . $course['Institution'] . "</td></tr>";
			}
			echo "</table>";
		}
		else{
			echo "<input type=\"button\" value=\"< Back\" onclick=\"location.href='edit_course.php'\"><br><br>";
			echo "<h4>ERROR:</h4><h5>You have left all of the fields blank.</h5>";
		}
	?>
	<br><br>
	<input type="button" value="Back to Course" onclick="location.href='course.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Return to Home" onclick="location.href='Home.php'">
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>