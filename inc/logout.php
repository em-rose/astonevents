<?php
session_start();
session_destroy();
echo 'You have been logged out. <a href="/astonevents/index.php">Go back</a>';
//code to destroy the session variables that are set when the user logs in
//resets to allow another user to login
//gives link to go back home

?>