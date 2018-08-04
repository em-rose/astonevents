<?php
session_start();

$firstname="";
$surname="";
$email="";
$password_1="";
$password_2="";




require_once 'dbconnect.php';
//set variables to values from signup.php POST

if (isset($_POST['firstname'])){
	$firstname = strip_tags($_POST['firstname']);
} 

if (isset($_POST['surname'])){
	$surname = strip_tags($_POST['surname']);
}

if (isset($_POST['email'])){
	$email = strip_tags($_POST['email']);
}

if (isset($_POST['password_1'])){
	$password_1 = strip_tags($_POST['password_1']);
}

if (isset($_POST['password_2'])){
	$password_2 = strip_tags($_POST['password_2']);
}


$db_host = 'localhost';
$db_name = 'astonevents';
$username = 'root';
$password = '';

try {
	$email_check = $db->query("SELECT count(*) FROM users WHERE email='$email'");

	if ($password_1=$password_2){


		if ($email_check=0){
			$query = "INSERT INTO users (firstname,surname, email, password, student) VALUES ('$firstname', '$surname' '$email', '$password','1')";
			//popupMessage("User has been registered, redirecting to login");
			header( "Location: /astonevents/index.php" ); 
		} else {
			//popupMessage("Email is already registered, please register with a different email");
			header( "Location: signup.php" ); 
		} 
		
	}else {
	//passwords don't match, ERROR
		
		header( "Location: signup.php" ); 

	}

}
catch(PDOException $ex) {
	echo("Failed to get data from database.<br>");
	echo($ex->getMessage());
	exit;
}