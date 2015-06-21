<html>



<head>
			
			<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">


		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>






		<link rel="stylesheet" href="styles/css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">


</head>



	<header>
	
	
	<!-- Navbar -->
	<header class="navbar-inverse" role="banner">
	<div class="container">
	<nav role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	   <img src="http://www.dpcdsb.org/NR/rdonlyres/480AC641-3EE4-46FF-A7E6-BA2852AFD8E7/125452/Panthers.jpg" alt="Mountain View" style="position:relative; TOP:0px; LEFT:-310px; width:50px;height:50px;">
      <a class="navbar-brand" href="#"><font color=blue><b>St.Marguerite d'Youville SS.</b></font></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="index.html"><b>Home</b></a></li>
        <li><a href="add_announce.php"><b>Add Announcements</b></a></li>
		<li class="active"><a href="show_announce.php"><b> Show Announcements</b><span class="sr-only">(current)</span></a></li>
		<li><a href="book_a_room.php"><b>Computer Lab Booking</b></a></li>
		
		
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
	
	
	
	
	
	
		
	</header>
	<body>
	
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Announcements for the Week</b></h3>
  </div>
  <div class="panel-body">
	
	
	
	
	
	<?php
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//include the date and announcement functions that I will use here 
			include('date_functions.php');
			include('add_all_announce.php');
			
			session_start();
			
			//get the teachers name
			$fullname = $_SESSION['fullname'];
			
			//make a query for announcements from the announcements database
			$sql = "SELECT id, title, body, days_of_week, date_start, date_end, author FROM announcements";
			$result = mysqli_query($db, $sql);
			
			//array values for each day of the week 
			$days = array(0,0,0,0,0);
			
			// set time zone and get the day
			date_default_timezone_set("America/Toronto");
			//echo date("l");
			
			//get current time in time stamp
			$c_time = date("Y/m/d");
			
			//string for demacation
			$demac = " -------------------------------------------*NEW*------*NEW*--------*NEW*------------------------------------------------------------ ";
			
			//announcement string
			$all = "";
			
			
			//get the start and end dates of the week
			$ends = getEndsOfWeek($c_time);
			
			//make an array to hold the id values of all the 
			$idInfo = array();
			//counter for the id of the array place
			$i = 0;
			
		//get data from announcements
		if (mysqli_num_rows($result) > 0) 
			{
				// get the data of announcements for each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					//if the current date is greater than the start date but less than the end date
					if(strtotime($row['date_start']) <= strtotime($ends[1]) && strtotime($row['date_end']) >= strtotime($ends[0]))
					{
						//get relevant information
						$id = $row['id'];
						$days = $row['days_of_week'];
						$title = $row['title'];
						$body = $row['body'];
						$dateEnd = $row['date_end'];
						$dateStart = $row['date_start'];
						$author = $row['author'];
						
						//echo "yes";
						
						if($days[0] == 1 )//if the announcement should air of Monday
						//****Too much code that does the same thing** change to a function
						{
							//bring all the text into one
							$day = 'Monday';
							$all = EditAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[1] == 1 )//if the announcement should air of Tuesday
						{
							//bring all the text into one
							$day = 'Tuesday';
							$all = EditAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[2] == 1 )//if the announcement should air of Wednesday
						{
							//bring all the text into one
							$day = 'Wednesday';
							$all = EditAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[3] == 1 )//if the announcement should air of Thursday
						{
							//bring all the text into one
							$day = 'Thursday';
							$all = EditAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
							//echo $row['days_of_week'];
						}
						
						if($days[4] == 1 )//if the announcement should air of Friday
						{
							//bring all the text into one
							$day = 'Friday';
							$all = EditAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day);
						
						}
						
					}
				
				}
			}
			else 
			{
				echo "Sorry no one has added any announcements yet.";
			}
			
			//useful function
			function EditAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day)
			{
				global $i, $id, $fullname, $author;
				
				//add the id of that announcement to the array under it's counter
				$idInfo[$i] = $id;
				
				//bring all the text into one
				$newAll = $all.
				'<br />'.$demac.
				'</br>'.
				'</br>'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.
				'<br />'."<font size='4'>".$body.
				'</br>'.
				'</br>'. 'Day To Be Aired: '.$day.
				'</br>'.
				'</font>'.
				'</br>'.'Start Date: '.$dateStart.". ".date("l", strtotime($dateStart)).
				'</br>'.'End Date: '.$dateEnd.". ".date("l", strtotime($dateEnd));
				if($fullname == $author)
				{
					$newAll = $newAll.'</br>'.'<a href="Edit_code.php?id='.$id.'"> Edit </a>'
					.'</br>'.'<a href="delete_code.php?id='.$id.'"> Delete </a>';
					
				}
				
				//update the counter
				$i = $i + 1;
				
				//return the sum of all announcements
				return $newAll;
			}
			
			//show news
			//echo "<marquee  behavior='scroll' direction='up' style='text-align:center; margin-left:300px; margin-top:100p' scrollamount='1' height='680' width='700' >
			//		$all</marquee>";
			
			
			echo $all;
		?>

		<br></br>
		<!-- Back button -->
	<form action="Loged_in.php">
			<input type="submit" value="Back to Home" class="btn btn-primary">
		</form>
	
	
	</div>
	</div>
	</div>
	
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
	
	
	
		
	</body>
</html>