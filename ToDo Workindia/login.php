<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style5.css"/>
</head>
<body>
<?php
    require('db.php');
    session_start();
	$errors = array(); 
    // When form submitted, check and create user session.
    if (isset($_POST['submit'])) {

        $agentid = stripslashes($_REQUEST['agentid']);    // removes backslashes
        $agentid = mysqli_real_escape_string($con, $agentid);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
		
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$encryption_iv = '1234567891011121'; 
		$encryption_key ="todoagent"; 
		$enc_password = openssl_encrypt($password, $ciphering,$encryption_key, $options, $encryption_iv); 
		
        // Check agent exists in the database or not.
        $query    = "SELECT * FROM `users` WHERE agent_id='$agentid'
                     AND password='$enc_password'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['agentid'] = $agentid;
            // Redirect to user dashboard page
            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Oh Shit! Are you really an Agent? \nIncorrect Agent ID / Password !</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Try</a> again.</p>
                  </div>";
        }
		}
	else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Agent Login</h1>
        <input type="text" class="login-input" name="agentid" placeholder="Agent ID" required autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password" required />
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link">Not an Agent? <a href="registration.php">Become an Agent</a></p>
  </form>
<?php
    }
?>	
</body>
</html>
