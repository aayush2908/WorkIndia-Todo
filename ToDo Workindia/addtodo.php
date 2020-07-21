<?php
	include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Add New ToDo</title>
    <link rel="stylesheet" href="style5.css"/>
</head>
<body>
<?php
    require('db.php');
	$agent=$_SESSION['agentid'];
	$errors = array(); 
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['submit'])) {
        // removes backslashes
        $title = mysqli_real_escape_string($con, $_REQUEST['title']);
        $descrip = mysqli_real_escape_string($con,$_REQUEST['descrip']);
        $ddate = mysqli_real_escape_string($con,$_REQUEST['ddate']);
        $category = mysqli_real_escape_string($con,$_REQUEST['category']);
		
        $query    = "INSERT into `todo` (agent_id,title,descrip,duedate,category)
                     VALUES ('$agent', '$title','$descrip','$ddate','$category')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            header("Location: dashboard.php");
        } else {
            echo "<h3>Required fields are missing.</h3><br/>";
        }
		}
     else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title"> Add New ToDo</h1>
        <input type="text" class="login-input" name="title" placeholder="Title" required />
		<input type="text" class="login-input" name="descrip" placeholder="Description" required />
		<input type="date" class="login-input" placeholder="Due Date"  name="ddate" required />
		<input type="text" class="login-input" name="category" placeholder="Category" required />
        <input type="submit" name="submit" value="Add" class="login-button">
        <p><a href="dashboard.php">Back</a></p>
    </form>
<?php
    }
?>
</body>
</html>
