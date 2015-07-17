<html>
	<head>
	
	<link rel="stylesheet" href="styles/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	
	
		<?php
			include('db.php');//include our database login file
			
			//start a session
			session_start();
			
			//set a value for if or not we are logged in
			$_SESSION['logged_in'] = false;
			
			//receive data from the form below
			$username = @$_POST['username'];
			$password = @$_POST['password'];
			$submit = @$_POST['submit'];
			$fullname;//save space for the fullname
			
			//check if you are in the database
			$found = false;
			
			//the url that we go to once we are logged in
			$url = 'Logged_in';
			//$url_student = 'Logged_in_student';
			
			//encrypt the password
			$encpassword = md5($password);
			
			//make a query for username and password
			$sql = "SELECT id, username, Password, user_type, fullname FROM users";
			$result = mysqli_query($db, $sql);
			
			
			//when the submit button is clicked
			if($submit)
			{

				if (mysqli_num_rows($result) > 0) 
				{
					// get the data of username and password for each row
					while($row = mysqli_fetch_assoc($result)) 
					{
						//echo  " UName: " . $row['username']." Pword: " . $row['Password']."<br>";
						
						
						
						//check username and password
						if($username == $row['username'] && $encpassword == $row['Password']) 
						{
							//save the users values into the session
							$_SESSION['fullname'] = $row['fullname'];
							
							//set a value for if or not we are logged in
							$_SESSION['logged_in'] = true;
							
							//get the users password
							$_SESSION['password'] = $row['Password'];
							
							//get the users id
							$_SESSION['user_id'] = $row['id'];
							
							//need to send info about what type of users they are
							//if it is a teacher
							if($row['user_type'] == 'teacher')
							{
								//go to a new page for teachers
							    //header("Location: $url_teacher");
								
								//set the session user variable
								$_SESSION['user_type'] = 'teacher';
							}
							//if person is a student
							else if($row['user_type'] == 'student')
							{
								//go to a new page for students
								//header("Location: $url_student");
								
								//set the session user variable
								$_SESSION['user_type'] = 'student';
							}
							//if person is an admin
							else if ($row['user_type'] == 'admin')
							{
								//echo 'sorry no Admin controls are available yet';
								$_SESSION['user_type'] = 'admin';
							}
							else
							{
								echo 'Uhhh.. this is kind of embarrassing we don\'t know what you are :(';
							}
							
							//go to the universal logged in page
							header("Location: $url");
							
							//see if you are in the database
							$found = true;
						}
					} 
					//if you were not found
					if($found == false)
					{
						//tell the bad news
						echo"Sorry we didn't find you in our database";
					}
				}
				else 
				{
					echo "Sorry no one has signed in yet.";
				}
			}
			

		?>
	</head>
	
	
	<!-- Panel -->
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Login</b></h3>
  </div>
  <div class="panel-body">
    <b>Welcome</b><br></br>
	
	
	<body>
		<form method = "post">
			<div class="form-group">
			<!--make a text box for user name-->
			<p><b>Username:</b><br> <input name = "username" type="username" class="form-control" id="exmapleIputEmail1" placeholder="Login ID"><br></p>
			</div>
			
			<!--make a text box for users password-->
			<p><b>Password:</b><br> <input name = "password" type="password" class="form-control" placeholder="Password"><br></p>
			
			<!--make a submit button-->
			<p><input name = "submit" type="submit" class="btn btn-primary" value="Log In"></p>
		</form>
		
		<p><br></p>
		<p><a href="Login.php">Login here.</a></p>
		<p><a href="Register.php">Register here.</a></p>
		</body>
		
		</div>
		</div>
		</div>
		
</html>