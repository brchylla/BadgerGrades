<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Edit Graded Item
		<?php
			session_start();
			$courseId = $_SESSION['courseId'];
			$con = mysqli_connect("localhost","root","","badgergrades");
			$sql = "SELECT CourseCode FROM badgergrades.class WHERE CourseID = $courseId;";
			$result = mysqli_query($con,$sql);
			while($class = mysqli_fetch_array($result)){
				echo $class['CourseCode'];
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
	<input type="button" value="Back to Course" onclick="location.href='course.php'">
	<br><br>
	<?php
		$gradedItemId = 0;
		if(isset($_POST['item']) && !empty($_POST['item'])){
			$gradedItemId = (int)$_POST['item'];
		}
		$_SESSION['gradedItemId'] = $gradedItemId;
		$sql = "SELECT GradedItem, PointsEarned, PointsWorth, GradedItemTypeID, Date FROM badgergrades.graded_item WHERE GradedItemID = $gradedItemId;";
		$result = mysqli_query($con,$sql);
		$gradedItemName = "";
		$pointsEarned = 0.00;
		$pointsWorth = 0.00;
		$gradedItemTypeId = 0;
		while($item = mysqli_fetch_array($result)){
			$gradedItemName = $item['GradedItem'];
			$pointsEarned = floatval($item['PointsEarned']);
			$pointsWorth = floatval($item['PointsWorth']);
			$gradedItemTypeId = (int)$item['GradedItemTypeID'];
			$date = $item['Date'];
		}
		$sql = "SELECT GradedItemType FROM badgergrades.graded_item_type WHERE GradedItemTypeID = $gradedItemTypeId;";
		$result = mysqli_query($con,$sql);
		$gradedItemTypeName = "";
		while($itemType = mysqli_fetch_array($result)){
			$gradedItemTypeName = $itemType['GradedItemType'];
		}
	?>
	<h1>Edit Item</h1><h2><?php echo $gradedItemName; ?></h2><br><br>
	<form action="edit_graded_item_result.php" method="post">
		<label for 'item_type'><b>Select the type of item being graded*:</b>&nbsp;</label>
		<select name='item_type'>
			<option value='<?php echo $gradedItemTypeId; ?>'><?php echo $gradedItemTypeName; ?> (default)</option>
			<?php
				$sql = "SELECT GradedItemTypeID, GradedItemType FROM badgergrades.graded_item_type WHERE CourseID = $courseId AND GradedItemTypeID != $gradedItemTypeId;";
				$result = mysqli_query($con,$sql);
				while($itemType = mysqli_fetch_array($result)){
					echo "<option value='" . $itemType['GradedItemTypeID'] . "'>" . $itemType['GradedItemType'] . "</option>";
				}
			?>
		</select><br><br>
		<label for 'item_name'><b>Enter the name of the assignment, test, lab, etc. being graded*:</b>&nbsp;</label>
		<input type="text" name="item_name" id="item_name" value="<?php echo $gradedItemName; ?>" placeholder="<?php echo $gradedItemName; ?>"><br><br>
		
		
		<label for 'grade type'>Is the grade scaled (based on your classmates' performances)?</label>
		<select name="grade type" id="target">
			<option value="">Select...</option>
			<option value="points">No</option>
			<option value="letter">Yes</option>
		</select><br><br>
		
		<div id="points" class="inv">
			<label for 'points_earned'><b>How many points did you earn?*</b>&nbsp;</label><input type="text" name="points_earned" value="<?php echo $pointsEarned; ?>" placeholder="<?php echo $pointsEarned; ?>"><br><br>
			<label for 'points_worth'><b>How many points was it worth?*</b>&nbsp;</label><input type="text" name="points_worth" value="<?php echo $pointsWorth; ?>" placeholder="<?php echo $pointsWorth; ?>"><br><br>
		</div>
		
		<div id="letter" class="inv">
			<label for 'letter_grade' id='letter'><b>Which letter grade did you receive?</b>&nbsp;</label>
			<select name="letter_grade" id="letter">
				<?php
					$sql = "SELECT LetterGrade, MinimumGrade FROM badgergrades.grading_scale WHERE CourseID = $courseId ORDER BY LetterGrade;";
					$result = mysqli_query($con,$sql);
					while($grade = mysqli_fetch_array($result)){
						if(($pointsEarned/$pointsWorth)>=floatval($grade['MinimumGrade'])){
							$letterGrade = $grade['LetterGrade'];
							echo "<option value=\"" . $letterGrade . "\">" . $letterGrade . " (default)</option>";
							break;
						}
						else{
							if(strcmp($grade['LetterGrade'], "D")==0 && (($pointsEarned/$pointsWorth)<floatval($grade['MinimumGrade']))){
								echo "<option value=\"F\">F (default)</option>";
							}
						}
					}
				?>
				<option value="">Select...</option>
				<option value="A">A</option>
				<option value="AB">AB</option>
				<option value="B">B</option>
				<option value="BC">BC</option>
				<option value="C">C</option>
				<option value="CD">CD</option>
				<option value="D">D</option>
				<option value="F">F</option>
			</select><br><br>
			<label for 'points_worth_scaled' id='letter'><b>How many points was it worth?</b>&nbsp;</label>
			<input type="text" name="points_worth_scaled" id="letter" value="<?php echo $pointsWorth ?>" placeholder="<?php echo $pointsWorth ?>"><br><br>
		</div>
		
		<script>
            document
                .getElementById('target')
                .addEventListener('change', function () {
                    'use strict';
                    var vis = document.querySelector('.vis'),   
                        target = document.getElementById(this.value);
                    if (vis !== null) {
                        vis.className = 'inv';
                    }
                    if (target !== null ) {
                        target.className = 'vis';
                    }
            });
        </script>
		
		
		<label for 'date'><b>Enter the date on which you received the grade (YYYY-MM-DD)*:&nbsp;</b></label>
		<input type="text" name="date" id="date" value="<?php echo $date; ?>" placeholder="<?php echo $date; ?>"><br><br>
		<p style="font-size:8">Note: Unless you received extra credit, the number of points earned on an assignment, test, lab, etc. should not be greater than the number of points that it's worth.</p>
		<input type="submit" value="Change Grade">
	</form>
	<br><br>Copyright 2015 BadgerGrades<br><br>
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           