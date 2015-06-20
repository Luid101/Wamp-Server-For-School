<?php
//announcement arrangement function
function addAllWeek($all,$demac,$title,$body,$dateStart,$dateEnd,$day)
{
	//bring all the text into one
	$newAll = $all.
	'<br />'.$demac.
	'</br>'.
	'</br>'.'<u>'."<font size='6'>".$title.'</font>'.'</u>'.
	'<br />'."<font size='4'>".$body.
	'</br>'.
	'</br>'. 'Day To Be Aired: '.$day.
	'</br>'.
	'</font>'.
	'</br>'.'Start Date: '.$dateStart.". ".date("l", strtotime($dateStart)).
	'</br>'.'End Date: '.$dateEnd.". ".date("l", strtotime($dateEnd));
	
	//return the sum of all announcements
	return $newAll;
}

function addAllDay($all,$demac,$title,$body)
{
	//bring all the text into one
	$newAll = $all.
	'<br />'.
	$demac.
	'</br>'.
	'</br>'.
	'<u>'.
	"<font size='6'>".$title.'</font>'.
	'</u>'.
	'<br />'.
	"<font size='4'>".$body.'</font>';
	
	//return the sum of all announcements
	return $newAll;
}

?>