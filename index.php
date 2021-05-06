<?php
session_start();

//checks if user is logged in
if (isset ($_SESSION['gatekeeper']))
{
	//nav bar
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
	//title
	echo "<h1 name='title'> WELCOME TO THE COMPUTING LAB PORTAL</h1>";
	echo "<h2 name='subtitle'> Here you can find or request all of your required online resources and labs to carry out you online course!</h2>";

	//main content showing features of the portal
	echo "<div>";
	echo "<h3>OpenMeetings:</h3>";
	echo "OpenMeetings is provided as a online video confrance tool where you can access your scheduled lectures, share files, and use its built in calendar to keep on track with your work. Feel free to create your own meetings to carry out group work and engage with your class. If you need any support you can contact your lecture via Openmeetings or email";
	echo "</div>";

	echo "<div>";
	echo "<h3>Lab Environments</h3>";
	echo "You can request containerized lab environments hosted on kubernetes to practice your skills without the need of your own virtual machines or physical equipment. You can deploy basic environments or request more specific ones to be added form your teacher";
	echo "</div>";

	echo "<div>";
	echo "<h3>Packet Tracer Anywhere</h3>";
	echo "for networking labs you can use packet tracer anywhere to simulate network topologies from the portal to practice for your networking exams";
	echo "</div>";

	echo "<div>";
	echo "<h3>Gorup Labs</h3>";
	echo "Here you can access specific gorup labs using multiple lab environments that can communicate with each other. These will be set up by your lecture and will usually be used for case study scenarios where you will practice configuring multiple systems together";
	echo "</div>";

	$conn->close();
}
else
{
	header("Location: login-page.php");
}
?>
</body>
</html>
