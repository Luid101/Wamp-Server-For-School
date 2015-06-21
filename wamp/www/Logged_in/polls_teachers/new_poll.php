<html>
	<!--add an new poll-->
	
	<header>
		<title>Add a new poll</title>
		<?php
		
			//get variables
			include('../../db.php');//include our database login file
			include('../valid.php');//include the validation script
			
			//session_start() already included in the above file^^
			
			//warning variable to be shown at the end
			$warning = "";
			
			//get the fullname
			$fullname = $_SESSION['fullname'];
			
			//create an array to store all the options and answers
			$option = [];
			
			//get the variables from below
			$submit = @$_POST['submit'];
			$question = @$_POST['question'];
			$option[0] = @$_POST['option1'];
			$option[1] = @$_POST['option2'];
			$option[2] = @$_POST['option3'];
			$option[3] = @$_POST['option4'];
			$option[4] = @$_POST['option5'];
			$option[5] = @$_POST['option6'];
			$option[6] = @$_POST['option7'];
			$option[7] = @$_POST['option8'];
			$option[8] = @$_POST['option9'];
			$option[9] = @$_POST['option10'];
			
			if($submit)//when the submit button is clicked
			{
				//check if the question field is empty
				if($question != "")
				{
					//check if option 1 and 2 are empty
					if($option[0] != "" && $option[1] != "")
					{
						
						$query = "INSERT INTO `polls`(`question`,`author`";
						
						//loop through all the options
						for($i = 0; $i < 10; $i++)
						{
							if($option[$i] != "")//add all the options
							{
								$query = $query.", option".($i + 1);
							}
						}
						
						$query = $query.") VALUES ('$question','$fullname'";
						
						//loop through all the options
						for($i = 0; $i < 10 ; $i++)
						{
							if($option[$i] != "")//add all the options
							{
								$query = $query.", '$option[$i]'";
							}
						}
						
						$query = $query.")";
						
						//actually send the values into the database
						$insert = mysqli_query($db,$query)
						or die("Error".mysqli_error($db));
						
						//echo $query;
						
						echo"<font size='5' color='green'> You poll has been added! </font>";
					}
					else
					$warning = "The first 2 fields are empty!";
				}
				else
				$warning = "The question field is empty";
			}
		?>
		
		<h3>Create a new poll</h3>
		
	</header>
	
	<body>
	<!--new poll form-->
	
		<form method="post">
			<p>Poll Question:</p> <input type="text" name="question">
			</br>
			</br>
			<font size="2" color="red">Note the maximum amount of options is 10!</font>
			</br>
			<font size="2" color="red"> You can have a minimum of 2 options.</font>
			</br>
			<font size="2" color="red"> Please put them in order! Don't skip options.</font>
			</br>
			<p>Poll Option 1:</p> <input type="text" name="option1">
			<p>Poll Option 2:</p> <input type="text" name="option2">
			<p>Poll Option 3:</p> <input type="text" name="option3">
			<p>Poll Option 4:</p> <input type="text" name="option4">
			<p>Poll Option 5:</p> <input type="text" name="option5">
			<p>Poll Option 6:</p> <input type="text" name="option6">
			<p>Poll Option 7:</p> <input type="text" name="option7">
			<p>Poll Option 8:</p> <input type="text" name="option8">
			<p>Poll Option 9:</p> <input type="text" name="option9">
			<p>Poll Option 10:</p> <input type="text" name="option10">
			<!--make a submit button-->
			<p><input name = "submit" type="submit" value="Make new poll"></p>
		</form>
		
		<?php
			//echo the warning variable
			if($warning != "")
			{
				echo "<font size='5' color='red'>"."WARNING: ".$warning."</font>";
			}
		?>
		
		<p><a href="../Loged_in.php"> Back to Home</a></p>
		
	</body>
</html>