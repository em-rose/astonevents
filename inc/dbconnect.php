<?php
//DB config file

//sets the database details
$db_host = 'localhost';
$db_name = 'astonevents';
$username = 'root';
$password = '';

try {
	//try and catch method used to get connection to database, using PDO
    $db = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
	//throws error if it cannot connect to database
    echo("Failed to connect to the database.<br>");
    echo($ex->getMessage());
    exit;
}
?>
