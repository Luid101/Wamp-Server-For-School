<html>

<head>

		<link rel="stylesheet" href="styles/css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">


</head>



	<header>
		<?php
			include('../db.php');//include our database login file
			include('add_all_announce.php');//functions for announcements
			include('valid.php');//include the validation script
			
			//make a query for announcements from the announcements database
			$sql = "SELECT title, body, days_of_week, date_start, date_end FROM announcements";
			$result = mysqli_query($db, $sql);
			
			//array values for each day of the week 
			$days = array(0,0,0,0,0);
			
			// set time zone and get the day
			date_default_timezone_set("America/Toronto");
			//echo date("l");
			
			//get current time in time stamp
			$c_time =  strtotime(date("Y/m/d"));
			
			//string for demacation
			$demac = " -------------------------------------------*NEW*------*NEW*--------*NEW*------------------------------------------------------------ ";
			
			//announcement string
			$all = "";
			
		//get data from announcements
		if (mysqli_num_rows($result) > 0) 
			{
				// get the data of announcements for each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					
					if(strtotime($row['date_start']) <= $c_time && strtotime($row['date_end']) >= $c_time)
					{
						$days = $row['days_of_week'];
						$title = $row['title'];
						$body = $row['body'];
						
						if(date("l")=="Monday" && $days[0] == 1 )//if the announcement should air of Monday
						{
							//bring all the text into one
							$all = addAllDay($all,$demac,$title,$body);
						}
						
						if(date("l")=="Tuesday" && $days[1] == 1 )//if the announcement should air of Tuesday
						{
							//bring all the text into one
							$all = addAllDay($all,$demac,$title,$body);
						}
						
						if(date("l")=="Wednesday" && $days[2] == 1 )//if the announcement should air of Wednesday
						{
							//bring all the text into one
							$all = addAllDay($all,$demac,$title,$body);
						}
						
						if(date("l")=="Thursday" && $days[3] == 1 )//if the announcement should air of Thursday
						{
							//bring all the text into one
							$all = addAllDay($all,$demac,$title,$body);
						}
						
						if(date("l")=="Friday" && $days[4] == 1 )//if the announcement should air of Friday
						{
							//bring all the text into one
							$all = addAllDay($all,$demac,$title,$body);
						}

					}
				}
			}
			else 
			{
				echo "Sorry no one has added any announcements yet.";
			}
			
			//show news
			echo "<marquee  behavior='scroll' direction='up' style='text-align:center; margin-left:300px; margin-top:100p' scrollamount='1' height='680' width='700' >
				$all</marquee>";
		?>
	</header>
	<body>	
		<form action="Loged_in.php">
			<input type="submit"	value="Back to Home" class="btn btn-primary">
		
		</form>
		
	</body>
</html>