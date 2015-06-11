<html>
	<header>
		<?php
			//start a session
			session_start();
			
			//reset the value of the logged in session
			$_SESSION['logged_in'] = false;
			
			//$url = "C:\Program Files (x86)\wamp\www\login.php";
			
			echo "You are now logged out!";
			
			//go to the sign in page
			//header("Location: $url");
		?>
		<br/>
		<a href="../login.php">Log in</a>
		</br>
		<a href="../main.html">Main page</a>
	</header>
</html>