<html>
	<header>
		<?php
		
			include('../../db.php');//include our database login file
			include('../../valid.php');//include the validation script
			
			//see if 'id' variable is valid
			if(isset($_GET['id']) && is_numeric($_GET['id']))
			{
				//get the id value
				$id = $_GET['id'];
				
				//delete that entry
				$result = mysqli_query($db,"DELETE FROM polls WHERE id=$id")
				or die("Error: ".mysqli_error($db));
				
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