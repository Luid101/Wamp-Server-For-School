<html>
	<header>
		<?php
		
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//see if 'id' variable is valid
			if(isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['column']) && isset($_GET['room']))
			{
				//get the id value
				$id = $_GET['id'];
				//get column value
				$column = $_GET['column'];
				//get room value
				$room = $_GET['room'];
				
				//remove the text in that column
				$result = mysqli_query($db,"UPDATE $room SET $column = ' ' WHERE id=$id")
				or die("Error: ".mysqli_error($db));
				
				//redirect back to the edit page
				header("Location: Choose_room.php");
				//echo $id." ".$column." ".$room;
				
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