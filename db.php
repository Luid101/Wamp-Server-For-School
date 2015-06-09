<?php
	
	//connect to a server and get a database 
	
	$mysql_hostname = "127.0.0.1";//host computer ip, Localhost
	$mysql_username = "root";//default username of our sql_database
	$mysql_password = "";//default sql password, we dont have one yet
	$mysql_database = "login_register";//name of the sql database
	
	//connect to the datazbase
	$db = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database) 	
	
	// or kill the page if something goes wrong
	or die("Error".mysqli_error($db));
	
	//get the required database
	//mysql_select_db($mysql_database, $db) or die("Database Not Found");

?>	
