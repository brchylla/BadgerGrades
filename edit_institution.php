<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Institution</title>
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
		$institutionId = $_SESSION['institutionId'];
		$con = mysqli_connect("localhost","root","","badgergrades");
		$sql = "SELECT Institution, City, State FROM badgergrades.institution WHERE InstitutionID = $institutionId;";
		$result = mysqli_query($con,$sql);
		$institutionName = "";
		$city = "";
		$state = "";
		while($institution = mysqli_fetch_array($result)){
			$institutionName = $institution['Institution'];
			$city = $institution['City'];
			$state = $institution['State'];
		}
	?>
	<?php
		if(isset($_SESSION['semesterId']) && !empty($_SESSION['semesterId'])){
			echo "<input type=\"button\" value=\"Back to Semester Grades\" onclick=\"location.href='semester_grades.php'\"><br><br>";
		}
		else{
			if(isset($_SESSION['institutionId']) && !empty($_SESSION['institutionId'])){
				echo "<input type=\"button\" value=\"Back to Career Grades\" onclick=\"location.href='career_grades.php'\"><br><br>";
			}
		}
	?>
	<input type="button" value="Return to Home" onclick="location.href='Home.php'">
	<br><br>
	<h1>Edit Institution - <?php echo $institutionName; ?></h1>
	<form action="edit_institution_result.php" method="post">
		<label for 'institution'><b>Enter the name of the institution:*</b>&nbsp;</label>
		<input type="text" name="institution" id="institution" value="<?php echo $institutionName; ?>" placeholder="<?php echo $institutionName; ?>" style="width:240px;"><br><br>
		<label for 'city'>City (optional):&nbsp;</label>
		<input type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="<?php echo $city; ?>"><br><br>
		<label for 'state'>State (optional):&nbsp;</label>
		<input type="text" name="state" id="state" value="<?php echo $state; ?>" placeholder="<?php echo $state; ?>"><br><br>
		<input type="submit" value="Edit College/University">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>