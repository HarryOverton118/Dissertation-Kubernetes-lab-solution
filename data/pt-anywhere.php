<?php
session_start();
include("api-functions.php");
if (isset ($_SESSION['gatekeeper']))
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

        $conn = new mysqli("mysql8-service", "root", "rootpa55!", "my_db");
        // Check connection
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        echo "<iframe src='http://forge.kmi.open.ac.uk/pt/app/default.html' width='100%' height='100%'/>";
        $conn->close();
}
else
{
        header("Location: login-page.php");
}
?>

