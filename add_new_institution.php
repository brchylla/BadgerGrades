<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Add New Institution</title>
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
	<a href="add_course.php">Add Course</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="add_new_institution.php">Add New Institution</a>
	<br><br>
	<input type="button" value="< Back" onclick="window.history.back()">
	<br><br><br>
	<form action="add_new_institution_result.php" method="post">
		<label for 'institution'><b>Enter the name of the institution:*</b>&nbsp;</label>
		<input type="text" name="institution" id="institution" placeholder="Institution Name" style="width:240px;"><br>
		<label for 'city'>City (optional):</label>
		<input type="text" name="city" id="city" placeholder="City"><br>
		<label for 'state'>State (optional):</label>
		<input type="text" name="state" id="state" placeholder="State"><br>
		<input type="submit" value="Add College/University">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>