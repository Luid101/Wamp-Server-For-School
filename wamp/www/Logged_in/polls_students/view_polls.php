<html>
	<!--add an new poll-->
	
	<header>
		<title>Edit all my polls</title>
		<?php
			//get variables
			include('../../db.php');//include our database login file
			include('../valid.php');//include the validation script
			
			//get the USERS ID
			$user_id = $_SESSION['user_id'];
			
			//create an array to store all the options and answers
			$option = [];
			$answer = [];
			
			//make a query for polls from the polls database
			$sql = "SELECT * FROM polls";
			$result = mysqli_query($db, $sql);
			
			//string for demarcation
			$demac = " -------------------------------------------*NEW*------*NEW*--------*NEW*------------------------------------------------------------ ";
			
			//make an array to hold the id values of all the 
			$idInfo = array();
			
			//counter for the id of the array place
			$i = 0;
		?>
	</header>
	
	<body>
		<?php
		
			//get data from polls
			if (mysqli_num_rows($result) > 0) 
			{
				// get the data of polls for each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					//get all relevant info
					$id = $row['id'];
					$question = $row['question'];
					$author = $row['author'];
					
					//options
					$option[0] = $row['option1'];
					$option[1] = $row['option2'];
					$option[2] = $row['option3'];
					$option[3] = $row['option4'];
					$option[4] = $row['option5'];
					$option[5] = $row['option6'];
					$option[6] = $row['option7'];
					$option[7] = $row['option8'];
					$option[8] = $row['option9'];
					$option[9] = $row['option10'];
					
					//answers
					$answer[0] = $row['answer1'];
					$answer[1] = $row['answer2'];
					$answer[2] = $row['answer3'];
					$answer[3] = $row['answer4'];
					$answer[4] = $row['answer5'];
					$answer[5] = $row['answer6'];
					$answer[6] = $row['answer7'];
					$answer[7] = $row['answer8'];
					$answer[8] = $row['answer9'];
					$answer[9] = $row['answer10'];
					
					
					//get the total number of votes
					$total = array_sum($answer);
					
					//remove the possibility of division by zero
					if($total == 0)
					{
						$total = 1;
					}
					
					//make a query in the vote check database
					$sql2 = "SELECT * FROM vote_check";
					$result2 = mysqli_query($db, $sql2);
					
					//not voted until proven voted
					$voted = false;
					
					// get the data of polls for each row
					while($row2 = mysqli_fetch_assoc($result2)) 
					{	
						//if the student has voted before
						if($row2['student_id'] == $user_id)
						{
							if($row2['id_of_poll'] == $id)
							{
								$voted = true;//show that the person has already voted
							}
						}
					}
					
					
					echo $demac;//show a demarcation
					echo "</br>";
					echo $question;//print the question
					echo "</br>";
					//loop through all the options and answers
					for($i = 0; $i < 10; $i++)
					{
						if($option[$i] != "")//if there is an option to show
						{
							if($voted)//if the user has already voted
							{
								//echo the option and answer(in percentage)
								echo $option[$i]." "; 
								$persent = ($answer[$i]/$total)*100;
								echo round($persent)."%";
								echo "</br>";
							}
							else
							{ 
								$newAns = $answer[$i] + 1;
								
								//echo the option and an option to vote
								echo $option[$i]." "; 
								echo '<a href="Vote_poll.php?id='.$id.'&option='.($i + 1).'&newAns='.$newAns.'&user_id='.$user_id.'"> Vote </a>';//send the variable plus 1
								echo "</br>";
								
							}
						}
					}
					
					echo"</br>";
				 
				}
				echo '</br>';
				echo "--------------------------------------------------------Done-------------------------------------------------------------";
			}
			
		?>
		
		<!-- Back button -->
	<form action="../Loged_in.php">
			<input type="submit" value="Back to Home" class="btn btn-primary">
		</form>
	</body>
	
</html>