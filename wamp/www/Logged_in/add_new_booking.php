<html>
<!--adding a new reservation on an unused date-->
	<header>
	
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
			
		//begin the session
		session_start();
		
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
		
		?>
		
	</header>
	<body> 
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
		<input type="submit" name="submit" value="Reserve Selected Spaces">
	</form>
	
	<?php
		
		$values = array("'$date'","' '","' '","' '","' '","' '","' '");//values of the periods
		
		
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
		
		

		
	?>
	
	</body>
</html>