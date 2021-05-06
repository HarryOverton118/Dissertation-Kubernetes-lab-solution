<?php
session_start();

//destroy the session
session_destroy();

//redirect back to login page
header("Location: login-page.php");
?>
