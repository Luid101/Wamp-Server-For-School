<html>

	<header>
		<?php
			
			//start a session
			session_start();
			
			//if you are logged in
			if($_SESSION['logged_in'] == true)
			{
				$fullname = $_SESSION['fullname'];
				echo "Welcome $fullname. You are now logged in as a student!";//show that you know the person
			}
			else//redirect back to the login page
			{
				header("Location: ../login.php");
			}
		?>
	</header>

	<body>
		<ul>
			<li><a href="#forums">Enter the forums</a></li>
			<li><a href="polls_students/view_polls.php">View the polls</a></li>
		</ul>
		<br /><!--new line-->
		<a href="Logged_out.php">Log Out</a><!-->
	</body>
</html>