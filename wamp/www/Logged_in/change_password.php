<html>
	<head>
	
	<link rel="stylesheet" href="styles/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	
	
	
	<!--This code is not seen-->
		<?php
			
			//after You have registered you go here
			$url = 'PostRegister.php';
			
			include('../db.php');//include our database login file
			include('valid.php');//include the validation script
			
			$curPass = @$_POST['username'];
			$password = @$_POST['password'];
			$repeatpassword = @$_POST['repeatpassword'];
			$submit = @$_POST['submit'];
			$user_type = @$_POST['user_type'];
			
			//if statements to register
			if ($submit)
			{
				
				if($curPass==true)//if there is a current pass
				{
					
					if($password==true)//if there is a password
					{
					
						
						if($password == $repeatpassword)//if both passwords are the same
						{
							//string length checks
							if(strlen($curPass)< 50)
							{
								//password must be in between 5 and 50
								if(strlen($password) < 50 && strlen($password) > 5) 
								{
									//create the encrypted password
									$encpassword = md5($curPass);
									$encNew = md5($password);
									
									//get the users id
									$user_id = $_SESSION['user_id'];
									
									//if the password entered matches the existing password
									if ($_SESSION['password'] == $encpassword)
									{
										$insert = mysqli_query($db,"UPDATE `users` SET password='$encNew' WHERE id = $user_id")
										or die("it didn't work");
										 
										//echo "Thank You! your information has been added to our database.<br>";
										//echo "Please click one the links below to continue.<br>";
										
										//go to the registered location
										//header("Location: $url");
										echo "it worked";
									}
									else
									echo"Password is wrong";
								}
								else
								{
									echo"password must be in between 5 and 50 characters";
								}
							}
							else
							{
								echo"The Maximum length for User name and full name is 50 characters";
							}
						}
						else
						{
							echo "Passwords don't match<br>";
							echo"<br>";//new line
						}
					
					}
					
				else
				{
					echo "Please input a Password<br>";
					echo"<br>";//new line
				}
			
			}
			else
			{
				echo "Please input a Username<br>";
				echo"<br>";//new line
			}
		}
			
 		?>
	</head>
	<body>
	
	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Change Password</b></h3>
  </div>
  <div class="panel-body">
	
	
		<!--form goes here-->
		<form method="post">
			
			<!--make a text box for user name-->
			<p><b>Current password:</b><br> <input name = "username" type="password" class="form-control"><br></p>
			
			<!--make a text box for users password-->
			<p><b>New Password:</b><br> <input name = "password" type="password" class="form-control"><br></p>
			
			<!--make a text box for the user to repeat his or her password-->
			<p><b>Repeat New Password:</b><br> <input name = "repeatpassword" type="password" class="form-control"><br></p>
			
			<!--make a submit button-->
			<p><input name = "submit" class="btn btn-primary"type="submit" value="Submit"></p>
			
		</form>
		
		<p><br></p>
		<p><a href="../Logged_in"><button type="submit" class="btn btn-primary"> Back to Home</button></a></p>
		
		</div>
		</div>
		</div>
	</body>
</html>