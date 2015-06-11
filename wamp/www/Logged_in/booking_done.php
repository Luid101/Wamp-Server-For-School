<html>
	<header>
		<?php
			//start a session
			session_start();
			
			//Get the periods that were booked
			$confamation = $_SESSION['conformation'];
			
			//$url = "C:\Program Files (x86)\wamp\www\login.php";
			
			echo $confamation;
			
			//go to the sign in page
			//header("Location: $url");
		?>
		<br/>
		<a href="Loged_in_teacher.php">Back To Home</a>
	</header>
</html>