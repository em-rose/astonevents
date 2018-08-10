<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'astonevents');
/*
$connect=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
 
if(mysqli_connect_errno($connect))
{
		echo 'Failed to connect';
}

?>
*/

try {
    $db = new PDO("mysql:dbname=$DB_DATABASE;host=$DB_SERVER", $DB_USERNAME, $v); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    echo("Failed to connect to the database.<br>");
    echo($ex->getMessage());
    exit;
}
?>
