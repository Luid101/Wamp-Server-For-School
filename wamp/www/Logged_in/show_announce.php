<html>
	<header>
		<?php
			include('../db.php');//include our database login file
			
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
					//strtotime($row['date_start']);
					
					if(strtotime($row['date_start']) <= $c_time && strtotime($row['date_end']) >= $c_time)
					{
						$days = $row['days_of_week'];
						$title = $row['title'];
						$body = $row['body'];
						
						if(date("l")=="Monday" && $days[0] == 1 )//if the announcement should air of Monday
						//****Too much code that does the same thing** change to a function
						{
							//bring all the text into one
							$all = $all.'<br />'.$demac.'</br>'.'</br>'.'</br>'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.'<br />'."<font size='4'>".$body.'</font>';
							//echo $row['days_of_week'];
						}
						
						if(date("l")=="Tuesday" && $days[1] == 1 )//if the announcement should air of Tuesday
						{
							//bring all the text into one
							$all = $all.'<br />'.$demac.'<br />'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.'<br />'."<font size='4'>".$body.'</font>';
							//echo $row['days_of_week'];
						}
						
						if(date("l")=="Wednesday" && $days[2] == 1 )//if the announcement should air of Wednesday
						{
							//bring all the text into one
							$all = $all.'<br />'.$demac.'<br />'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.'<br />'."<font size='4'>".$body.'</font>';
							//echo $row['days_of_week'];
						}
						
						if(date("l")=="Thursday" && $days[3] == 1 )//if the announcement should air of Thursday
						{
							//bring all the text into one
							$all = $all.'<br />'.$demac.'<br />'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.'<br />'."<font size='4'>".$body.'</font>';
							//echo $row['days_of_week'];
						}
						
						if(date("l")=="Friday" && $days[4] == 1 )//if the announcement should air of Friday
						{
							//bring all the text into one
							$all = $all.'<br />'.$demac.'<br />'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.'<br />'."<font size='4'>".$body.'</font>';
							/*
							echo "<marquee  behavior='scroll' direction='up' scrollamount='1'>
									<br>$demac</br>
									<br>$title</br>
									<br>$body</br>
									</marquee>";
							*/
							//echo "<br><marquee  behavior='scroll' direction='up' scrollamount='1'><u>$title</u></marquee></br>";
							//echo "<marquee  behavior='scroll' direction='up' scrollamount='1'>$body</marquee>";
						}
						
						//echo $row['date_start'];
					}
					
					//check all announcements
				    //echo  $row['title'];
					//echo  $row['body'];
					//echo  $row['days_of_week'];
					
					//echo  $row['date_end'];
				
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
		<p><a href="Loged_in.php"> Back to Home</a></p>
	</body>
</html>