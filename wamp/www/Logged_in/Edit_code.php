<html>
	
	<head>
			
		<link rel="stylesheet" href="styles/css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		
		<style>
		h4 {
			color: white;
		}
		</style>
		
				
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
      <a class="navbar-brand" href="Loged_in_teacher.php"><font color=blue><b>St.Marguerite d'Youville SS.</b></font></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="index.html"><b>Home</b></a></li>
        <li class="active"><a href="add_announce.php"><b><font color="white"> Edit Announcements</font></b><span class="sr-only">(current)</span></a></li>
		<li><a href="show_announce.php"><b><font color="white"> Show Announcements</font></b></a></li>
		<li><a href="book_a_room.php"><b><font color="white">Computer Lab Booking</font></b></a></li>
		
		
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
	
	
	
	
		<title>
			Add a new Announcement
		</title>
		
		<?php
		
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			//see if 'id' variable is valid
			if(isset($_GET['id']) && is_numeric($_GET['id']))
			{
				//get the id value
				$id = $_GET['id'];
			
			//make a query to get the previous data
			$result = mysqli_query($db,"SELECT * FROM `announcements` WHERE id=$id")
			or die("Error".mysqli_error($db));
			
			$predays = array(0,0,0,0,0);
			
			// get the data of announcements for each row
				while($row = mysqli_fetch_assoc($result)) 
				{
					$pretitle = $row['title'];
					$prebody = $row['body'];
					//predays of the week!
					$predays = $row['days_of_week'];
					$prestart = $row['date_start'];
					$preend = $row['date_end'];
				}
			
			
			//**********************ORIGINAL ADD ANNOUNCEMENT PAGE GOES HERE*******************************//
				//start a session
				session_start();
				
				//get the fullname
				$fullname = $_SESSION['fullname'];
				
				//get values from the form below
				$submit = @$_POST['submit'];
				$title = mysqli_real_escape_string($db,@$_POST['title']);
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
									
									echo "dates are out of range</br>";
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
									$insert = mysqli_query($db,"UPDATE `announcements` SET `title`='$title',`body`='$body',`days_of_week`='$db_days',`date_start`='$start_date',`date_end`='$end_date',`author`='$fullname' WHERE id=$id")
									or die("Error".mysqli_error($db));
									
									//header("Location: $url"); *don't uncomment*
									
									//echo "<h4> Thank You!";
									//echo "<br> Your announcement will be shown on the days: </br>"; 
									//echo implode(", ",$text_days);
									//echo "<br> From $start_date to $end_date </br> </h4>";
									
									$text = "<h4>
												Thank You!".
												"<br> Your announcement will be shown on the days: </br>".
												implode(", ",$text_days).
												"<br> From $start_date to $end_date </br>
											</h4> 
											</br> 
											<a href='Loged_in_teacher.php'> Return</a>";
									
									header("Location: done_page.php?text='.$text.");
								
								}
							}
							else
							{
								echo "<h4> dates are wrong format </h4>";
							}
						}
						else
						{
							echo "<h4> None of the days are filled </h4>";
						}
					}
					else//if nothing is true
					{
						echo "<h4> One or more fields are empty! </h4>";
					}
				}

				
			}
			else
			{
				//show error
				echo "<h4> An error occurred (id may not be valid) </h4>";
			}
			
		?>
	</header>
	<body>
	
	
		<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Edit an Announcement</b></h3>
  </div>
  <div class="panel-body">
	
	
		<!--form goes here-->
		<form method="post">
			
			<!--make a text box for full name-->
			<p>Title:<br> <input name = "title" type="text" style="width: 300px" value= <?php echo "'$pretitle'" ?> ><br></p><!-- '<br>' are break tags-->
			
			<!--make a text box for user name-->
			<p>
				Body:
				<br> 
					<!--make a new textarea for getting the text values-->
					<textarea name = "body">
					<?php echo $prebody ?>
					</textarea>
				<br>
			</p>
			
			<!--Days to be shown-->
			<br>The Announcement will be shown on:</br>
			
			<br>
				
				<!--resaerch what type are checkboxes-->
				<input name = "monday" type="checkbox" <?php if($predays[0]==1){echo "checked";} ?> > Monday
				<input name = "tuesday" type="checkbox" <?php if($predays[1]==1){echo "checked";} ?> > Tuesday
				<input name = "wednesday" type="checkbox" <?php if($predays[2]==1){echo "checked";} ?>> Wednesday
				<input name = "thursday" type="checkbox" <?php if($predays[3]==1){echo "checked";} ?>> Thursday
				<input name = "friday" type="checkbox" <?php if($predays[4]==1){echo "checked";} ?>> Friday
			
			</br>
			
			<br>
				<!--date when it will start begin to be shown-->
				<br> The Announcement will be:</br>
				
				<br>
					
					From: <input name = "start_date" type="text" id="datepicker" value="<?php echo $prestart ?>" >
					<!--show date format-->					
					<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
				</br>
			
				<!--date when it will stop being shown-->
				<br>
					
					To: <input name = "end_date" type="text" id="datepicker2" value="<?php echo $preend ?>" min="2000-01-02" max="9999-12-31">
					<!--show date format-->					
					<font size="2">Format: Year-Month-Day.(e.g; 2012-12-31)</font> 
				</br>
			</br>
			
			<!--make a submit button-->
			<p><input name = "submit" type="submit" value="Done"></p>
		</form>
		
		<p><a href="Loged_in.php"> Back to Home</a></p>
		
		</div>
		</div>
		</div>
		
		<!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="styles/js/bootstrap.min.js"></script>
		
	</body>
	
</html>