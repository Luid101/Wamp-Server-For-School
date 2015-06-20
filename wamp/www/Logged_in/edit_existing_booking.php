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
		include('valid.php');//include the validation script
			
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
		
		//only when the submit button is clicked
		$submit = @$_POST['submit'];
		
		//******-------------------******
		//data unique to the edit existing booking page
		//every already made entry has an id
		$id = $_SESSION['id'];
		
		//make a query for all data for the periods
		$sql = "SELECT * FROM `room_a` WHERE id = $id";
		$result = mysqli_query($db, $sql);
		
		//collect the results from our row
		while($row = mysqli_fetch_assoc($result)){
		
		$period1 = $row['Period_1']; 
		$period2 = $row['Period_2'];
		$period3a = $row['Period_3A'];
		$period3b= $row['Period_3B'];
		$period3c = $row['Period_3C'];
		$period4 = $row['Period_4']; 
		
		
		}
		
		//echo $id;
		
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
				<td><?php if($period1 == ' '){ echo "No";} else{ echo "Yes";} ?></td>
				<td> <?php if($period1 == ' '){ echo "<input name = 'period1' type='checkbox'>";} else{echo "Reserved by $period1";} ?></td>
			</tr>
			<tr>
				<td> Period 2 </td>
				<td> <?php if($period2 == ' '){ echo "No";} else{ echo "Yes";} ?> </td>
				<td> <?php if($period2 == ' '){ echo "<input name = 'period2' type='checkbox'>";} else{echo "Reserved by $period2";} ?></td>
			</tr>
			<tr>
				<td> Period 3A </td>
				<td>  <?php if($period3a == ' '){ echo "No";} else{ echo "Yes";} ?></td>
				<td> <?php if($period3a == ' '){ echo "<input name = 'period3a' type='checkbox'>";} else{echo "Reserved by $period3a";} ?> </td>
			</tr>
			<tr>
				<td> Period 3B </td>
				<td>  <?php if($period3b == ' '){ echo "No";} else{ echo "Yes";} ?></td>
				<td> <?php if($period3b == ' '){ echo "<input name = 'period3b' type='checkbox'>";} else{echo "Reserved by $period3b";} ?> </td>
			</tr>
			<tr>
				<td> Period 3C </td>
				<td>  <?php if($period3c == ' '){ echo "No";} else{ echo "Yes";} ?></td>
				<td> <?php if($period3c == ' '){ echo "<input name = 'period3c' type='checkbox'>";} else{echo "Reserved by $period3c";} ?> </td>
			</tr>
			<tr>
				<td> Period 4 </td>
				<td>  <?php if($period4 == ' '){ echo "No";} else{ echo "Yes";} ?></td>
				<td> <?php if($period4 == ' '){ echo "<input name = 'period4' type='checkbox'>";} else{echo "Reserved by $period4";} ?> </td>
			</tr>
		</table>
		</br>
		<input type="submit" name="submit" value="Reserve Selected Spaces">
	</form>
	
	<?php
		
		$values = array("'$date'","' '","' '","' '","' '","' '","' '");//values of the periods
		
		
		if($submit){
			
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
					//period 1 add value into that column 
					$insert = mysqli_query($db,"UPDATE $room SET Period_1 = '$fullname' WHERE id = '$id' ")
					or die("Error".mysqli_error($db));
					
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period1"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[1])
				{
					//period 2 add value into that column 
					$insert = mysqli_query($db,"UPDATE $room SET Period_2 = '$fullname' WHERE id = '$id' ")
					or die("Error".mysqli_error($db));
					
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period2"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[2])
				{
					
					//period 3a add value into that column 
					$insert = mysqli_query($db,"UPDATE $room SET Period_3A = '$fullname' WHERE id = '$id' ")
					or die("Error".mysqli_error($db));
					
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period3A"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[3])
				{
					//period 3b add value into that column 
					$insert = mysqli_query($db,"UPDATE $room SET Period_3B = '$fullname' WHERE id = '$id' ")
					or die("Error".mysqli_error($db));
					
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period3B"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[4])
				{
					///period 3C add value into that column 
					$insert = mysqli_query($db,"UPDATE $room SET Period_3C = '$fullname' WHERE id = '$id' ")
					or die("Error".mysqli_error($db));
					
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period3C"." has been reserved by ". $fullname."</br>"));
				}
				if($periods[5])
				{
					//period 4 add value into that column 
					$insert = mysqli_query($db,"UPDATE $room SET Period_4 = '$fullname' WHERE id = '$id' ")
					or die("Error".mysqli_error($db));
					
					//send confirmation
					$confamation = $confamation.nl2br( mysqli_real_escape_string( $db,"Period4"." has been reserved by ". $fullname."</br>"));
				}
					
					$val = implode(',',$values);
					//echo $val;
				
					//create a new row
					//$insert = mysqli_query($db,"INSERT INTO $room (Date,Period_1, Period_2, Period_3A, Period_3B, Period_3C, period_4) VALUES($val)")
					//or die("Error".mysqli_error($db));
					
					//done booking
					$_SESSION['booking'] = false; 
					
					//store the conformation into a session slot
					$_SESSION['conformation'] = $confamation;
					
					//go to the end booking page
					header("Location: booking_done.php");
					
					//confirm
					//echo $confamation;
			}
		}

		
		

		
	?>
	
	</body>
</html>