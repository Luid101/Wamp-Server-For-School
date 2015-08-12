<?php
//this function has date funtions that I will use in my other programs

//this function gets a week number from a date
function getWeekNumber($ddate)
{
	$date = new DateTime($ddate);
	$week = $date->format("W");
	return $week;
}

//function gets the end and start dates of a week from a week number
function getStartAndEndDate($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*$week)+1-$day)*24*3600;
    $return[0] = date('Y-m-d', $time);
    $time += 6*24*3600;
    $return[1] = date('Y-m-d', $time);
    return $return;
}

//function that gets the date and returns the end dates of the week that date is inside
function getEndsOfWeek($ddate)
{
	
	//create a date
	$time = strtotime($ddate);
	$date = date('Y-m-d',$time);
	
	$year = date('Y', strtotime($ddate)); 
	//echo '</br>';
	
	//get the week number
	$weekNum = getWeekNumber($date);
	
	//echo "$weekNum.</br>";
	
	//use the week number to get the ends of the week
	$ends = getStartAndEndDate(($weekNum-1),$year);
	//return the array value
	return $ends;
}

//function that gets the end and start date of the current day 	
function getCurrentEnds()
{	
	// set time zone and get the day
	//date_default_timezone_set("America/Toronto");
	
	//get current time in time stamp
	//*****change this date to get a different as a measurement day*****
	$c_time =  date("Y/m/d");
	//echo $c_time;

	$week_array = getEndsOfWeek($c_time);
    return $week_array;
}
	/*
	$ends = getCurrentEnds();
	echo $ends[0];
	echo "</br>";
	echo $ends[1];
	*/
?>