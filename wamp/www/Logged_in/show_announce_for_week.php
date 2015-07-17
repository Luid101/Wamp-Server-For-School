<html>
<title>Weekly Announcements</title>

<head>

		<link rel="stylesheet" href="styles/css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">


</head>



	<header>
		<?php
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//include the date and announcement functions that I will use here 
			include('date_functions.php');
			include('add_all_announce.php');
			
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
			
			//modified date for use now
			$ddate = '2015-06-12';
			
			//get the start and end dates of the week
			$ends = getEndsOfWeek($ddate);
			
		//get data from announcements
		if (mysqli_num_rows($result) > 0) 
			{
				// get the data of announcements for each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					//if the current date is greater than the start date but less than the end date
					if(strtotime($row['date_start']) <= strtotime($ends[1]) && strtotime($row['date_end']) >= strtotime($ends[0]))
					{
						$days = $row['days_of_week'];
						$title = $row['title'];
						$body = $row['body'];
						$dateEnd = $row['date_end'];
						$dateStart = $row['date_start'];
						
						//echo "yes";
						
						if($days[0] == 1 )//if the announcement should air of Monday
						//****Too much code that does the same thing** change to a function
						{
							//bring all the text into one
							$day = 'Monday';
							$all = addAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[1] == 1 )//if the announcement should air of Tuesday
						{
							//bring all the text into one
							$day = 'Tuesday';
							$all = addAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[2] == 1 )//if the announcement should air of Wednesday
						{
							//bring all the text into one
							$day = 'Wednesday';
							$all = addAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[3] == 1 )//if the announcement should air of Thursday
						{
							//bring all the text into one
							$day = 'Thursday';
							$all = addAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[4] == 1 )//if the announcement should air of Friday
						{
							//bring all the text into one
							$day = 'Friday';
							$all = addAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
						
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
			
			
			//echo $all;
		?>
	</header>
	<body>
		<form action="Loged_in.php">
			<input type="submit"	value="Back to Home" class="btn btn-primary">
		</form>
	</body>
</html>