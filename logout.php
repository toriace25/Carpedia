<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["password"]);

//echo 'Session has been cleaned';
header('Refresh: 0, URL = login.php');
?>
