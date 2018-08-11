<?php
require 'inc/dbconnect.php';
//include DB config file


if(isset($_POST['register'])) {
	$errMsg = '';
		// Get data from register form if it has been submitted
	$first_name = $_POST['first_name'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
//set the values of student and organiser depending on what was selected by the user - 1 is true, 0 is false, so if student selected:
	if ($_POST['user_type']=="student"){
		$student="1";
		$organiser="0";
	} else{
		$student="0";
		$organiser="1";
	}

	$password = $_POST['password'];
	$password_crypt = crypt($_POST['password'],'$1$somethin$');
	//hash the password 

	//error messages if data is missing from the form
	if($first_name == '')
		$errMsg = 'Enter your first name';
	if($surname == '')
		$errMsg = 'Enter your surname';
	if($email == '')
		$errMsg = 'Enter your Aston email';
	if($password == '')
		$errMsg = 'Enter password';
	if(!isset($student))
		$errMsg = 'Please select user type';



	if($errMsg == ''){
		//if no error messages from the form, then continue with register
		try{
			//insert statement into users table 
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
			$sth->bindParam(':password', $password_crypt, PDO::PARAM_STR, 64);
			$sth->bindParam(':first_name', $first_name, PDO::PARAM_STR, 50);
			$sth->bindParam(':surname', $surname, PDO::PARAM_STR, 50);
			$sth->bindParam(':student', $student, PDO::PARAM_INT);
			$sth->bindParam(':organiser', $organiser, PDO::PARAM_INT);
			$sth->execute();


			//success message and button to go home to allow user to login
			?>
			<p>Successfully registered! </p>
			<a href='/astonevents/index.php'>Click here to go back home & login</a>

			<?php

		} catch (PDOException $ex) {
//this catches the exception when it is thrown by the DB insert
			?>
			<p>Sorry, a database error occurred. Please try again.</p>

			<p>(Error details: <?= $ex->getMessage() ?>)</p>
			<a href='/astonevents/inc/signup.php'>Back to sign up</a>

			<?php
		}


	}
}

?>


<!-- HTMl for the register form page -->
<html>
<head><title>Register</title></head>
<style>
html, body {
	margin: 1px;
	border: 0;
}
</style>
<body>
	<div align="center">
		<div style=" border: solid 1px #006D9C; " align="left">
			<?php
			if(isset($errMsg)){
				echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
			}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Register</b></div>
			<div style="margin: 15px">
				<form action="" method="post">
					<!--  if the form as been submitted, it keeps the values in the form 
						Autocomplete has been turned off for these inputs, placeholders are present-->
					<input type="text" name="first_name" placeholder="First Name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name'] ?>" autocomplete="off" class="box"/><br /><br />
					<input type="text" name="surname" placeholder="Surname" value="<?php if(isset($_POST['surname'])) echo $_POST['surname'] ?>" autocomplete="off" class="box"/><br /><br />

					<!-- Email address of the user - pattern is regex, checks the input against the @aston.ac.uk format -->
					<input type="text" name="email" placeholder="Please enter a valid Aston email address" 
					pattern="[a-z0-9._%+-]+@aston.ac.uk$"
					value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" autocomplete="off" class="box"/><br /><br />

					<!-- Radio buttons to chose the type of user they are -->
					Please Choose: <br>
					Student <input type="radio" value="student" name="user_type" required />

					Organiser <input type="radio" value="organiser" name="user_type" /><br /><br />


					<!-- Pass is shown as * when input -->
					<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" class="box" /><br/><br />
					<input type="submit" name='register' value="Register" class='submit'/><br />
					<!-- Button to submit form and initiate the php above -->
				</form>


			</div>
		</div>
		<br><br><form action='index.php'>
			<input type="submit" value="Home"/>
		</form>
		<!-- Button to go back home -->
	</div>
</body>
</html>