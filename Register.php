<html>
	<head>
	<!--This code is not seen-->
		<?php
			
			include('db.php');//include our database login file
			
			$fullname = @$_POST['fullname'];//find the "post" of fullname from the form below
			$username = @$_POST['username'];
			$password = @$_POST['password'];
			$repeatpassword = @$_POST['repeatpassword'];
			$submit = @$_POST['submit'];
			
			//password encryption
			$encpassword = md5($password);//this encryption method is not recommended now
			
			//if statements to register
			if ($submit)
			{
				if($fullname==true)//if there is a fullname
				{
				
					if($username==true)//if there is a username
					{
						
						if($password==true)//if there is a password
						{
						
							
							if($password == $repeatpassword)//if both passwords are the same
							{
								//string length checks
								if(strlen($username)< 50 && strlen($fullname) < 50)
								{
									//password must be in between 5 and 50
									if(strlen($password) < 50 && strlen($password) > 5) 
									{
										
										$insert = mysqli_query($db,"INSERT INTO users (fullname, username, password) VALUES('$fullname','$username','$encpassword')")
										or die("it didn't work");
										
										echo "Thank You! your information has been added to our database.<br>";
										echo "Please click one the links below to continue.<br>";
										
										
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
			else
			{
				echo "Please input a Fullname<br>";
				echo"<br>";//new line
			}
		}
			
 		?>
	</head>
	<body>
		<!--form goes here-->
		<form method="post">
			<!--make a text box for full name-->
			<p>Fullname:<br> <input name = "fullname" type="text"><br></p><!-- '<br>' are break tags-->
			
			<!--make a text box for user name-->
			<p>Username:<br> <input name = "username" type="text"><br></p>
			
			<!--make a text box for users password-->
			<p>Password:<br> <input name = "password" type="password"><br></p>
			
			<!--make a text box for the user to repeat his or her password-->
			<p>Repeat Password:<br> <input name = "repeatpassword" type="password"><br></p>
			
			<!--make a submit button-->
			<p><input name = "submit" type="submit" value="Submit"></p>
		</form>
		
		<p><br></p>
		<p><a href="Login.php">Login here.</a></p>
		<p><a href="Register.php">Register here.</a></p>
	</body>
</html>