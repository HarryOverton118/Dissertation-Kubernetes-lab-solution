<?php
session_start();
include("api-functions.php");

if (isset ($_SESSION["gatekeeper"]))
{
	echo "<link rel='stylesheet' href='stylesheet.css'>";
	echo "<ul>";
		echo "<li><a href='index.php'>Home</a></li>";
  		echo "<li><a href='service-view.php'>View Deployments</a></li>";
  		echo "<li><a href='https://192.168.49.2:30131'>OpenMeetings</a></li>";
                echo "<li><a href='group-lab.php'>Group Lab</a></li>";
		echo "<li><a href='pt-anywhere.php'>PT Anywhere</a></li>";
		echo "<li style='float:right'><a>".$_SESSION['gatekeeper']."</a></li>";
		echo "<li style='float:right'><a href='login-page.php'>Logout</a></li>";
	echo "</ul>";
	echo "</br>";
        
        
	$conn = new mysqli("mysql8-service", "root", "rootpa55!", "my_db");
	// Check connection
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
	}

	echo "<h3>Here are all of your current lab environments. Remeber to ensure you are accessing them in the proper way with shell-in-a-box labs being accessed through this page or through their endpoints via https or ssh in specific instances</h1>";
	echo "<h3>These lab environments will allow you to practice your individual skills and will help prepare you for practical exams</h3>";
	echo "</br>";

	//lab deployment form
        echo "<form action='deployment.php' method='get'>";
        echo "<fieldset>";
        echo "<label>Deploy a new lab environment: </label></br>";
        echo "<select name='image'/>";
        echo "<option name='siab'>siab-ubuntu</option></br>";
        echo "<option>kali-linux</option></br>";
        echo "<option>ubuntu-18</option></br>";
        echo "<input type='submit' value='Go!' />";
        echo "</fieldset>";
        echo "</form>";

	get_services();
	$conn->close();
}
else
{
	header("Location: login-page.php");
}
?>

