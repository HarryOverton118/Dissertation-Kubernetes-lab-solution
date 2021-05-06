<?php
$conn = new mysqli("mysql8-service", "root", "rootpa55!", "my_db");
echo "<h1>Log in to access your distance learning tools</h1>";

//signup form
echo "<form method='post' action='register.php'>";
echo "<fieldset>";
echo "<label for='username'>Username: </label>";
echo "<input name='username' id='username'/>";
echo "<br/>";
echo "<label for='password'>Password: </label>";
echo "<input name='password' id='password' type='password'/>";
echo "<br/>";
echo "<label for='password2'>Re-enter Password: </label>";
echo "<input name='password2' id='password2' type='password'/>";
echo "<br/>";
echo "<input type='submit' value='Go!'/>";
echo "</fieldset>";
echo "</form>";
?>
