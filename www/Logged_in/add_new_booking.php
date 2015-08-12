<html>
<!--adding a new reservation on an unused date-->

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
        <li><a href="add_announce.php"><b>Add Announcements</b></a></li>
		<li><a href="show_announce.php"> <b>Show Announcements</b></a></li>
		<li class="active"><a href="book_a_room.php"><b>Computer Lab Booking</b><span class="sr-only">(current)</span></a></li>
		<li><a href="polls_teachers/new_poll.php"><b>Create New Polls</b></a></li>
		
		
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
	
	
	
	
		<style>
			table, th, td 
			{
				border: 1px solid black;
			}
			th, td {
				padding: 5px;
			}
			th, td {
				text-align: left;
			}
		</style>
	
		<?php
		
		include('../db.php');//include our database login file
		include('valid.php');//include the validation script
		
		//if a room has been booked
		if($_SESSION['booking'] == false) 
		{
			//return to the booking page
			header("Location: book_a_room.php");
		}
		
		//get which room
		$room = @$_SESSION['room'];
		
		//get the date from the session
		$date = $_SESSION['date'];
		//get name from the session
		$fullname = mysqli_real_escape_string($db,$_SESSION['fullname']);
		
		//this array stores the values for the periods
		$periods = array(false,false,false,false,false,false,false);
		
		//store the values for the checked periods into an array
		$periods[0] = @$_POST['period1'];
		$periods[1] = @$_POST['period2'];
		$periods[2] = @$_POST['period3a'];
		$periods[3] = @$_POST['period3b'];
		$periods[4] = @$_POST['period3c'];
		$periods[5] = @$_POST['period4'];
		
		//tells what has been reserved
		$confamation = "";
		//echo $room;
		
		//only when the submit button is clicked
		$submit = @$_POST['submit'];
		
		?>
		
	</header>
	<body> 
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Computer Lab Booking</b></h3>
  </div>
  <div class="panel-body">
	
	<form method = "post">
	
		<h2>
			You can select from one of the available spaces:
		</h2>
		
		<h3>
			Note: You cannot reserve more than 3 lunch periods!
		</h3>
		
		<table border="1" style = "width:50%">
			<tr>
				<th colspan="3"> Date:<?php echo " $date"; ?> </th>
			</tr>
			<tr>
				<th> Period </th>
				<th> Reserved? </th>
				<th>Reserve now?</th>
			</tr>
			<tr>
				<td> Period 1 </td>
				<td> No.</td>
				<td> <input name = "period1" type="checkbox">Yes</td>
			</tr>
			<tr>
				<td> Period 2 </td>
				<td> No. </td>
				<td> <input name = "period2" type="checkbox" >Yes</td>
			</tr>
			<tr>
				<td> Period 3A </td>
				<td> No.</td>
				<td> <input name = "period3a" type="checkbox" >Yes </td>
			</tr>
			<tr>
				<td> Period 3B </td>
				<td> No.</td>
				<td> <input name = "period3b" type="checkbox" >Yes </td>
			</tr>
			<tr>
				<td> Period 3C </td>
				<td> No. </td>
				<td> <input name = "period3c" type="checkbox" >Yes </td>
			</tr>
			<tr>
				<td> Period 4 </td>
				<td> No.</td>
				<td> <input name = "period4" type="checkbox" >Yes </td>
			</tr>
		</table>
		</br>
		<input type="submit" name="submit" value="Reserve Selected Spaces" class="btn btn-success">
	</form>
	</div>
	</div>
	</div>
	
	<?php
		
		$values = array("'$date'","' '","' '","' '","' '","' '","' '");//values of the periods
		
		if($submit){
			
			//make sure that all three lunch periods are not picked
			if($periods[2] && $periods[2] && $periods[4])
			{
				echo 'You can\'t pick all 3 lunch periods'; 
			}
			//if 3 lunches are not picked
			else
			{
				
				
				if($periods[0])
				{
					//set the value at that point to fullname
					$values[1] = "'".$fullname."'";
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period1"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[1])
				{
					//set the value at that point to fullname
					$values[2] = "'".$fullname."'";
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period2"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[2])
				{
					//set the value at that point to fullname
					$values[3] = "'".$fullname."'";
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period3A"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[3])
				{
					//set the value at that point to fullname
					$values[4] = "'".$fullname."'";
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period3B"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[4])
				{
					//set the value at that point to fullname
					$values[5] = "'".$fullname."'";
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period3C"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[5])
				{
					//set the value at that point to fullname
					$values[6] = "'".$fullname."'";
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period4"." has been reserved by ". $fullname."</br>"));
				}
					
					$val = implode(',',$values);
					//echo $val;
				
					//create a new row
					$insert = mysqli_query($db,"INSERT INTO $room (Date,Period_1, Period_2, Period_3A, Period_3B, Period_3C, period_4) VALUES($val)")
					or die("Error".mysqli_error($db));
					
					//done booking
					$_SESSION['booking'] = false; 
					
					//store the conformation into a session slot
					$_SESSION['conformation'] = $confamation;
					
					//go to the end booking page
					header("Location: booking_done.php");
					
					//confirm
					//echo $confamation;
			}
		}
		

		
	?>
	
	
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
	
	
	</body>
</html>