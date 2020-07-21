<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
$agentid=$_SESSION['agentid'];
require('db.php');
//Deleting a todo task;
if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($con, "DELETE FROM todo WHERE id=".$id);
		header('location: dashboard.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="style5.css" />
</head>
<body>
    <div class="list">
	<h1><u> Your ToDo List </u></h1><br>
        <center><p>Hey, Agent <?php echo $agentid; ?>!</p></center>
		<?php
			$query    = "SELECT * FROM `todo` WHERE agent_id='$agentid' ORDER BY duedate ASC";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows > 0) 
		{
			while($info = mysqli_fetch_array($result)) 
			{
				echo "<div class='card'>";
				?>
				<p class='delete'><a href='dashboard.php?del_task=<?php echo $info['id'] ?>'>X</a> </p>
				<?php
				echo "<h3>". $info['title'] ."</h3>";
				echo "<p>Description : ". $info['descrip'] ."</p>";
				echo "<p>Due Date : ". $info['duedate']."</p>";
				echo "Category: #" . $info['category'];
				echo "</div>";
			}
        } 
		else 
		{
            echo "<h1>NO WORK !</h1>";
        }
		?>
		<form action="addtodo.php" class="addbutton">
			<input type="submit" value="Add New ToDo" />
		</form><br>
		<form action="logout.php" class="logout">
			<input type="submit" value="Log Out" />
		</form>
    </div>
</body>
</html>
