<?php

require_once 'dbconnect.php';

//set variables to values from header.php POST
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);
$encryped_pw = sha1($password);


try {
	$rows = $db->query("SELECT email,password,firstname,student,organiser FROM users WHERE email='$username'");

} catch(PDOException $ex) {
	echo("Failed to get data from database.<br>");
	echo($ex->getMessage());
	exit;
}



if ($result=$password){
	echo "Correct password!";
	session_start();
	// Store Session Data
	$_SESSION['username']= $username;
	$name=$row["firstname"];
	$student=$row["student"];
	$organiser=$row["organiser"];

	$_SESSION['name']=$name;
	$_SESSION['student']=$student;
	$_SESSION['organiser']=$organiser;
	

	header( "Location: /astonevents/index.php" ); 
	
} else {
	echo "Wrong password!";
	header( "Location: /astonevents/index.php" ); 
	//Pop up needed in index! 
	die;
}


?>
