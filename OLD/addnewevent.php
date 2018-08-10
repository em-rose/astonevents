<?php
include ("dbconnect.php");

if (isset($_POST['email'])){
	$email = $_POST['email'];
} else {
	echo "Please input your email address";
	exit;
}
if (!empty(trim($_POST['password']))){
	$password = crypt($_POST['password'],'$1$somethin$');
}else {
	echo '<p><b>You forgot to enter your password!</b></p>';
	exit;
}
if ($_POST['user_type'] == "student") {
	$student=1;
	$organiser=0;
} elseif ($_POST['user_type'] == 'organiser') {
	$organiser=1;
	$student=0;
} 

$first_name=$_POST['first_name'];
$surname=$_POST['surname'];



if ($_POST["password"] == $_POST["passwordCheck"]) {
	echo "Passwords Match!";

}
	/*
	function generate_hash($password, $email){
		sha1($username.$password.'£3122d');
	}

*/

	//$hash = generate_hash($_POST['password'], $_POST['email']);

	try{

		$email_check=db->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = :email");
		$sth->bindParam(':email', $email, PDO::PARAM_STR, 100);

		if ($email_check==0){



# insert a member record based on the form data
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






		header("location: /astonevents/index.php");

	} catch (PDOException $ex) {
//this catches the exception when it is thrown
		?>
		<p>Sorry, a database error occurred. Please try again.</p>s
		<p>(Error details: <?= $ex->getMessage() ?>)</p>
		

		<?php
	}



} else {
	echo "Email already registered!";
header("location: /astonevents/signup.html");
	}
	?>
