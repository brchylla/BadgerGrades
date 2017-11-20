<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<?php
		session_start();
		$institutionId = 0;
		$con = mysqli_connect("localhost","root","","badgergrades");
		if(!empty($_POST['institution'])){
			$institutionId = (int)$_POST['institution'];
		}
		$_SESSION['institutionId'] = $institutionId;
		$sql = "SELECT Institution FROM badgergrades.institution WHERE InstitutionID = $institutionId;";
		$result = mysqli_query($con,$sql);
		$institutionName = "";
		while($institution = mysqli_fetch_array($result)){
			$institutionName = $institution['Institution'];
			break;
		}
	?>
	<title>Select Semester - <?php echo $institutionName; ?></title>
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
	<h1>Semester Grades - <?php echo $institutionName; ?></h1>
	<br><br>
	<a href="semester_institution.php">Select an Institution</a> / Select a Semester
	<br><br>
	<h3><?php echo $institutionName; ?> selected...</h3>
	<form method="post" action="semester_grades.php">
		<label for 'semester'>Select the semester:&nbsp;</label>
		<select name='semester'>
			<option value=''>Select a semester...</option>
			<?php
				$sql = "SELECT SemesterID, Semester FROM badgergrades.semester ORDER BY Year DESC, SemesterID;";
				$result = mysqli_query($con,$sql);
				while($semester = mysqli_fetch_array($result)){
					echo "<option value='" . $semester['SemesterID'] . "'>" . $semester['Semester'] . "</option>";
				}
			?>
		</select><br><br><input type="submit" value="Select Semester">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Remove Semester" onclick="location.href='remove_semester.php'">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>