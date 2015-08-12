<?php
	//start a session!
	session_start();
	
	$url_student = 'Loged_in_student.php';
	$url_teacher = 'Loged_in_teacher.php';
	
	//depending on what type of user, navigate to the required page
	if($_SESSION['user_type'] == 'teacher')
	{
		//go to a new page for teachers
		header("Location: $url_teacher");
		
		//set the session user variable
		//$_SESSION['user_type'] = 'teacher';
	}
	//if person is a student
	else if($_SESSION['user_type'] == 'student')
	{
		//go to a new page for students
		header("Location: $url_student");
		
		//set the session user variable
		//$_SESSION['user_type'] = 'student';
	}
	//if person is an admin
	else if ($_SESSION['user_type'] == 'admin')
	{
		echo 'sorry no Admin controls are available yet';
	}
	else
	{
		echo 'Uhhh.. this is kind of embarrassing we don\'t know what you are :(';
	}
?>