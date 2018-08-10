<?php
include ("dbconnect.php");

$first_name=$_POST['first_name'];
$surname=$_POST['surname'];
$password = crypt($_POST['password'],'$1$somethin$');
$email = $_POST['email'];
if ($_POST['user_type'] == "student") {
	$student=1;
	$organiser=0;
} elseif ($_POST['user_type'] == 'organiser') {
	$organiser=1;
	$student=0;
} 

if ($_POST["password"] == $_POST["passwordCheck"]) {
	echo "Passwords Match!";

}
	
	try{

		$email_check=$db->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = :email");
		$email_check->bindParam(':email', $email, PDO::PARAM_STR, 100);
		$email_check->execute();
		} catch (PDOException $ex) {
//this catches the exception when it is thrown
		?>
		<p>Sorry, a database error occurred. Please try again.</p>s
		<p>(Error details: <?= $ex->getMessage() ?>)</p>
		

		<?php
	}

		if ($email_check==0){
			



# insert a member record based on the form data
		try{

		$sth=$db->prepare("INSERT INTO `users` 
			(`email`,
			`password`,
			`firstname`,
			`surname`,
			`student`,
			`organiser`) 
			VALUES (
			:email,
			:password,
			:first_name,
			:surname,
			:student,
			:organiser) 
			");
		$sth->bindParam(':email', $email, PDO::PARAM_STR, 100);
		$sth->bindParam(':password', $password, PDO::PARAM_STR, 64);
		$sth->bindParam(':first_name', $first_name, PDO::PARAM_STR, 50);
		$sth->bindParam(':surname', $surname, PDO::PARAM_STR, 50);
		$sth->bindParam(':student', $student, PDO::PARAM_INT);
		$sth->bindParam(':organiser', $organiser, PDO::PARAM_INT);
		$sth->execute();

 session_start();
		$_SESSION['email']= $email;
		$_SESSION['name']=$first_name;
		$_SESSION['student']=$student;
		$_SESSION['organiser']=$organiser;


?>
<p>Successfully registered! </p>
<a href='/astonevents/index.php'>Click here to go back home & login</a>

<?php

		header("location: /astonevents/index.php");

	} catch (PDOException $ex) {
//this catches the exception when it is thrown
		?>
		<p>Sorry, a database error occurred. Please try again.</p>

		<p>(Error details: <?= $ex->getMessage() ?>)</p>
		<a href='/astonevents/inc/signup.php'>Back to sign up</a>

		<?php
	}



} else {
	echo "Email already registered!";?>
	<br>
<a href='/astonevents/inc/signup.php'>Back to sign up</a>
	<?php
}

	?>
