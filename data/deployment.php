<?php
session_start();
include("api-functions.php");


if (!isset ($_SESSION["gatekeeper"]))
{
        header("Location: login-page.php");
}
else
{
echo "<link rel='stylesheet' href='stylesheet.css'>";

	echo "<ul>";
  		echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='service-view.php'>View Deployments</a></li>";
                echo "<li><a href='https://192.168.49.2:30131'>OpenMeetings</a></li>";
                echo "<li><a href='group-lab.php'>Group Lab</a></li>";
		echo "<li><a href='pt-anywhere.php'>PT Anywhere</a></li>";
		echo "<li style='float:right'><a>".$_SESSION['gatekeeper']."</a></li>";
                echo "<li style='float:right'><a href='logout.php'>Logout</a></li>";
	echo "</ul>";
	echo "</br>";

	create_deployment();
}

?>
