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
			<input type="submit" name="submit" value="Show Results" class="btn btn-primary">
		</form>
		
		<?php
		
			//get which room
			$room = @$_POST['room'];
			
			//get the submit function from above
			$submit = @$_POST['submit'];
			
			//make a query for database data depending on what room they are looking for
			$sql = "SELECT `id`, `Date`, `Period_1`, `Period_2`, `Period_3A`, `Period_3B`, `Period_3C`, `Period_4` FROM `room_a` WHERE 1";
			$result = mysqli_query($db, $sql);	
			
			//var for all the data to what will be displayed
			echo '<table border="1" style = "width:80%">
					<tr>
						<th colspan="7"> Bookings </th>
					</tr>
					<tr>
						<th> Date </th>
						<th> Period 1 </th>
						<th> Period 2 </th>
						<th> Period 3a </th>
						<th> Period 3b </th>
						<th> Period 3c </th>
						<th> Period 4 </th>
					</tr>';
			
			//if the form has been submitted
			if($submit)
			{
				//if there are previous dates entered 
				if (mysqli_num_rows($result) > 0) 
				{	
					while($row = mysqli_fetch_assoc($result))
					{
						echo '<tr>'.
								'<td>'.
									$row['Date'].
								'</td>
								<td>'.
									$row['Period_1'];
									//if the name of the booker is equal to the user echo the delete string
									if($row['Period_1'] == $fullname){echo '<a href="cancel_booked_room.php?id='.$row['id'].'&column=Period_1&room='.$room.'"> Cancel </a>';}
						echo	'</td>';
						echo	'<td>'.
									$row['Period_2'];
									//if the name of the booker is equal to the user echo the delete string
									if($row['Period_2'] == $fullname){echo '<a href="cancel_booked_room.php?id='.$row['id'].'&column=Period_2&room='.$room.'"> Cancel </a>';}
						echo	'</td>';
						echo	'<td>'.
									$row['Period_3A'];
									//if the name of the booker is equal to the user echo the delete string
									if($row['Period_3A'] == $fullname){echo '<a href="cancel_booked_room.php?id='.$row['id'].'&column=Period_3A&room='.$room.'"> Cancel </a>';}
						echo	'</td>';
						echo	'<td>'.
									$row['Period_3B'];
									//if the name of the booker is equal to the user echo the delete string
									if($row['Period_3B'] == $fullname){echo '<a href="cancel_booked_room.php?id='.$row['id'].'&column=Period_3B&room='.$room.'"> Cancel </a>';}
						echo	'</td>';
						echo	'<td>'.
									$row['Period_3C'];
									//if the name of the booker is equal to the user echo the delete string
									if($row['Period_3C'] == $fullname){echo '<a href="cancel_booked_room.php?id='.$row['id'].'&column=Period_3C&room='.$room.'"> Cancel </a>';}
						echo	'</td>';
						echo	'<td>'.
									$row['Period_4'];
									//if the name of the booker is equal to the user echo the delete string
									if($row['Period_4'] == $fullname){echo '<a href="cancel_booked_room.php?id='.$row['id'].'&column=Period_4&room='.$room.'"> Cancel </a>';}
						echo	'</td>';
						echo '</tr>';
					}
				}
				else//if there are no previous dates entered
				{
					//the date is not in the database yet
					echo "Nothing has been booked yet";
					
				}
			}
		
		?>
		
		</div>
		</div>
		</div>
		
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
		
	</body>
	
</html>
