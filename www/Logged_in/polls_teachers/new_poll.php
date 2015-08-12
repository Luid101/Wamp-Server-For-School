<html>
	
	
	<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">


		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../styles/css/bootstrap.min.css">
		<link rel="stylesheet" href="../style.css">


</head>
	
	<header class="navbar navbar-inverse" role="navigation">
	<div class="container">
	<nav role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <img src="http://www.dpcdsb.org/NR/rdonlyres/480AC641-3EE4-46FF-A7E6-BA2852AFD8E7/125452/Panthers.jpg" alt="Mountain View" style="position:relative; TOP:0px; LEFT:-310px; width:50px;height:50px;">
      <a class="navbar-brand" href=""><font color=blue><b> St.Marguerite d'Youville SS.</b></font></a>
    </div>
	

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li  ><a href="../index.html"><b>Home</b></a></li>
        <li><a href="../add_announce.php"><b>Add Announcements</b></a></li>
		<li ><a href="../show_announce.php"><b> Show Announcements</b></a></li>
		<li><a href="../book_a_room.php"><b>Computer Lab Booking</b></a></li>
		<li class="active"><a href="new_poll.php"><b>Create New Polls</b><span class="sr-only">(current)</span></a></li>
		
		
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
	</header>
		
	
	<body>
	<!--add an new poll-->
	<title>Add a new poll</title>
		<?php
		
			//get variables
			include('../../db.php');//include our database login file
			include('../valid.php');//include the validation script
			
			//session_start() already included in the above file^^
			
			//warning variable to be shown at the end
			$warning = "";
			
			//get the fullname
			$fullname = $_SESSION['fullname'];
			
			//create an array to store all the options and answers
			$option = [];
			
			//get the variables from below
			$submit = @$_POST['submit'];
			$question = @$_POST['question'];
			$option[0] = @$_POST['option1'];
			$option[1] = @$_POST['option2'];
			$option[2] = @$_POST['option3'];
			$option[3] = @$_POST['option4'];
			$option[4] = @$_POST['option5'];
			$option[5] = @$_POST['option6'];
			$option[6] = @$_POST['option7'];
			$option[7] = @$_POST['option8'];
			$option[8] = @$_POST['option9'];
			$option[9] = @$_POST['option10'];
			
			if($submit)//when the submit button is clicked
			{
				//check if the question field is empty
				if($question != "")
				{
					//check if option 1 and 2 are empty
					if($option[0] != "" && $option[1] != "")
					{
						
						$query = "INSERT INTO `polls`(`question`,`author`";
						
						//loop through all the options
						for($i = 0; $i < 10; $i++)
						{
							if($option[$i] != "")//add all the options
							{
								$query = $query.", option".($i + 1);
							}
						}
						
						$query = $query.") VALUES ('$question','$fullname'";
						
						//loop through all the options
						for($i = 0; $i < 10 ; $i++)
						{
							if($option[$i] != "")//add all the options
							{
								$query = $query.", '$option[$i]'";
							}
						}
						
						$query = $query.")";
						
						//actually send the values into the database
						$insert = mysqli_query($db,$query)
						or die("Error".mysqli_error($db));
						
						//echo $query;
						
						echo"<font size='5' color='green'> You poll has been added! </font>";
					}
					else
					$warning = "The first 2 fields are empty!";
				}
				else
				$warning = "The question field is empty";
			}
		?>
		
		
		

	
	<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><b>Create a New Poll</b></h3>
  </div>
  <div class="panel-body">
	<!--new poll form-->
	
		<form method="post">
			<p><b>Poll Question:</b></p> <input type="text" name="question">
			</br>
			</br>
			<font size="2" color="red">Note the maximum amount of options is 10!</font>
			</br>
			<font size="2" color="red"> You can have a minimum of 2 options.</font>
			</br>
			<font size="2" color="red"> Please put them in order! Don't skip options.</font>
			</br>
			</br>
			<p>Poll Option 1:</p> <input type="text" name="option1">
			<p>Poll Option 2:</p> <input type="text" name="option2">
			<p>Poll Option 3:</p> <input type="text" name="option3">
			<p>Poll Option 4:</p> <input type="text" name="option4">
			<p>Poll Option 5:</p> <input type="text" name="option5">
			<p>Poll Option 6:</p> <input type="text" name="option6">
			<p>Poll Option 7:</p> <input type="text" name="option7">
			<p>Poll Option 8:</p> <input type="text" name="option8">
			<p>Poll Option 9:</p> <input type="text" name="option9">
			<p>Poll Option 10:</p> <input type="text" name="option10">
			<br></br>
			<!--make a submit button-->
			<p><input name = "submit" type="submit" class="btn btn-success" value="Make new poll"></p>
			</div>
			</div>
			</div>
		</form>
		
		<?php
			//echo the warning variable
			if($warning != "")
			{
				echo "<font size='5' color='red'>"."WARNING: ".$warning."</font>";
			}
		?>
		
		<p><a href="../Loged_in.php"><button type="submit" class="btn btn-primary"> Back to Home</button></a></p>
		
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="styles/js/jquery.min.js"></script><script src="../styles/js/bootstrap.min.js"></script>
		
	</body>
</html>