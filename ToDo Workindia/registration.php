<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="style5.css"/>
</head>
<body>
<?php
    require('db.php');
	
	$errors = array(); 
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['submit'])) {
        // removes backslashes
        $agentid = stripslashes($_REQUEST['agentid']);//escapes special characters in a string
        $agentid = mysqli_real_escape_string($con, $agentid);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
		
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$encryption_iv = '1234567891011121'; 
		$encryption_key ="todoagent"; 
		$enc_password = openssl_encrypt($password, $ciphering,$encryption_key, $options, $encryption_iv); 
		
        $query    = "INSERT into `users` (agent_id,password)
                     VALUES ('$agentid', '$enc_password')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Agent registered successfully ! </h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
		}
     else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title"> Agent! Register Here !</h1>
		<?php include('errors.php'); ?>
        <input type="text" class="login-input" name="agentid" placeholder="Agent ID" required />
        <input type="password" class="login-input" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link">Already an agent? <a href="login.php">Login here</a></p>
    </form>
<?php
    }
?>
</body>
</html>
