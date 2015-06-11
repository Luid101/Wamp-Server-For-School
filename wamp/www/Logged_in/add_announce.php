<html>
	<header>
		<title>
			Add a new Announcement
		</title>
		
		<h2>
			<u>Add a new Announcement below:</u>
		</h2>
		
		<?php
			include('../db.php');//include our database login file
			
			//get values from the form below
			$submit = @$_POST['submit'];
			$title = @$_POST['title'];
			$body = nl2br( mysqli_real_escape_string($db,@$_POST['body']));
			
			//days of the week
			$monday = @$_POST['monday'];
			$tuesday = @$_POST['tuesday'];
			$wednesday = @$_POST['wednesday'];
			$thursday = @$_POST['thursday'];
			$friday = @$_POST['friday'];
			
			//array values for each day of the week 
			$days = array(0,0,0,0,0);
			$text_days = array('','','','','');
			
			//the days value that goes into the database
			$db_days = "";
			
			//dates
			$start_date = @$_POST['start_date'];
			$end_date = @$_POST['end_date'];
			
			//new date
			//$new_start_date = substr($start_date,8,2), substr($start_date,5,2), substr($start_date,0,4);
			//$new_end_date = substr($end_date,8,2), substr($end_date,5,2), substr($end_date,0,4);
			
			//end url
			$url = 'announce_added.html';
			
			//get sub string
			//echo substr($start_date,8,2);
			
			//if the form has been submitted
			if($submit)
			{
				if($title != "" && $body != "")
				{
					
					//update the values of the array 
					//if any of them are true
					if($monday || $tuesday || $wednesday || $thursday || $friday)
					{ 
						
						//makes sure that the dates are in the right format
						if
						( is_numeric(substr( $start_date,8,2)) || is_numeric(substr($start_date,0,4)) || is_numeric(substr($start_date,5,2)) || is_numeric(substr($end_date,8,2)) || is_numeric(substr($end_date,0,4)) || is_numeric(substr($end_date,5,2)))
						{						
						
							if((($timestamp = strtotime($start_date)) === false) || (($timestamp = strtotime($end_date)) === false))
							{	
								
								echo "dates are out of range</br>";
								//echo "startdate: $start_date</br>";
								//echo "enddate: $end_date</br>";
								
							}
							else
							{
								
								
								if($monday)
								{
									$days[0] = 1;
									$text_days[0] = 'Monday'; 
								}
								
								if($tuesday)
								{
									$days[1] = 1;
									$text_days[1] = 'Tuesday';
								}
								
								if($wednesday)
								{
									$days[2] = 1;
									$text_days[2] = 'Wednesday';
								}
								
								if($thursday)
								{
									$days[3] = 1;
									$text_days[3] = 'Thursday';
								}
								
								if($friday)
								{
									$days[4] = 1;
									$text_days[4] = 'Friday';
								}
								
								//set up the days values to go into the database
								$db_days = implode('',$days);
								//*debug* echo $db_days;
								
								//actually send the values into the database
								$insert = mysqli_query($db,"INSERT INTO announcements (title, body, days_of_week, date_start, date_end) VALUES('$title','$body','$db_days','$start_date','$end_date' )")
								or die("Error".mysqli_error($db));
								
								//header("Location: $url"); *don't uncomment*
								
								echo "Thank You!";
								echo "<br> Your announcement will be shown on the days: </br>"; 
								echo implode(", ",$text_days);
								echo "<br> From $start_date to $end_date </br>";
							
							}
						}
						else
						{
							echo "dates are wrong format";
						}
					}
					else
					{
						echo "None of the days are filled";
					}
				}
				else//if nothing is true
				{
					echo "One or more fields are empty!";
				}
			}
			
		?>
	</header>
	<body>
	
		<!--form goes here-->
		<form method="post">
			
			<!--make a text box for full name-->
			<p>Title:<br> <input name = "title" type="text" style="width: 400px"><br></p><!-- '<br>' are break tags-->
			
			<!--make a text box for user name-->
			<p>
				Body:
				<br> 
					<!--make a new textarea for getting the text values-->
					<textarea name = "body" rows="4"cols="50">
					</textarea>
				<br>
			</p>
			
			<!--Days to be shown-->
			<br>The Announcement will be shown on:</br>
			
			<br>
				
				<!--resaerch what type are checkboxes-->
				<input name = "monday" type="checkbox" > Monday
				<input name = "tuesday" type="checkbox"> Tuesday
				<input name = "wednesday" type="checkbox"> Wednesday
				<input name = "thursday" type="checkbox"> Thursday
				<input name = "friday" type="checkbox"> Friday
			
			</br>
			
			<br>
				<!--date when it will start begin to be shown-->
				<br> The Announcement will be:</br>
				
				<br>
					
					From: <input name = "start_date" type="date" value="2015-MM-DD" >
					<!--show date format-->					
					<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
				</br>
			
				<!--date when it will stop being shown-->
				<br>
					
					To: <input name = "end_date" type="date" value="2015-MM-DD" min="2000-01-02" max="9999-12-31">
					<!--show date format-->					
					<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
				</br>
			</br>
			
			<!--make a submit button-->
			<p><input name = "submit" type="submit" value="Done"></p>
		</form>
		
		<p><a href="Loged_in.php"> Back to Home</a></p>
		
	</body>
</html>