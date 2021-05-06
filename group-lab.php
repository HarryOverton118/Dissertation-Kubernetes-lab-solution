<?php
session_start();
include("api-functions.php");
$node = htmlentities($_GET['node']);

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
        echo "<div style='padding: 20px;'>";
        	echo "<h1>For this lab form groups of 3 to configure the specified services for your case study as shown below:</h1>";
        	echo "<h3>This lab is only for installing the services on real linux devices and router and other networking configuation should be ignored</h3>";
		echo "<h3>Networking labs for configuring routers, switches and so on will be carried out on packet tracer and packet tracer anywhere</h3></br>";
		// interactive window to lab environment
		echo "<div style='padding: 40px;'>";
			echo "<ul style='float:right'>";
				echo "<li><a href='group-lab.php?node=https://192.168.49.2:32541'>PC1a</a></li>";
				echo "<li><a href='group-lab.php?node=https://192.168.49.2:32071'>PC1b</a></li>";
				echo "<li><a href='group-lab.php?node=https://192.168.49.2:31442'>PC2</a></li>";
                                echo "<li><a href='group-lab.php?node=https://192.168.49.2:32557'>PC3</a></li>";
			echo "</ul>";
				echo "<img style='float: left' src='lab-topology.PNG' alt='lab topology' width='50%' height='50%'/></br>";
				echo "<iframe style='float: right; border: 5px solid #333; padding:10px' src='$node' width='40%' height='40%'/>";
		echo "</div>";
	echo "</div>";
		
	get_services_lab('lab-namespace');
        $conn->close();
}
else
{
        header("Location: login-page.php");
}
?>


