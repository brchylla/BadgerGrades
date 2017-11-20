<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Grading Scale - Result
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
		$gradingScale = array();
		$letterGrades = array("A","AB","B","BC","C","CD","D");
		foreach($letterGrades as $letterGrade){
			$minimumPercentage = "grade_" . $letterGrade;
			if(isset($_POST[$minimumPercentage]) && !empty($_POST[$minimumPercentage])){
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
		if(count($gradingScale)==7 && $gradingScaleValid){
			foreach($gradingScale as $letterGrade=>$minimumGrade){
				$sql = "UPDATE badgergrades.grading_scale SET MinimumGrade = $minimumGrade WHERE LetterGrade = '$letterGrade' AND CourseID = $courseId;";
				mysqli_query($con,$sql);
			}
			echo "<h4>Your changes have been saved successfully!</h4>";
			echo "<table border='1' style='width:750px'><tr><th>Letter Grade</th><th>Minimum Grade</th></tr>";
			$sql = "SELECT LetterGrade, MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($grade = mysqli_fetch_array($result)){
				echo "<tr><td>" . $grade['LetterGrade'] . "</td><td>" . $grade['MinimumGrade']*100 . "</td></tr>";
			}
			echo "</table>";
		}
		else{
			echo "<h4>ERROR:</h4>";
			if(count($gradingScale)!==7){
				echo "<p>You need to enter the entire grading scale (as outlined in your syllabus).</p>";
			}
			if(!$gradingScaleValid){
				echo "<p>You need to enter a valid grading scale. (The minimum grade for an AB must be lower than the minimum grade for an A, etc.)</p>";
			}
		}
	?>
	<br><br><input type="button" value="Back to Course" onclick="location.href='course.php'">&nbsp;&nbsp;<input type="button" value="Return to Home" onclick="location.href='Home.php'"><br><br>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>