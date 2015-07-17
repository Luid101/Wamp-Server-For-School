<html>
	<head>
	
	<link rel="stylesheet" href="styles/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	
	
	
	<!--This code is not seen-->
		<?php
			
			//after You have registered you go here
			$url = 'PostRegister.php';
			
			include('db.php');//include our database login file
			
			$fullname = @$_POST['fullname'];//find the "post" of fullname from the form below
			$lastname = @$_POST['lastname'];
			$username = @$_POST['username'];
			$submit = @$_POST['submit'];
			$user_type = @$_POST['user_type'];
			
		//if statements to register
		if ($submit)
		{
			if($lastname==true)//if there is a fullname
			{
			
				if($fullname==true)//if there is a fullname
				{
					
						if($username==true)//if there is a username
						{
									//string length checks
									if(strlen($username)< 50 && strlen($fullname) < 50)
									{
											
											//check if the last name and first name combo are in the database
											//get a result of all the names in the database
											$sql2 = "SELECT id, lastname, username, password, user_type, fullname FROM users";
											$result2 = mysqli_query($db, $sql2);
											
											//variable to see if the user is inside
											$inside = false;
											
											// get the data of username and lastname for each row
											while($row = mysqli_fetch_assoc($result2)) 
											{
												//get the id
												$id = $row['id'];
												//get the user type
												$type = $row['user_type'];
												
												
												//if the teachers usertype, lastname and firstname is there
												if( strtolower($user_type) == $type)
												{
													if($lastname == $row['lastname'])
													{
														if($fullname == $row['fullname'])
														{
															//say that it is inside
															$inside = true; 
															
															if($row['password'] == '')
															{
																//get create a new password with the lastname+first initial
																$password = $lastname.substr($fullname,0,1);
																
																//encrypt it!
																$encpassword = md5($password);
																
																$insert = mysqli_query($db,"UPDATE `users` SET username='$username', password='$encpassword' WHERE id = $id")
																or die("it didn't work");
																
																echo "Done";
																//echo "Thank You! your information has been added to our database.<br>";
																//echo "Please click on the links below to continue.<br>";
																
																//go to the registered location
																header("Location: $url");
															}
															else
															echo "you have already registered";
															
														}
														//else
														//echo"firstname not there";
														
													}
													//else
													//echo "lastname not there";
												}
												//else
												//echo "user type not there";
											}
											if($inside == false)
											{
												echo "<font color = 'red'><B>You are not in the database!</b></font>";
											}
									}
									else
									{
										echo"The Maximum length for User name and full name is 50 characters";
									}
						}
					else
					{
						echo "Please input a Username<br>";
						echo"<br>";//new line
					}
				}
				else
				{
					echo "Please input a First Name<br>";
					echo"<br>";//new line
				}
			}
			else
			echo "Please input a Last Name<br>";
		}
			
 		?>
	</head>
	<body>
	
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Welcome to the Homepage</b></h3>
  </div>
  <div class="panel-body">
	
	
		<!--form goes here-->
		<form method="post">
			<!--make a text box for last name-->
			<p><b>Last Name:</b><br> <input name = "lastname" type="text" class="form-control"><br></p><!-- '<br>' are break tags-->
			
			<!--make a text box for full name-->
			<p><b>First Name:</b><br> <input name = "fullname" type="text" class="form-control"><br></p><!-- '<br>' are break tags-->
			
			<!--make a text box for user name-->
			<p><b>Username:</b><br> <input name = "username" type="text" class="form-control"><br></p>
			
			<!--make a submit button-->
			<p><input name = "submit" class="btn btn-primary"type="submit" value="Submit"></p>
			
			<!--radio button for user type-->
			<br>
			<b>User Type:</b>
			<br>
			<input type="radio" name="user_type" value="teacher">Teacher
			<br>
			<input type="radio" name="user_type" value="student" checked>Student
			
		</form>
		
		<p><br></p>
		<p><a href="Login.php">Login here.</a></p>
		<p><a href="Register.php">Register here.</a></p>
		
		</div>
		</div>
		</div>
	</body>
</html>