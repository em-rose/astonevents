<?php
session_start();
session_destroy();
echo 'You have been logged out. <a href="/astonevents/index.php">Go back</a>';

?>