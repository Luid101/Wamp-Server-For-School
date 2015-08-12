<?php
		//start a session
		session_start();
		
		//if you are logged in
		if($_SESSION['logged_in'] == true)
		{
			//this is a valid user
		}
		else//redirect back to the login page
		{
			header("Location: ../login.php");
		}
?>