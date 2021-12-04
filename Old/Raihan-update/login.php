<?php
session_start(); // sesion starts

require_once "connection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 
    // Check if username is empty
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter username.";
    } 
	
	else
	{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter your password.";
    } 
	
	else
	{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err))
	{
        // Prepare a select statement, // id is auto generated for example 1 for 1st customer like that.
        $sql = "SELECT id, username, password FROM users WHERE username = ?";  // $sql is database. and its query to check username and password
        
        if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
				{                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    
					if(mysqli_stmt_fetch($stmt))
					{
                        
						if(password_verify($password, $hashed_password))
						{
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");  // for right now we can redirect to main page later we can change this
                        } 
						
						else
						{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } 
				
				else
				{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } 
			
			else
			{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Untitled Document</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet" type="text/css">
	
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
	          <li class="nav-item active"> <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
	          <li class="nav-item active"> <a class="nav-link" href="menu.php">Menu <span class="sr-only">(current)</span></a></li>
	          <li class="nav-item active"> <a class="nav-link" href="reservation.php">Book A Table <span class="sr-only">(current)</span></a></li>
	          <li class="nav-item active"> <a class="nav-link" href="catering.php">Private Events <span class="sr-only">(current)</span></a></li>
				<li class="nav-item active"> <a class="nav-link" href="signup.php">Sign up <span class="sr-only">(current)</span></a></li>
				<li class="nav-item active"> <a class="nav-link" href="login.php">Log In<span class="sr-only">(current)</span></a></li>
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
	    <h1 class="text-center">Welcome Back Guest</h1>
        <h2 class="text-center" >Log in</h2>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		  	<center>
			<input type ="text" name="username" placeholder="Username/Email" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"><br>
            <span class="invalid-feedback"><?php echo $username_err; ?></span>


			<input type ="password" name="pwd" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" ><br><br>
            <span class="invalid-feedback"><?php echo $password_err; ?></span>

			<input type="submit" class="btn btn-primary" value="Login">

            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
			</center>
		  
        </form>
		
		 
        <p class="text-center">&nbsp;</p>
<div class="row">
      
          <div class="col-xl-4"> </div>
          <div class="col-xl-4"></div>
        </div>
		  <br>
		  <br>
		  <br>
<footer>
  <div class="row">
    <div class="col-xl-6">"This is where the logo goes"</div>
    <div class="col-xl-6">Copyright © 2021  All Rights Reserved.</div>
  </div>
</footer>
      </div>
	</div>
	<script src="js/bootstrap-4.4.1.js"></script>
  </body>
</html>