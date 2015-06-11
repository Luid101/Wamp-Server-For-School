<?php
	$offset = 0;
	$find = 'string';
	$find_lenght = strlen($find);
	
	$string = 'This is a string, and it is an example.';
	
	//echo strpos($string, $find,10);//two to three arguments, 
	
	while($string_position = strpos($string, $find,$offset))//when something equals zero it can also be false 
	{
		echo '<strong>'.$find.'</strong> Found at '.$string_position.'<br>';
		$offset = $string_position + $find_lenght;
	}
	
?>	
