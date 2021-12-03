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
		
	
        <br><br>
        <div class="container">
        <h3 class="text-center"><br>New Reservation<br></h3>   
        <div class="row">
        <div class="col-md-6 offset-md-3"> 
    </head> 
    
    <body>
        <div class="signup-form">
            <form action="reservation.php" method="post">
            
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" required="required">
                <small class="form-text text-muted">Name must be 2-20 characters long</small>
            </div> 
            
            <div class="form-group">
                <label>Enter Date</label>
                <input type="date" class="form-control" name="date" id="date" placeholder="Date" required="required" onchange="showHint()">
            </div>
        
            <div class="form-group">
                <label>Enter Time Zone</label>
                <select class="form-control" name="time" id="time" onchange="showHint()">
                <option>16:00 - 17:00</option>
                <option>17:00 - 18:00</option>
                <option>18:00 - 19:00</option>
                <option>19:00 - 20:00</option>
                <option>20:00 - 21:00</option>
                <option>21:00 - 22:00</option>
                </select>
            </div>
			
			<div> 
				Available Seats: <span id="txtSeat"></span>
			</div>
        
            <div class="form-group">
                <label>Enter number of Guests</label>
                <input type="number" class="form-control" min="1" name="num_guests" id="num_guests" placeholder="Guests" required="required" onchange="showHint()">
                <small class="form-text text-muted">Minimum value is 1</small>
            </div>
        
            <div class="form-group">
                <label for="guests">Enter your Telephone Number</label>
                <input type="telephone" class="form-control" name="tele" placeholder="Telephone" required="required">
                <small class="form-text text-muted">Telephone must be 6-20 characters long</small>
            </div>
        
            <div class="form-group">
                <label for="email">Enter your Email</label>
                <input type="email" class="form-control" name="email" placeholder="email" required="required">
                <small class="form-text text-muted">Email should have @</small>
            </div>        
        
            <div class="form-group">
                <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
            </div>
            
            <div class="form-group">
                <button type="submit" name="reserv-submit" class="btn btn-dark btn-lg btn-block">Submit Reservation</button>
            </div>
            <p> Choose the table <a href="table.php">choose your table</a></p>
            </form>
            <br><br>
        </div>
    </body>
</html>