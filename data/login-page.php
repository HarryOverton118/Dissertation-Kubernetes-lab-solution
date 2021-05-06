<?php

echo "<h1>Log in to access your distance learning tools</h1>";

//login form
echo "<form method='post' action='login.php'>";
echo "<label for='username'>Username: </label>";
echo "<input name='username' id='username'/>";
echo "<br/>";
echo "<label for='password'>Password: </label>";
echo "<input name='password' id='password' type='password'/>";
echo "<br/>";
echo "<input type='submit' value='Go!'/>";
?>
