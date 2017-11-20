<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Home.css">
	<title>Home</title>
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
	<h2>Hello, college students!</h2>
	<p>Have your professors underutilized the resources at their disposal to post your grades online? Do you need to accurately calculate your current weighted grade this semester? Do you want to check your current progress and predict your career GPA by the end of the semester?</p>
	<p>If so, then BadgerGrades is the resource for you! You can simply select a semester, add a class, enter the criteria outlined on the class syllabus, and you're ready to go! Every time you receive a grade for any exam, quiz, lab, project or assignment, just enter it into to your class! Your current weighted grade will be displayed immediately. You can also view your current GPA based on current progress this semester, or even predict what your career GPA will be by the end of the semester!</p>
	<p>Add a new course by clicking on the "Add Course" tab in the navigation bar.</p>
	<p>You can view your grades and add graded items to a course by selecting it from "Semester," "Career," or "Course History."</p>
	<p>"Semester" allows you to select courses and update grades for a single semester, and to view your GPA for the term.</p>
	<p>"Career" allows you to select courses and update grades for your entire educational career at a single institution (e.g. UW-Madison), and to view your CAREER GPA at that institution. (If you have attended multiple post-secondary educational institutions, please contact your local college or university to learn about policies regarding transferring grades between schools).</p>
	<p>If you would like to search for a particular course, enter its code or name, or the first or last name of its instructor, in the search box.</p>
	<p>Any further questions may be emailed to brchylla@wisc.edu. Good luck with your educational career!</p>
	<br><br>
	Copyright 2015 BadgerGrades<br><br>
</body>
<?php
	session_start();
	session_unset();
	$_SESSION['courseId'] = 0;
	$_SESSION['semesterId'] = 0;
	$_SESSION['institutionId'] = 0;
	$_SESSION['gradedItemId'] = 0;
	$con = mysqli_connect("localhost","root","","badgergrades");
	$sql = "SELECT * FROM badgergrades.class;";
	$result = mysqli_query($con,$sql);
	if(mysqli_num_rows($result)==0){
		checkFields($con);
	}
	
	function checkFields($con){
		check_institution($con);
		check_semester($con);
		check_class($con);
		check_graded_item_type($con);
		check_graded_item($con);
		check_grading_scale($con);
	}
	function check_institution($con){
		$sql = "SELECT * FROM badgergrades.institution;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)==0){
			input_institution($con);
		}
	}
	function check_semester($con){
		$sql = "SELECT * FROM badgergrades.semester;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)==0){
			input_semester($con);
		}
	}
	function check_class($con){
		$sql = "SELECT * FROM badgergrades.class;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)==0){
			input_class($con);
		}
	}
	function check_graded_item_type($con){
		$sql = "SELECT * FROM badgergrades.graded_item_type;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)==0){
			input_graded_item_type($con);
		}
	}
	function check_graded_item($con){
		$sql = "SELECT * FROM badgergrades.graded_item;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)==0){
			input_graded_item($con);
		}
	}
	function check_grading_scale($con){
		$sql = "SELECT * FROM badgergrades.grading_scale;";
		$result = mysqli_query($con,$sql);
		if(mysqli_num_rows($result)==0){
			input_grading_scale($con);
		}
	}
	
	function input_institution($con){
		$sql = "INSERT INTO badgergrades.institution VALUES (1,'Edgewood College','Madison','Wisconsin','Computer Information Systems'),(2,'University of Wisconsin - Madison','Madison','Wisconsin','Computer Sciences');";
		if($con->query($sql) === FALSE){
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}
	function input_semester($con){
		$sql = "INSERT INTO badgergrades.semester VALUES (1,'Fall 2015',2015),(2,'Spring 2015',2015),(3,'Fall 2014',2014),(4,'Spring 2014',2014),(5,'Fall 2013',2013);";
		if($con->query($sql) === FALSE){
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}
	function input_class($con){
		$sql = "INSERT INTO badgergrades.class VALUES (1,'CHEM 110','Intro to Chemistry','MoWe 8:30 am - 9:50 pm, Tu 1:00 pm - 4:50 pm','Kretchmar, David',4.00,2,1),(2,'CS 180','Intro to Computing and Programming','MoWe 2:00 pm-3:50 pm','Alexandrian, Greg',4.00,5,1),(3,'CS 150','Digital Life Through Multimedia','MoWeFr 9:00 am-9:50 am','Doyd, Nathan',3.00,5,1),(4,'COMMS 100','Introduction to Communication','MoWeFr 3:00 pm-3:50 pm','Liang, Xuan',3.00,3,1),(5,'CS 270','Introduction to Database Structures','MoWe 4:00 pm-5:50 pm','Khasawneh, Samer',4.00,4,1),(6,'MATH 121','Statistics','MoWeFr 9:00 am-9:50 am','Post, Steven',3.00,4,1),(7,'MATH 232','Calculus II','MoTuThFr 12:00 pm-12:50 pm','Post, Steven',4.00,4,1),(8,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,4,1),(9,'PHIL 104','Ethics','TuTh 2:00 pm-3:20 pm','Kavaloski, Vincent',3.00,4,1),(10,'PHIL 117','Eagles Debate Team','Fr 4:00 pm-6:00 pm','Mortensen, Daniel',1.00,4,1),(11,'PHIL 101','Logic: Practice of Critical Thinking','TuTh 2:00 pm-3:20 pm','Hinds, Juli',3.00,5,1),(12,'ENG 111A-1C','Fairy Tales as Cultural Narratives','TuTh 10:00 am-11:50 am','Lacey, Lauren',4.00,5,1),(13,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,5,1),(14,'CS 301','Info Systems: Analysis & Design','MoWe 10:00 am-11:50 am','Khasawneh, Samer',4.00,3,1),(15,'CS 340','Introduction to Web Development','TuTh 2:00 pm-3:50 pm','Alexandrian, Greg',4.00,3,1),(16,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,3,1),(17,'PHIL 117','Eagles Debate Team','Fr 4:00 pm-6:00 pm','Mortensen, Daniel',1.00,3,1),(18,'ECON 240','Principles of Economics','TuTh 8:00 am-9:50 am','Belkis, Cerrato',4.00,2,1),(19,'CS 220','Introduction to Networking Tech','TuTh 10:00 am-11:50 am','Sinha, Atreyee',4.00,2,1),(20,'CS 302','Info Systems: Design & Implementation','MoWe 10:00 am-11:50 am','Khasawneh, Samer',4.00,2,1),(21,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,2,1),(22,'PHIL 117','Eagles Debate Team','Fr 4:00 pm-6:00 pm','Mortensen, Daniel',1.00,2,1),(23,'UWMADCLLB PRG','LINEAR ALG & DIFF EQUATIONS','','',3.00,3,1),(24,'MATH 320','Linear Algebra & Differential Equations','TuTh 9:30 am-10:45 am, Mo 1:20 pm-2:10 pm','Smith, Leslie & Sangari, Arash',3.00,3,2),(25,'CS 252','Intro to Computer Engineering','MoWeFr 11:00 am-11:50 am','Sankaralingam, Karu',2.00,1,2),(26,'SPANISH 102','Second Semester Spanish','MoTuWeThFr 2:25 pm-3:15 pm','Rios, Jeremy',4.00,1,2),(27,'CS 240 / MATH 240','Intro to Discrete Mathematics','TuTh 9:30 am-10:45 am, Mo 8:50 am-9:40 am','Hasti, Beck',3.00,1,2),(28,'CS 367','Intro to Data Structures','TuTh 1:00 pm-2:15 pm','Skrentny, James',3.00,1,2);";
		if($con->query($sql) === FALSE){
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}
	function input_graded_item_type($con){
		$sql = "INSERT INTO badgergrades.graded_item_type VALUES (1,'Exams',0.56,1),(2,'Labs',0.24,1),(3,'Quizzes',0.10,1),(4,'Homework',0.07,1),(5,'Lab Final',0.02,1),(6,'Participation',0.01,1),(7,'Assignment',0.50,2),(8,'Test',0.30,2),(9,'Quiz',0.05,2),(10,'InClass Quiz',0.10,2),(11,'Participation',0.05,2),(12,'Assignment',0.50,3),(13,'Blog',0.10,3),(14,'Information Literacy assignments',0.15,3),(15,'Information Literacy quizzes',0.05,3),(16,'Class Participation',0.10,3),(17,'Final Draft Team Project & Presentation',0.10,3),(18,'Participation',0.20,4),(19,'Assignments',0.40,4),(20,'Exams',0.40,4),(21,'Overall Grade',1.00,5),(22,'Overall Grade',1.00,6),(23,'Overall Grade',1.00,7),(24,'Overall Grade',1.00,8),(25,'Overall Grade',1.00,9),(26,'Overall Grade',1.00,10),(27,'Overall Grade',1.00,11),(28,'Overall Grade',1.00,12),(29,'Overall Grade',1.00,13),(31,'Overall Grade',1.00,14),(32,'Overall Grade',1.00,15),(33,'Overall Grade',1.00,16),(34,'Overall Grade',1.00,17),(35,'Quizzes',0.10,18),(36,'Midterm Exams',0.30,18),(37,'Participation',0.10,18),(38,'Group Country Research Project',0.15,18),(39,'Group Country Presentation',0.05,18),(40,'Problem Sets',0.15,18),(41,'Final Exam ',0.15,18),(42,'Discussions',0.05,19),(43,'Blog',0.05,19),(44,'Exams',0.15,19),(45,'Assignments & Quizzes',0.25,19),(46,'Group Topic Discussion',0.05,19),(47,'Final Research Project',0.15,19),(48,'Class Participation',0.05,19),(49,'In-Class activities/Hands On',0.25,19),(50,'Overall Grade',1.00,21),(51,'Overall Grade',1.00,22),(52,'Overall Grade',1.00,23),(53,'Mid-term test',0.15,20),(54,'Assignments',0.15,20),(55,'Team Client Project',0.25,20),(56,'Individual Project',0.25,20),(57,'In-Class Activities',0.10,20),(58,'Class Participation',0.10,20),(59,'Overall Grade',1.00,24),(60,'Homeworks',0.30,25),(61,'Midterms',0.70,25),(62,'Homework/Quiz',0.15,26),(63,'Midterm (Written)',0.15,26),(64,'Midterm (Oral)',0.10,26),(65,'Writing assignment',0.10,26),(66,'Test',0.15,26),(67,'Written Final',0.15,26),(68,'Oral Final',0.10,26),(69,'Participation',0.05,26),(70,'Attendance',0.05,26),(71,'Homework Assignments',0.30,27),(72,'Quizzes',0.09,27),(73,'Exams',0.60,27),(74,'Participation',0.01,27),(75,'Homework Assignments',0.20,28),(76,'Programming Assignments',0.25,28),(77,'Exams',0.55,28);";
		if($con->query($sql) === FALSE){
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}
	function input_graded_item($con){
		$sql = "INSERT INTO badgergrades.graded_item VALUES (1,'Assignment #1',8.00,10.00,4,'2015-01-26'),(2,'Quiz #1: Metric',12.00,10.00,3,'2015-01-21'),(3,'Lab #2 - Density Lab',18.00,20.00,2,'2015-01-29'),(4,'Quiz #2 - conversions',9.00,10.00,3,'2015-01-27'),(5,'Quiz #3 - Atomic structure',10.00,10.00,3,'2015-02-03'),(6,'Homework Chapter 1',4.00,4.00,4,'2015-02-03'),(7,'Lab #3 - electromagnetic energy',19.00,20.00,3,'2015-02-04'),(8,'Build an atom simulation',1.00,1.00,4,'2015-02-04'),(9,'Exam #1',112.00,120.00,1,'2015-02-11'),(10,'Quiz #4 - ionic nomenclature',0.00,10.00,3,'2015-02-17'),(11,'Lab #4 - Properties of elements',17.00,20.00,2,'2015-02-14'),(12,'Homework #3',4.00,4.00,4,'2015-02-23'),(13,'Quiz #5',9.50,10.00,3,'2015-02-24'),(14,'Lab #5 - Chemical rxns.',17.00,20.00,2,'2015-02-24'),(15,'Lab #7 - models lab',7.50,20.00,2,'2015-02-26'),(16,'balancing chemical reactions simulation',1.00,1.00,4,'2015-03-02'),(17,'Quiz #6 - balancing and formula weights',12.00,10.00,3,'2015-03-03'),(18,'Lab #6 - hydrates',17.50,20.00,2,'2015-03-24'),(19,'chapter #5 HW',1.00,4.00,4,'2015-04-15'),(20,'Exam #2',121.00,120.00,1,'2015-03-25'),(21,'Lab #8 - stoichiometry',20.00,20.00,2,'2015-04-14'),(22,'MILK LAB - quiz 7',7.00,10.00,3,'2015-04-08'),(23,'lab ruff draft formal report',10.40,15.00,4,'2015-04-13'),(24,'Lab Formal report',25.00,25.00,4,'2015-04-20'),(25,'Quiz #7 - energy (chapter 7)',7.00,10.00,3,'2015-04-08'),(26,'Quiz #8 - Stoichiometry',12.00,10.00,3,'2015-03-10'),(27,'Lab #9 - water purification',19.50,20.00,2,'2015-03-24'),(28,'Quiz #9 - gas laws',12.00,10.00,3,'2015-04-15'),(29,'Lab #11 - Equilibrium',20.00,20.00,2,'2015-04-20'),(30,'Quiz #10 - molarity',12.00,10.00,3,'2015-04-21'),(31,'Exam 3 extra credit question',0.00,1.00,4,'2015-04-29'),(32,'Exam #3',113.00,120.00,1,'2015-04-22'),(33,'Lab #12 - Dialysis',20.00,20.00,2,'2015-04-24'),(34,'Quiz #11- pH quiz',8.00,10.00,3,'2015-04-29'),(35,'Lab #13 - acids and bases',20.00,20.00,2,'2015-04-24'),(36,'Quiz #12 - Radiation',8.00,10.00,3,'2015-05-05'),(37,'Laboratory final - flying solo',20.00,20.00,5,'2015-04-29'),(38,'Final exam',194.75,200.00,1,'2015-05-11'),(39,'Chapter 7_2',100.00,100.00,7,'2013-11-30'),(40,'Chapter 6_2',99.00,100.00,7,'2013-10-27'),(41,'Final (up till ch8)_Light version',74.00,70.00,8,'2013-12-16'),(42,'Chapter 8_1',104.00,100.00,7,'2013-12-14'),(43,'Chapter 7_1',102.00,100.00,7,'2013-11-30'),(44,'Participation',5.00,5.00,11,'2013-10-26'),(45,'Chapter 6_3',102.00,100.00,7,'2013-11-18'),(46,'Chapter 6_1',100.00,100.00,7,'2013-10-19'),(47,'Arrays_Quiz',14.00,14.00,9,'2013-10-17'),(48,'Chapter 5',100.00,100.00,7,'2013-10-09'),(49,'HTMLAssignment 3',99.00,100.00,7,'2013-10-09'),(50,'Chapter 4',104.00,100.00,7,'2013-10-02'),(51,'Quiz on ch.4',19.00,20.00,9,'2013-10-09'),(52,'Chapter 3',98.00,100.00,7,'2013-09-23'),(53,'Quiz Ch.3',13.00,13.00,9,'2013-09-11'),(54,'Pop Quiz 1',10.00,10.00,10,'2013-10-05'),(55,'Quiz ch. 5 Methods',22.00,22.00,9,'2013-10-02'),(56,'HtmlAssign2',100.00,100.00,7,'2013-10-07'),(57,'HtmlAssign1',100.00,100.00,7,'2013-09-16'),(58,'Chapter 2',101.00,100.00,7,'2013-09-15'),(59,'Quiz ch 2',15.00,18.00,9,'2013-09-11'),(60,'InClassQuizObjects_2',13.00,10.00,10,'2013-11-27'),(61,'InClassQuizOnObjects_1',20.00,20.00,10,'2013-11-20'),(62,'InClassQuiz(Arrays)(1_1)',10.00,10.00,10,'2013-10-23'),(63,'InClassQuiz(Arrays2)',10.00,10.00,10,'2013-11-06'),(64,'HTMLAssignment4',98.00,100.00,7,'2013-11-30'),(65,'Midterm Exam 1. Java Syntax. Control Statemen',20.00,22.00,8,'2013-10-09'),(66,'Midterm Exam 2. Methods. Arrays.',24.00,27.00,8,'2013-11-11'),(67,'InClassQuiz(Arrays1_2)',10.00,10.00,10,'2013-10-28'),(68,'Class Participation',5.00,5.00,16,'2013-10-10'),(69,'Quiz: Starting Your Research',9.00,10.00,15,'2013-10-02'),(70,'Quiz: Choosing your Topic',7.00,10.00,15,'2013-10-02'),(71,'Quiz: Finding Articles',8.00,10.00,15,'2013-10-02'),(72,'Quiz: Using the Web',10.00,10.00,15,'2013-10-02'),(73,'Quiz: Citing Sources',8.00,10.00,15,'2013-10-02'),(74,'Digital Presence- Case Study 2',9.00,10.00,12,'2013-11-13'),(75,'Individual Project',50.00,50.00,12,'2013-12-18'),(76,'Blogs',21.00,25.00,13,'2013-12-06'),(77,'Case Study #1: What makes a good podcast.',9.00,10.00,12,'2013-10-10'),(78,'Information Literacy Assignment 4',15.00,15.00,14,'2013-09-25'),(79,'Information Literacy Assignment 5',0.00,15.00,14,'2013-10-14'),(80,'Digital Citizenship Podcast Assignment',20.00,20.00,12,'2013-10-01'),(81,'Information Literacy Assignment 6',70.00,70.00,14,'2013-10-17'),(82,'Community Event Video',26.00,30.00,12,'2013-11-01'),(83,'Final Draft Team Project & Presentation',48.00,50.00,17,'2013-12-01'),(84,'Case Study #3 - Alone Together',10.00,10.00,12,'2013-12-05'),(85,'Overall Grade',90.00,100.00,28,'2014-01-01'),(86,'Overall Grade',95.00,100.00,29,'2014-01-01'),(87,'Overall Grade',95.00,100.00,27,'2014-01-01'),(88,'Overall Grade',98.00,100.00,21,'2014-01-01'),(89,'Overall Grade',98.00,100.00,22,'2014-01-01'),(90,'Overall Grade',99.00,100.00,23,'2014-01-01'),(91,'Overall Grade',94.00,100.00,24,'2014-01-01'),(92,'Overall Grade',100.00,100.00,25,'2014-01-01'),(93,'Overall Grade',100.00,100.00,26,'2014-01-01'),(94,'Participation',100.00,100.00,18,'2014-01-01'),(95,'Exam 1',85.00,100.00,20,'2014-09-26'),(96,'Exam 2',92.00,100.00,20,'2014-10-13'),(97,'Informative Speech Rough Outline Submission',20.00,20.00,19,'2014-10-17'),(98,'Informative Speech Presentation',93.00,100.00,19,'2014-11-05'),(99,'Exam 3',94.00,100.00,20,'2014-12-04'),(100,'Group presentation topic',5.00,5.00,19,'2014-12-05'),(101,'Group presentation references',19.00,20.00,19,'2014-12-05'),(102,'Group presentation teammate evaluation',10.00,10.00,19,'2014-12-04'),(103,'Group presentation delivery',61.00,65.00,19,'2014-12-05'),(104,'Informative Speech Working Outline Submission',30.00,30.00,19,'2014-10-27'),(105,'Critical Media Analysis Submission',138.00,150.00,19,'2014-12-12'),(106,'Exam 4',96.00,100.00,20,'2015-01-07'),(107,'Overall Grade',94.00,100.00,31,'2015-01-01'),(108,'Overall Grade',100.00,100.00,32,'2015-01-01'),(109,'Overall Grade',90.00,100.00,33,'2015-01-01'),(110,'Overall Grade',85.00,100.00,52,'2015-01-01'),(111,'Overall Grade',100.00,100.00,34,'2015-01-01'),(112,'Hands-on (Wireshark Activity)',5.00,5.00,49,'2015-01-26'),(113,'Chapter 2 Class Activity',15.00,15.00,49,'2015-02-15'),(114,'Quiz (Ch 1 & 2)',10.00,10.00,45,'2015-01-30'),(115,'Physical Layer (Ch 3) Assignment',24.00,25.00,45,'2015-03-31'),(116,'Chapter 3 Class Activity',9.00,10.00,49,'2015-03-31'),(117,'Quiz (Ch 3 & 4)',10.00,10.00,45,'2015-02-15'),(118,'The Mobility Boom',5.00,5.00,42,'2015-03-31'),(119,'Data Link Layer Activity',4.00,5.00,49,'2015-03-31'),(120,'Hands-on Activity - Part 1',8.00,10.00,49,'2015-02-17'),(121,'Hands-on Activity - Part 2',20.00,20.00,49,'2015-03-09'),(122,'Case Study: Worldwide Charity',5.00,5.00,42,'2015-03-31'),(123,'Case Study: Central University',5.00,5.00,42,'2015-03-31'),(124,'Case Study: Old Army',5.00,5.00,42,'2015-03-31'),(125,'Hands-on Activity - 5B',5.00,5.00,49,'2015-03-09'),(126,'Discussion Topic Presentations',20.00,20.00,46,'2015-05-18'),(127,'Chapter 5 Quiz',11.00,20.00,45,'2015-02-25'),(128,'Transport & Network Layer (ch 5) Assignment',13.00,15.00,45,'2015-03-31'),(129,'Hands-on Activity',15.00,15.00,49,'2015-03-09'),(130,'Chapter 6 Quiz',9.00,10.00,45,'2015-03-07'),(131,'Final Project: Individual Research Paper',99.00,100.00,47,'2015-05-18'),(132,'Hands-on Activity: Wireshark - 802.11',10.00,10.00,49,'2015-03-31'),(133,'HANDS-ON Activity 7A',10.00,10.00,49,'2015-03-31'),(134,'Chapter 7 Quiz',10.00,10.00,45,'2015-03-31'),(135,'Backbone Networks: Ch7 Assignment',15.00,15.00,45,'2015-05-18'),(136,'CS 220 Network Tour (TAC)',10.00,10.00,43,'2015-05-18'),(137,'Chapter 8 Quiz',26.00,28.00,45,'2015-04-11'),(138,'Hands-on Activity 9A and 9B',10.00,10.00,49,'2015-05-18'),(139,'Chapter 9 Quiz',20.00,20.00,45,'2015-04-16'),(140,'Best of Midterm',86.00,100.00,44,'2015-04-18'),(141,'Hands-on Activity - 10C',10.00,10.00,49,'2015-05-18'),(142,'Hands-on Activity - 11B (In-Class)',5.00,5.00,49,'2015-05-18'),(143,'Hands-on Activity - 11A',10.00,10.00,49,'2015-05-18'),(144,'NEW: Final Project Presentations',5.00,5.00,43,'2015-05-18'),(145,'NEW: Network Design Lab',5.00,5.00,43,'2015-05-18'),(146,'Class Participation',100.00,100.00,48,'2015-05-18'),(147,'Overall Grade',90.00,100.00,50,'2015-05-18'),(148,'Overall Grade',100.00,100.00,51,'2015-05-18'),(149,'Prototyping -- Individual Projects',10.00,10.00,54,'2015-04-06'),(150,'Ch. 12 Case Study',8.00,10.00,54,'2015-04-19'),(151,'Mobile-oriented Prototyping',20.00,20.00,54,'2015-04-19'),(152,'Midterm Exam',25.00,34.00,53,'2015-04-15'),(153,'Team Client Project',100.00,100.00,55,'2015-05-18'),(154,'Individual Project',100.00,100.00,56,'2015-05-18'),(155,'Class Participation',100.00,100.00,58,'2015-05-18'),(156,'Prototyping -- Group Projects',10.00,10.00,54,'2015-05-18'),(157,'Quiz #1',8.00,10.00,35,'2015-02-12'),(158,'Quiz #2',14.00,15.00,35,'2015-02-18'),(159,'Quiz #3',12.00,12.00,35,'2015-03-26'),(160,'Quiz #4',18.00,20.00,35,'2015-03-31'),(161,'Quiz #5',9.00,10.00,35,'2015-04-12'),(162,'Problem Set #1',100.00,100.00,40,'2015-02-13'),(163,'Problem Set #2',100.00,100.00,40,'2015-03-02'),(164,'Problem Set #3',100.00,100.00,40,'2015-04-13'),(165,'Problem Set #4',100.00,100.00,40,'2015-04-21'),(166,'Exam 1',84.00,100.00,36,'2015-05-19'),(167,'Exam 2',90.00,100.00,36,'2015-04-21'),(168,'Final Exam',83.00,100.00,41,'2015-05-13'),(169,'Participation',100.00,100.00,37,'2015-03-24'),(170,'Country Presentation',96.00,100.00,39,'2015-05-18'),(171,'Country Report',99.00,100.00,38,'2015-05-18'),(172,'Overall Grade',85.00,100.00,59,'2015-01-01'),(173,'Ch 2, 3 Prep - Gender and Agreement',10.00,10.00,62,'2015-09-03'),(174,'Ch 2, 3 Hmwk - Gender and Agreement',10.00,10.00,62,'2015-09-03'),(175,'Ch 2, 3, 4 Prep - Subject pronouns and present tense; stress and accents; possessive adjectives',8.00,10.00,62,'2015-09-03'),(176,'Ch 2, 3, 4 Hmwk - Subject pronouns and present tense; stress and accents; possessive adjectives',10.00,10.00,62,'2015-09-04'),(177,'Ch 4, 6 Prep - Demonstratives; irregular present tense; prepositions and prepositional pronouns',10.00,10.00,62,'2015-09-04'),(178,'Ch 4, 6 Hmwk - Demonstratives; irregular present tense; prepositions and prepositional pronouns',10.00,10.00,62,'2015-09-08'),(179,'Ch 5, 6 Prep - Reflexive pronouns; ser and estar; comparisons',10.00,10.00,62,'2015-09-08'),(180,'Ch 5, 6 Hmwk - Reflexive pronouns; ser and estar; comparisons',10.00,10.00,62,'2015-09-09'),(181,'Cap. 7 - Prep (Vocab, Saber y conocer)',0.00,10.00,62,'2015-09-09'),(182,'Cap. 7 - Hmwk (Vocab, Saber y conocer)',10.00,10.00,62,'2015-09-10'),(183,'Cap. 7 - Prep (DOP\'s and \'A personal\'; negation)',10.00,10.00,62,'2015-09-10'),(184,'Cap. 7 - Hmwk (DOP\'s and \'A personal\'; negation)',10.00,10.00,62,'2015-09-11'),(185,'Cap. 7 - Prep (Mandatos)',3.00,10.00,62,'2015-09-11'),(186,'HW1',9.50,10.00,60,'2015-09-13'),(187,'Prueba 1, Cap. 7',17.00,20.00,62,'2015-09-14'),(188,'Cap. 7 - Hmwk (Mandatos)',10.00,10.00,62,'2015-09-14');";
		if($con->query($sql) === FALSE){
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}
	function input_grading_scale($con){
		$sql = "INSERT INTO badgergrades.grading_scale VALUES (1,'A',0.90,1),(2,'AB',0.87,1),(3,'B',0.80,1),(4,'BC',0.77,1),(5,'C',0.70,1),(6,'CD',0.67,1),(7,'D',0.60,1),(8,'A',0.94,2),(9,'AB',0.89,2),(10,'B',0.84,2),(11,'BC',0.79,2),(12,'C',0.74,2),(13,'CD',0.69,2),(14,'D',0.60,2),(15,'A',0.94,3),(16,'AB',0.89,3),(17,'B',0.84,3),(18,'BC',0.79,3),(19,'C',0.74,3),(20,'CD',0.69,3),(21,'D',0.60,3),(22,'A',0.93,4),(23,'AB',0.87,4),(24,'B',0.83,4),(25,'BC',0.77,4),(26,'C',0.74,4),(27,'CD',0.70,4),(28,'D',0.60,4),(29,'A',0.94,5),(30,'AB',0.89,5),(31,'B',0.84,5),(32,'BC',0.79,5),(33,'C',0.74,5),(34,'CD',0.69,5),(35,'D',0.60,5),(36,'A',0.94,6),(37,'AB',0.92,6),(38,'B',0.87,6),(39,'BC',0.82,6),(40,'C',0.77,6),(41,'CD',0.72,6),(42,'D',0.60,6),(43,'A',0.94,7),(44,'AB',0.92,7),(45,'B',0.87,7),(46,'BC',0.82,7),(47,'C',0.77,7),(48,'CD',0.72,7),(49,'D',0.65,7),(50,'A',0.94,8),(51,'AB',0.89,8),(52,'B',0.84,8),(53,'BC',0.79,8),(54,'C',0.74,8),(55,'CD',0.69,8),(56,'D',0.60,8),(57,'A',0.94,9),(58,'AB',0.89,9),(59,'B',0.84,9),(60,'BC',0.79,9),(61,'C',0.74,9),(62,'CD',0.69,9),(63,'D',0.60,9),(64,'A',0.94,10),(65,'AB',0.89,10),(66,'B',0.84,10),(67,'BC',0.79,10),(68,'C',0.74,10),(69,'CD',0.69,10),(70,'D',0.60,10),(71,'A',0.94,11),(72,'AB',0.89,11),(73,'B',0.84,11),(74,'BC',0.79,11),(75,'C',0.74,11),(76,'CD',0.69,11),(77,'D',0.60,11),(78,'A',0.94,12),(79,'AB',0.89,12),(80,'B',0.84,12),(81,'BC',0.79,12),(82,'C',0.74,12),(83,'CD',0.69,12),(84,'D',0.60,12),(85,'A',0.94,13),(86,'AB',0.89,13),(87,'B',0.84,13),(88,'BC',0.79,13),(89,'C',0.74,13),(90,'CD',0.69,13),(91,'D',0.60,13),(99,'A',0.94,14),(100,'AB',0.89,14),(101,'B',0.84,14),(102,'BC',0.79,14),(103,'C',0.74,14),(104,'CD',0.69,14),(105,'D',0.60,14),(106,'A',0.94,15),(107,'AB',0.89,15),(108,'B',0.84,15),(109,'BC',0.79,15),(110,'C',0.74,15),(111,'CD',0.69,15),(112,'D',0.60,15),(113,'A',0.94,16),(114,'AB',0.89,16),(115,'B',0.84,16),(116,'BC',0.79,16),(117,'C',0.74,16),(118,'CD',0.69,16),(119,'D',0.60,16),(120,'A',0.94,17),(121,'AB',0.89,17),(122,'B',0.84,17),(123,'BC',0.79,17),(124,'C',0.74,17),(125,'CD',0.69,17),(126,'D',0.60,17),(127,'A',0.92,18),(128,'AB',0.89,18),(129,'B',0.84,18),(130,'BC',0.79,18),(131,'C',0.74,18),(132,'CD',0.69,18),(133,'D',0.60,18),(134,'A',0.94,19),(135,'AB',0.89,19),(136,'B',0.84,19),(137,'BC',0.79,19),(138,'C',0.74,19),(139,'CD',0.69,19),(140,'D',0.60,19),(141,'A',0.94,20),(142,'AB',0.89,20),(143,'B',0.84,20),(144,'BC',0.79,20),(145,'C',0.74,20),(146,'CD',0.69,20),(147,'D',0.60,20),(148,'A',0.94,21),(149,'AB',0.89,21),(150,'B',0.84,21),(151,'BC',0.79,21),(152,'C',0.74,21),(153,'CD',0.69,21),(154,'D',0.60,21),(155,'A',0.94,22),(156,'AB',0.89,22),(157,'B',0.84,22),(158,'BC',0.79,22),(159,'C',0.74,22),(160,'CD',0.69,22),(161,'D',0.60,22),(162,'A',0.94,23),(163,'AB',0.89,23),(164,'B',0.84,23),(165,'BC',0.79,23),(166,'C',0.74,23),(167,'CD',0.69,23),(168,'D',0.60,23),(169,'A',0.94,24),(170,'AB',0.89,24),(171,'B',0.84,24),(172,'BC',0.79,24),(173,'C',0.74,24),(174,'CD',0.69,24),(175,'D',0.60,24),(176,'A',0.94,25),(177,'AB',0.89,25),(178,'B',0.84,25),(179,'BC',0.79,25),(180,'C',0.74,25),(181,'CD',0.69,25),(182,'D',0.60,25),(183,'A',0.92,26),(184,'AB',0.89,26),(185,'B',0.83,26),(186,'BC',0.80,26),(187,'C',0.71,26),(188,'CD',0.68,26),(189,'D',0.65,26),(190,'A',0.94,27),(191,'AB',0.89,27),(192,'B',0.84,27),(193,'BC',0.79,27),(194,'C',0.74,27),(195,'CD',0.69,27),(196,'D',0.60,27),(197,'A',0.94,28),(198,'AB',0.89,28),(199,'B',0.84,28),(200,'BC',0.79,28),(201,'C',0.74,28),(202,'CD',0.69,28),(203,'D',0.60,28);";
		if($con->query($sql) === FALSE){
			echo "Error: " . $sql . "<br>" . $con->error;
		}
	}

?>
</html>