<html>
	<!--add an new poll-->
	
	<header>
		<?php
		
			//get variables
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//start a session
			session_start();
			
			//get the fullname
			$fullname = $_SESSION['fullname'];
		?>
		
		<h3>Create a new poll</h3>
		
	</header>
	
	<body>
	<!--new poll form-->
	
		<form method="post">
			<p>Poll Question</p> <input type="text" name="question">
			</br>
		</form>
		
	</body>
</html>