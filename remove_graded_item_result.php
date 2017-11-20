<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Remove Graded Item - Result
		<?php
			session_start();
			$con = mysqli_connect("localhost","root","","badgergrades");
			if(isset($_SESSION['courseId']) && !empty($_SESSION['courseId'])){
				$courseId = $_SESSION['courseId'];
				$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
				$result = mysqli_query($con,$sql);
				while($class = mysqli_fetch_array($result)){
					echo " (" . $class['CourseCode'] . ")";
					break;
				}
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
	<input type="button" value="Back to Remove Item" onclick="location.href='remove_graded_item.php'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br><br>
	<?php
		if(isset($_POST['graded_item']) && !empty($_POST['graded_item'])){
			$gradedItems = $_POST['graded_item'];
			foreach($gradedItems as $item){
				$itemId = (int)$item;
				$sql = "DELETE FROM badgergrades.graded_item WHERE GradedItemID = $itemId;";
				mysqli_query($con,$sql);
			}
			echo "<h3>Item successfully deleted!</h3>";
		}
		else{
			echo "<h4>ERROR:</h4><h5>You do not select any items.</h5>";
		}
	?>
</body>
</html>