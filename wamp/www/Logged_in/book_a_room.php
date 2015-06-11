<html>
	<header>
	
		<title>Book a date</title>
		
		<text>Book a date:</text>
		
		</br>
		<?php
		
			include('../db.php');//include our database login file
			
			//begin the session
			session_start();
			
			
			//store the users full name for later
			$fullname = $_SESSION['fullname'];
			
			
			
		?>
		
	</header>
	
	<body>
		<form method = "post">
			<!--radio buttons for each room choice-->
			</br>
			<input type="radio" name="room" value = "room_a" checked>Room A
			</br>
			<input type="radio" name="room" value = "room_b">Room B
			</br>
			<input type="radio" name="room" value = "room_c">Room C
			</br>
			</br>
			<input name = "date" type="date" value="2015-MM-DD" min="2000-01-02" max="9999-12-31">
			<!--show date format-->					
			<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
			</br>
			<input type="submit" name="submit" value="Check availability!">
		</form>
		
		<?php
		
			//get which room
			$room = @$_POST['room'];
			//get the date the user entered
			$date = @$_POST['date'];
			
			//get the submit function from above
			$submit = @$_POST['submit'];
			
			//store the booking id
			$id;
			
			
			//does the date already exists
			$date_exist = 0;
			
			//make a query for database data depending on what room they are looking for
			$sql = "SELECT id, Date FROM $room";
			$result = mysqli_query($db, $sql);		
			
			//get current date
			$Curr_date = date('Y-m-d');
			
			//echo strtotime($Curr_date);
			
			//if the form has been submitted
			if($submit)
			{
				
				//see if dates are wrong format
				if (is_numeric(substr( $date,8,2)) && is_numeric(substr($date,0,4)) && is_numeric(substr($date,5,2)))
				{
					//if the dates are in range
					if((($timestamp = strtotime($date)) === false) || (strtotime($date) < strtotime($Curr_date)))
					{
						echo "Dates are out of range. Range(from today to 2030) ";
					}
					else
					{
						//if there are no previous dates entered 
						if (mysqli_num_rows($result) > 0) 
						{
						
							//if it has gotten this far that means that the date checks out
							$date_exist = 2;
							
							// get the date for each row
							while($row = mysqli_fetch_assoc($result)) 
							{
								//if the date has already been entered
								if($row['Date'] == $date)
								{
									$date_exist = 1; 
									$row['id'] = $id;
								}
							}
						}
						else//if there are no previous dates entered
						{
							//the date is not in the database yet
							$date_exist = 2;
							
						}
						
					}
				
				}
				else
				echo"Dates are wrong format";
				
				
				//if the date doesn't exists
				if($date_exist == 2)
				{
					//store the date here
					$_SESSION['date'] = $date;
					$_SESSION['room'] = $room;
					
					//used to make sure that you cant go back after you have booked
					$_SESSION['booking'] = true;
					
					//go to the add new booking location
					header("Location: add_new_booking.php");
				}
				else if($date_exist == 1)
				{
					//store the date here
					$_SESSION['date'] = $date;
					$_SESSION['room'] = $room;
					$_SESSION['id'] = $id;
					
					//used to make sure that you cant go back after you have booked
					$_SESSION['booking'] = true;
					
					//go to the add new booking location
					header("Location: edit_existing_booking.php");
				}
				
			}
		
		?>
		
	</body>
	
</html>