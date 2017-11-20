<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Switch Institution</title>
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
		$courseId = $_SESSION['courseId'];
		$con = mysqli_connect("localhost","root","","badgergrades");
		$sql = "SELECT CourseCode, CourseName FROM badgergrades.class WHERE CourseID = $courseId;";
		$result = mysqli_query($con,$sql);
		$courseCode = "";
		$courseName = "";
		while($class = mysqli_fetch_array($result)){
			$courseCode = $class['CourseCode'];
			$courseName = $class['CourseName'];
		}
	?>
	<br><br>
	<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br>
	<h4>WARNING:</h4>
	<p>You are about to switch <?php echo $courseCode; ?> (<?php echo $courseName; ?>) to a different college/university.</p><br>
	<form action="switch_institution_result.php" method="post">
		<label for 'institution'>Select the college/university:&nbsp;</label>
		<select name='institution'>
			<option value=''>Select an institution...</option>
			<?php
				$sql = "SELECT InstitutionID, Institution FROM badgergrades.institution;";
				$result = mysqli_query($con,$sql);
				while($institution = mysqli_fetch_array($result)){
					echo "<option value='" . $institution['InstitutionID'] . "'>" . $institution['Institution'] . "</option>";
				}
			?>
		</select><br><br><input type="submit" value="Switch Course to New Institution">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>