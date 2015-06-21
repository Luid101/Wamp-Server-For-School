<html>
	<header>
		<?php
		
			include('../../db.php');//include our database login file
			include('../../valid.php');//include the validation script
			
			//see if 'id' variable is valid and 
			if(isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['option']) && is_numeric($_GET['option']) && isset($_GET['newAns']) && is_numeric($_GET['user_id']) && isset($_GET['newAns']))
			{
				//get the USERS ID
				$user_id = $_GET['user_id'];
				
				//get the all needed values
				$id = $_GET['id'];
				$option = $_GET['option'];
				$newAns = $_GET['newAns'];
				
				//update that entry
				$result = mysqli_query($db,"UPDATE `polls` SET `answer$option`=$newAns WHERE id=$id")
				or die("Error: ".mysqli_error($db));
				
				//add the persons name to the table of people that have voted
				$insert = mysqli_query($db,"INSERT INTO `vote_check`(`student_id`, `id_of_poll`) VALUES ('$user_id','$id')")
				or die("Error".mysqli_error($db));
				
				//redirect back to the edit page
				header("Location: view_polls.php");
				
			}
			else
			{
				//show error
				echo " An error occurred (id may not be valid)";
			}
			
		?>
	</header>
	<body>
		
	</body>
</html>