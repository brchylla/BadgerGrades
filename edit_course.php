<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Course - 
		<?php
			session_start();
			$courseId = $_SESSION['courseId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT CourseCode, CourseName, Instructor, Credits FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con, $sql);
			$courseCode = "";
			$courseName = "";
			$instructor = "";
			$credits = 0.00;
			while($class = mysqli_fetch_array($result)){
				$courseCode = $class['CourseCode'];
				$courseName = $class['CourseName'];
				$instructor = $class['Instructor'];
				$credits = floatval($class['Credits']);
				echo $courseCode;
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
	<h1>Edit Course - <?php echo $courseCode ?></h1>
	<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br><br>
	<form method="post" action="edit_course_result.php">
		<label for 'course_code'><b>Enter the course code*: &nbsp;&nbsp;</b></label><input type="text" id="course_code" name="course_code" value="<?php echo $courseCode ?>" placeholder="<?php echo $courseCode ?>"><br>
		<label for 'course_name'><b>Enter the course name*: </b></label><input type="text" id="course_name" name="course_name" value="<?php echo $courseName ?>" placeholder="<?php echo $courseName ?>"><br><br>
		<label for 'day'>Which days do you attend each week? (optional) </label><br>
		<input type="checkbox" name="day[]" id="day" value="Monday">Monday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" id="day" value="Tuesday">Tuesday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" id="day" value="Wednesday">Wednesday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" id="day" value="Thursday">Thursday&nbsp;&nbsp;&nbsp;<input type="checkbox" name="day[]" id="day" value="Friday">Friday<br><input type="checkbox" name="day[]" id="day" value="Saturday">Saturday&nbsp;&nbsp;<input type="checkbox" name="day[]" id="day" value="Sunday">Sunday&nbsp;&nbsp;&nbsp;<br><br>
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
		<label for 'instructor'>What is the name of your instructor? (optional) </label>&nbsp;&nbsp;&nbsp;<input type="text" name="instructor" id="instructor" value="<?php echo $instructor; ?>" placeholder="<?php echo $instructor; ?>"><br>(enter as: "Last Name, First Name")<br><br>
		<label for 'credits'><b>Select the number of credits.*</b>&nbsp;&nbsp;&nbsp;</label>
		<select name='credits'>
			<?php
				echo "<option value='" . $credits . "'>" . $credits . " (default)</option>";
			?>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='5'>5</option>
			<option value='6'>6</option>
		</select><br><br>
		<input type="submit" id="submit" value="Edit Course" style="height:50px; width:150px">
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>