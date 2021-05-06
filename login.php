<?php
session_start();
$un = $_POST["username"];
$pw = $_POST["password"];

$conn = new PDO("mysql:host=mysql8-service; dbname=my_db;","root", "rootpa55!");

$result=$conn->query("SELECT * FROM users WHERE username='$un' AND password='$pw'");
$row=$result->fetch();
if($row==false)
{
	echo "Incorrect username/password";
}
else
{
	$_SESSION["gatekeeper"] = $un;
        header("Location: index.php");
}
?>
