<html>
<head>
<title>User Login</title>
</head>
<body>
<?php
include("namespace.php");

$un = $_POST["username"];
$pw = $_POST["password"];
$pw2 = $_POST["password2"];

$conn = new mysqli("mysql8-service", "root", "rootpa55!", "my_db");

if ($un and $pw != false)
{
	if ($pw != $pw2)
	{
		echo "your passwords did not matcj";
	}
	else
	{
		$result=$conn->query("INSERT INTO users (username, password) VALUES ($un, $pw)");
		//create_namespace($un);
	}
}
