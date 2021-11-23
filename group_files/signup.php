<?php
//include the databse file below
require_once "connection.php";

$username = $password = $confirm_password = $mailing_address = $billing_address = $email =  ""; // we intialize variable
$username_err = $password_err = $confirm_password_err = $mailing_address_err = $billing_address_err = $email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	// this will be for username
	if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter a username.";
    }

	elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"])))
	{
        $username_err = "Username can only contain letters, numbers, and underscores.";		// restricted username
	}

	else
	{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql))  // prepare sql statement
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);  // inbuit function
            
            // Set parameters
            $param_username = trim($_POST["username"]);   // trim is inbuilt function remove whitespace
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
				{
                    $username_err = "This username is already taken.";
                } 
				
				else
				{
                    $username = trim($_POST["username"]);
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

	// this will be for password
	if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter a password.";     
    } 
	
	elseif(strlen(trim($_POST["password"])) < 6)
	{
        $password_err = "Password must have atleast 6 characters.";
    } 
	
	else
	{
        $password = trim($_POST["password"]);
    }

	//this will confirm password
	if(empty(trim($_POST["confirm_password"])))
	{
        $confirm_password_err = "Please confirm password.";     
    } 
	
	else
	{
        $confirm_password = trim($_POST["confirm_password"]);
        
		if(empty($password_err) && ($password != $confirm_password))
		{
            $confirm_password_err = "Password did not match.";
        }
    }

	//this will enter the email address
	if(empty(trim($_POST["mailing_address"])))
	{
        $mailing_address_err = "Please enter a valid mailing address.";     
    } 

	else
	{
        $mailing_address = trim($_POST["mailing_address"]);
    }

	// this will enter billing address
	if(empty(trim($_POST["billing_address"])))
	{
        $billing_address_err = "Please enter a valid billing address.";     
    } 

	else
	{
        $billing_address = trim($_POST["billing_address"]);
    }

	// this will take email
	if(empty(trim($_POST["email"])))
	{
        $email_err = "Please enter a valid email.";     
    } 

	else
	{
        $email = trim($_POST["email"]);
    }

	// eneter data in database is remaining
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>