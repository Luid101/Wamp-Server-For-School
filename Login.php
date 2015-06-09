<html>
	<head>
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
			
			//encrypt the password
			$encpassword = md5($password);
			
			//make a query for username and password
			$sql = "SELECT username, Password, fullname FROM users";
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
							
							//supposed to go to a new page
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
	<body>
		<form method = "post">
			<!--make a text box for user name-->
			<p>Username:<br> <input name = "username" type="text"><br></p>
			
			<!--make a text box for users password-->
			<p>Password:<br> <input name = "password" type="password"><br></p>
			
			<!--make a submit button-->
			<p><input name = "submit" type="submit" value="Log In"></p>
		</form>
		
		<p><br></p>
		<p><a href="Login.php">Login here.</a></p>
		<p><a href="Register.php">Register here.</a></p>
		
	</body>
</html>