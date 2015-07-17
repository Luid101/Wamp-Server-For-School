<html>
<title>Student Homepage</title>
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
        <li  class="active"><a href="Loged_in_student.php"><b>Home</b><span class="sr-only">(current)</span></a></li>
        <li><a href="#forums"><b>Forum</b></a></li>
		<li><a href="polls_students/view_polls.php"><b>Polls</b></a></li>
		
		
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
			include('valid.php');//include the validation script
			
			//if you are logged in
			if($_SESSION['logged_in'] == true)
			{
				$fullname = $_SESSION['fullname'];
				echo "Welcome $fullname. You are now logged in as a student!";//show that you know the person
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
	
	<b><p>Other</p></b>
	
	
	
		<ul>
			<li><a href="#forums">Enter the forums</a></li>
			<li><a href="polls_students/view_polls.php">View the polls</a></li>
		</ul>
		<br /><!--new line-->
		<a href="Logged_out.php"><button type="submit" class="btn btn-danger">Logout</button></a>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
		
	</body>
</html>