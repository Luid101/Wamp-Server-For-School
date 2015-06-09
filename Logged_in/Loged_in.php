<html>

	<header>
		<?php
			
			//start a session
			session_start();
			
			//if you are logged in
			if($_SESSION['logged_in'] == true)
			{
				$fullname = $_SESSION['fullname'];
				echo "Welcome $fullname. You are now logged in";//show that you know the person
			}
			else//redirect back to the login page
			{
				header("Location: ../login.php");
			}
		?>
	</header>

	<body>
		<ul>
			<li><a href="add_announce.php">Add an announcement</a></li>
			<li><a href="show_announce.php">View all the announcements for today</a></li>
		</ul>
		<br /><!--new line-->
		<a href="Logged_out.php">Log Out</a><!-->
	</body>
</html>