<html>

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




	<!-- // Navbar -->
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
        <li><a href="add_announce.php"><b> Add Announcements</b></a></li>
		<li><a href="show_announce.php"><b> Show Announcements</b></a></li>
		<li class="active"><a href="book_a_room.php"><b>Computer Lab Booking</b><span class="sr-only">(current)</span></a></li>
		
		
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>

	
	
		<title>Book A Computer Lab</title>
		
		
		
		</br>
		<?php
		
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//begin the session
			session_start();
			
			
			//store the users full name for later
			$fullname = $_SESSION['fullname'];
			
			
			
		?>
		
	</header>
	
	<body>
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Computer Lab Booking</b></h3>
  </div>
  <div class="panel-body">
	
	
	
	<label>Book a Room</label>
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
			<input name = "date" type="date" id="datepicker" value="2015-MM-DD" min="2000-01-02" max="9999-12-31">
			<!--show date format-->					
			<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
			</br>
			<input type="submit" name="submit" value="Check availability!" class ="btn btn-primary">
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
									$id = $row['id'] ;
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
					
					//debug* echo $id;
				}
				
			}
		
		?>
		
		</div>
		</div>
		</div>
		
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
		
		
	</body>
	
</html>