<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Add Course</title>
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
	  <li id="search"><form action="search.php" method="post" class="arrange_right"><img src="ic_search_48px-128.png" height="25" width="25"><input type="text" name="search"><input type="submit" value="Submit"></form></li>
	</ul>
	<br><br>
	<a href="add_course.php">Add Course</a>
	<br><br><br>
	<h2>Course Information</h2>
	<br>
	<form method="post" action="add_course_result.php">
		<label for 'institution'><b>Select the college/university*: </b></label><select name="institution" id="institution">
			<option value=''>Select an institution...</option>
			<?php
				session_unset();
				$con = mysqli_connect("localhost","root","","badgergrades");
				$sql = "SELECT * FROM badgergrades.institution;";
				$result = mysqli_query($con,$sql);
				while($institution = mysqli_fetch_array($result)){
					echo "<option value='" . $institution['InstitutionID'] . "'>" . $institution['Institution'] . "</option>";
				}
			?>
		</select>&nbsp;<input type="button" value="Add New College/University" onclick="location.href='add_new_institution.php'"><br><br>
		<label for 'semester'><b>Select the semester*: </b></label><select name="semester" id="semester">
			<option value=''>Select a semester...</option>
			<?php
				$con = mysqli_connect("localhost","root","","badgergrades");
				$sql = "SELECT * FROM badgergrades.semester;";
				$result = mysqli_query($con,$sql);
				while($semester = mysqli_fetch_array($result)){
					echo "<option value='" . $semester['SemesterID'] . "'>" . $semester['Semester'] . "</option>";
				}
			?>
		</select>&nbsp;<input type="button" value="Add New Semester" onclick="location.href='add_new_semester.php'"><br><br>
		<label for 'course_code'><b>Enter the course code*: &nbsp;&nbsp;</b></label><input type="text" id="course_code" name="course_code"><br>
		<label for 'course_name'><b>Enter the course name*: </b></label><input type="text" id="course_name" name="course_name"><br><br>
		<label for 'day'>Which days do you attend lectures each week? (optional) </label><br>
		<input type="checkbox" name="day[]" value="Monday">Monday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" value="Tuesday">Tuesday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" value="Wednesday">Wednesday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" value="Thursday">Thursday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" value="Friday">Friday<br><input type="checkbox" name="day[]" value="Saturday">Saturday&nbsp;&nbsp;<input type="checkbox" name="day[]" value="Sunday">Sunday&nbsp;&nbsp;&nbsp;<br><br>
		What are the starting and ending times for each lecture? (optional)<br>
		<select name='starting_lecture_time'>
			<option value=''>Select a starting time...</option>
			<?php
				$start=strtotime('6:00');
				$end=strtotime('22:00');
				for ($fiveminutes=$start;$fiveminutes<=$end;$fiveminutes=$fiveminutes+5*60) {
				    printf('<option value="%s">%s</option>',date('g:i a',$fiveminutes),date('g:i a',$fiveminutes));    
				}
			?>
		</select>
		<select name='ending_lecture_time'>
			<option value=''>Select a ending time...</option>
			<?php
				$start=strtotime('6:00');
				$end=strtotime('22:00');
				for ($fiveminutes=$start;$fiveminutes<=$end;$fiveminutes=$fiveminutes+5*60) {
				    printf('<option value="%s">%s</option>',date('g:i a',$fiveminutes),date('g:i a',$fiveminutes));
				}
			?>
		</select><br><br>
		<label for 'discussion_day'>Which days do you attend labs or discussions each week? (optional) </label><br>
		<input type="checkbox" name="discussion_day[]" value="Monday">Monday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="discussion_day[]" value="Tuesday">Tuesday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="discussion_day[]" value="Wednesday">Wednesday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="discussion_day[]" value="Thursday">Thursday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="discussion_day[]" value="Friday">Friday<br><input type="checkbox" name="discussion_day" value="Saturday">Saturday&nbsp;&nbsp;<input type="checkbox" name="discussion_day[]" value="Sunday">Sunday<br><br>
		What are the starting and ending times for each lab/discussion? (optional)<br>
		<select name='starting_lab_or_discussion_time'>
			<option value=''>Select a starting time...</option>
			<?php
				$start=strtotime('6:00');
				$end=strtotime('22:00');
				for ($fiveminutes=$start;$fiveminutes<=$end;$fiveminutes=$fiveminutes+5*60) {
				    printf('<option value="%s">%s</option>',date('g:i a',$fiveminutes),date('g:i a',$fiveminutes));
				}
			?>
		</select>
		<select name='ending_lab_or_discussion_time'>
			<option value=''>Select a ending time...</option>
			<?php
				$start=strtotime('6:00');
				$end=strtotime('22:00');
				for ($fiveminutes=$start;$fiveminutes<=$end;$fiveminutes=$fiveminutes+5*60) {
				    printf('<option value="%s">%s</option>',date('g:i a',$fiveminutes),date('g:i a',$fiveminutes));
				}
			?>
		</select><br><br>
		<label for 'instructor'>What is the name of your instructor? (optional) </label>&nbsp;&nbsp;&nbsp;<input type="text" name="instructor" id="instructor"><br>(enter as: "Last Name, First Name")<br><br>
		<label for 'credits'><b>Select the number of credits.*</b>&nbsp;&nbsp;&nbsp;</label>
		<select name='credits'>
			<option value=''>Number of Credits...</option>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='5'>5</option>
			<option value='6'>6</option>
		</select>
		<br><br><br>
		<h2>Grading Criteria and Scale</h2>
		<p><b>Enter the grading criteria as outlined in the syllabus.*</b><br><b>Graded "item types" can include homework assignments, tests, labs, etc.*</b><br>You may leave some fields blank.</p>
		Graded Item Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Portion of Grade (must add up to 100%)<br>
		<input type="text" name="graded_item_type1" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade1" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type2" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade2" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type3" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade3" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type4" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade4" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type5" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade5" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type6" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade6" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type7" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade7" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type8" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade8" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type9" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade9" id="portion_of_grade">%<br>
		<input type="text" name="graded_item_type10" id = "graded_item_type">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="portion_of_grade10" id="portion_of_grade">%<br>
		<p><b>Enter the minimum percentage required to receive each letter grade, as outlined in your syllabus.*</b></p>
		A:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_A" id="grade_A">%<br>
		AB:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_AB" id="grade_AB">%<br>
		B:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_B" id="grade_B">%<br>
		BC:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_BC" id="grade_BC">%<br>
		C:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_C" id="grade_C">%<br>
		CD:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_CD" id="grade_CD">%<br>
		D:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="grade_D" id="grade_D">%<br>
		<br><br>
		<input type="submit" value="Add Course" style="height:48px; width:120px; font-weight: bold;">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>