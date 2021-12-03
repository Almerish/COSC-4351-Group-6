<?php

require "connection.php";

if(isset($_SESSION['id']))      // we have set id and username to Session variable   //isset will check if the variable is not null
{
    echo '<p class="text-white bg-dark text-center">Welcome '. $_SESSION['username'] .', Create your reservation here!</p>';
}

function between($val, $x, $y)      // function to decide the value is correct or not
{
    $val_len = strlen($val);
    return ($val_len >= $x && $val_len <= $y)?TRUE:FALSE;
}

$all_error = $name_error = $guests_error = $tele_error = $email_error = ""; 


session_start();

if(isset($_POST['reserv-submit']))  //use button name = reserv-submit in html doc below
{
            // we can add user id = $session['id] but i have to check how it work
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time= $_POST['time'];
    $guests= $_POST['num_guests'];
    $tele = $_POST['tele'];
    $email = $_POST['email'];
    
    if($guests==1 || $guests==2)
    {
        // figure out how to arrange tables and wether we give them post variable or not
    }

    if(empty($name) || empty($date) || empty($time) || empty($guests) || empty($tele) ||empty($email))
    {
        $all_error = "fields cannot be empty";
    }

    elseif(!preg_match("/^[a-zA-Z ]*$/",$name) || !between($name,2,20))          // we can try this or we can do the between function.
    {
        $name_error = "please enter valid name";
    }

    elseif(!preg_match("/^[0-9]*$/", $guests))
    {
        $guests_error = "please enter number of guest";
    }

    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $tele) || !between($tele,6,20))
    {
        $tele_error = "please enter valid number";
    }

    elseif(!preg_match("/^[a-zA-Z0-9@]*$/", $email) || !between($email,6,20))           // i tried this if error comes we can remove it
    {
        $tele_error = "please enter valid email";
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Casa Nostra</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet" type="text/css">
	  
	<script>
		function showHint() {
			var date = document.getElementById("date");
			var strDate = date.value; <!-- options[e.selectedIndex].text -->
			if (strDate.length == 0) {
				document.getElementById("txtSeat").innerHTML = "No date selected";
				return;
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
				  if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtSeat").innerHTML = this.responseText;
				  }
				};
				var time = document.getElementById("time");
				var strTime = time.options[time.selectedIndex].text;
				let temp = strTime.split(" ")
				var strTemp = strDate + " " + temp[0]
				var numGuests = document.getElementById("num_guests");
				var strNum = numGuests.value;
				var strTemp = 13
				xmlhttp.open("GET", "table.php?q=" + strNum, true);
				xmlhttp.send();
			}
		}
		</script>
  </head>
  <body>
  	<!-- body code goes here -->


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="js/jquery-3.4.1.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/popper.min.js"></script> 
	<div class="container-fluid">
	  <div class="container">
	    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="#"><img src="images/logo.jpg" width="250" height="150" alt=""/></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
	      <div class="collapse navbar-collapse" id="navbarSupportedContent1">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"> <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a> </li>
	          <li class="nav-item active"> <a class="nav-link" href="menu.html">Menu <span class="sr-only">(current)</span></a></li>
	          <li class="nav-item active"> <a class="nav-link" href="reservations.html">Book A Table <span class="sr-only">(current)</span></a></li>
	          <li class="nav-item active"> <a class="nav-link" href="catering.html">Private Events <span class="sr-only">(current)</span></a></li>
				<li class="nav-item active"> <a class="nav-link" href="signup.html">Sign up <span class="sr-only">(current)</span></a></li>
				<li class="nav-item active"> <a class="nav-link" href="login.html">Log In<span class="sr-only">(current)</span></a></li>
            </ul>
	        <form class="form-inline my-2 my-lg-0">
            </form>
          </div>
        </nav>
	    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel" style="background-color: grey">
	      <ol class="carousel-indicators">
	        <li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
	        <li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
	        <li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
          </ol>
	      <div class="carousel-inner" role="listbox">
	        <div class="carousel-item active"> <img src="images/1.jpg" alt="First slide" class="d-block mx-auto">
	          <div class="carousel-caption">
              </div>
            </div>
	        <div class="carousel-item"> <img class="d-block mx-auto" src="images/2.jpg" alt="Second slide">
	          <div class="carousel-caption">
              </div>
            </div>
	        <div class="carousel-item"> <img class="d-block mx-auto" src="images/3.jpg" alt="Third slide">
	          <div class="carousel-caption">
              </div>
            </div>
		    <div class="carousel-item"> <img class="d-block mx-auto" src="images/4.jpg" alt="Second slide">
	          <div class="carousel-caption">
              </div>
            </div>
          </div>
	      <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
	    <h1 class="text-center">&nbsp;</h1>
	    <h1 class="text-center">Reserve Your Table</h1>
        <p class="text-center">&nbsp;</p>

 <div class="row">
    <?php
	$sql = "SELECT * FROM reservations WHERE (date = '$date' AND time= '$time');";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	
	if($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)){
echo "Your Reservation is confirmed! Here's your details: " . "<br>";
echo "<label>Reservation ID: </label>" . $row['reservation_id'] . "<br>";
echo "<label>Name: </label>" . $row['name'] . "<br>";
echo "<label>Date: </label>" . $row['date'] . "<br>";
echo "<label>Time: </label>" . $row['time'] . "<br>";
echo "<label>Number of guest: </label>" . $row['num_of_guests'] . "<br>";
echo "<label>Contact Information: </label>" . $row['phone_num'] . "<br>";
echo "<label>Diner ID (if applicable): </label>" . $row['preferred_diner_id'] . "<br>";

		}
	}
?>

  </div>

		  
		  <br>
		  <br>
		  <br>
<footer>
  <div class="row">
    <div class="col-xl-6"><img src="images/logo.jpg" width="125" height="75" alt=""/></div>
    <div class="col-xl-6">Copyright © 2021  All Rights Reserved.</div>
  </div>
</footer>
      </div>
	</div>
	<script src="js/bootstrap-4.4.1.js"></script>
  </body>
</html>






