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

<!-- Navbar -->
	<header class="navbar navbar-inverse" role="navigation">
	<div class="container">
	<nav role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <img src="http://www.dpcdsb.org/NR/rdonlyres/480AC641-3EE4-46FF-A7E6-BA2852AFD8E7/125452/Panthers.jpg" alt="Mountain View" style="position:relative; TOP:0px; LEFT:-310px; width:50px;height:50px;">
      <a class="navbar-brand" href=""><font color=blue><b> St.Marguerite d'Youville SS.</b></font></a>
    </div>
	

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li  class="active"><a href="index.html"><b>Home</b><span class="sr-only">(current)</span></a></li>
        <li><a href="add_announce.php"><b>Add Announcements</b></a></li>
		<li ><a href="show_announce.php"><b> Show Announcements</b></a></li>
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
	
	
	<?php
			
			//start a session
			session_start();
			//no validation code needed here
			
			//if you are logged in
			if($_SESSION['logged_in'] == true)
			{
				$fullname = $_SESSION['fullname'];
				echo "Welcome $fullname. You are now logged in as a Teacher!";//show that you know the person
			}
			else//redirect back to the login page
			{
				header("Location: ../login.php");
			}
		?>
	
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Welcome to the Homepage</b></h3>
  </div>
  <div class="panel-body">
		<b><p>View Announcements</p></b>
		<ul>
			<li><a href="show_announce.php">View all the announcements for today</a></li>
			<li><a href="show_announce_for_week.php">View all the announcements for this week</a></li>
		</ul>
		<b><p>Edit Announcements</p></b>
		<ul>
			<li><a href="add_announce.php">Add an announcement</a></li>
			<li><a href="Edit_announce_for_week.php">Edit all the announcements for this week</a></li>
			<li><a href="Edit_announce_for_today.php">Edit all the announcements for today</a></li>
		</ul>
		<b><p>Room Booking</p></b>
		<ul>
			<li><a href="book_a_room.php">Book a room</a></li>
			<li><a href="Choose_room.php">Look at booked rooms (Cancel bookings here)</a></li>
		</ul>
		<b><p>Edit Polls</p></b>
		<ul>
			<li><a href="polls_teachers/new_poll.php">Create a poll</a></li>
			<li><a href="polls_teachers/view_polls.php">View all my polls</a></li>
		</ul>
		<br />
		
		
		<a href="Logged_out.php"><button type="submit" class="btn btn-danger">Logout</button></a>
		
		
		</div>
		</div>
		</div>
		
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
	
		
		
		
	</body>
</html>