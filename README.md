To run BadgerGrades database, perform the following steps:
1. Create SQL connection in localhost, with username "root" and no password.
2. (optional) If you wish to fill the database with default classes & grades, run the following SQL queries in order:
	a. badgergrades_institution.sql
	b. badgergrades_semester.sql
	c. badgergrades_class.sql
	d. badgergrades_graded_item_type.sql
	e. badgergrades_grading_scale.sql
	f. badgergrades_graded_item.sql
3. Use XAMPP open-source software platform to connect MySQL with PHP.
	a. Download XAMPP here: https://www.apachefriends.org/download.html
	b. Tutorial for connecting MySQL with PHP: https://www.cloudways.com/blog/connect-mysql-with-php/
4. In XAMPP Control Panel, click "Run" buttons next to both "MySQL" and "Apache."
5. Open web browser and enter in address box, "localhost/BadgerGrades".
