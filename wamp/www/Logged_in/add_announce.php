<html>
	<!doctype html>
	<html lang="en">
	<head>
			
			<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--date picker-->
				  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
				  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
				  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
				  <link rel="stylesheet" href="/resources/demos/style.css">
				  <script>
				  
				  $(function() {
					$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd' });
				  });
				   $(function() {
					$( "#datepicker2" ).datepicker({dateFormat: 'yy-mm-dd' });
				  });
				  </script>
				<!--date picker-->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	
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
      <a class="navbar-brand" href="Loged_in_teacher.php"><font color=blue><b>St.Marguerite d'Youville SS.</b></font></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="index.html"><b>Home</b></a></li>
        <li class="active"><a href="add_announce.php"><b> Add Announcements</b><span class="sr-only">(current)</span></a></li>
		<li><a href="show_announce.php"><b> Show Announcements</b></a></li>
		<li><a href="book_a_room.php"><b>Computer Lab Booking</b></a></li>
		
		
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
	
	
	
	
		<b><title>
			Add a New Announcement
		</title></b>
	</header>
	<body>
	
	<?php
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//start a session
			session_start();
			
			//get the fullname
			$fullname = $_SESSION['fullname'];
			
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
								
								echo "<h4>dates are out of range</h4></br>";
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
								$insert = mysqli_query($db,"INSERT INTO announcements (title, body, days_of_week, date_start, date_end,author) VALUES('$title','$body','$db_days','$start_date','$end_date', '$fullname')")
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
							echo "<h4>dates are wrong format</h4>";
						}
					}
					else
					{
						echo "<h4>None of the days are filled</h4>";
					}
				}
				else//if nothing is true
				{
					echo "<h4>One or more fields are empty!</h4>";
				}
			}
			
		?>
	
		<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Add an Announcement</b></h3>
  </div>
  <div class="panel-body">
	
	
		<!--form goes here-->
		<form method="post">
			
			<!--make a text box for full name-->
			<p><b>Title:</b><br> <input name = "title" type="text" style="width: 200px"><br></p><!-- '<br>' are break tags-->
			
			<!--make a text box for user name-->
			<p>
				<b>Body:</b>
				<br> 
					<!--make a new textarea for getting the text values-->
					<textarea name = "body" >
					</textarea>
				<br>
			</p>
			
			<!--Days to be shown-->
			<br><b>The Announcement will be shown on:</b></br>
			
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
				<br> <b>The Announcements will be:</b></br>
				
				<br>
					
					From: <input name = "start_date" type="text" id="datepicker" value="2015-MM-DD" />
					<!--show date format-->					
					<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
				</br>
			
				<!--date when it will stop being shown-->
				<br>
					
					To: <input name = "end_date" type="text" id="datepicker2" value="2015-MM-DD" min="2000-01-02" max="9999-12-31"/>
					<!--show date format-->					
					<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
				</br>
			</br>
			
			<!--make a submit button-->
			<p><input name = "submit" type="submit" value="Done" class ="btn btn-primary"></p>
		</form>
		
		<p><a href="Loged_in.php"> Back to Home</a></p>
		
		</div>
		</div>
		</div>
		
		
		
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
		
	</body>
</html>