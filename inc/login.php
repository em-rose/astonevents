<?php
session_start();
require_once 'dbconnect.php';


if(isset($_POST['login'])) {
	$errMsg = '';
		// Get data from FORM
	$email = $_POST['email'];
	$password = $_POST['password'];
	if($email == '')
		$errMsg = 'Enter email';
	if($password == ''){
		$errMsg = 'Enter password';
	} else {
		$password = crypt($_POST['password'],'$1$somethin$');
	}

	if($errMsg == '') {
		try {
			$stmt = $db->prepare('SELECT id, firstname, email, password, student, organiser FROM users WHERE email = :email');
			$stmt->execute(array(
				':email' => $email
			));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			if($data == false){
				$errMsg = "$email not found.";
			}
			else {
				if($password == $data['password']) {
					$_SESSION['firstname'] = $data['firstname'];
					$_SESSION['email'] = $data['email'];
					$_SESSION['id'] = $data['id'];
					$_SESSION['student'] = $data['student'];
					$_SESSION['organiser'] = $data['organiser'];
					header('Location: /astonevents/index.php');
					exit;
				}
				else
					$errMsg = 'Password not match.';
			}
		}
		catch(PDOException $e) {
			$errMsg = $e->getMessage();
		}
	}
}


?>

<html>
<head><title>Login</title></head>
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
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Login</b></div>
			<div style="margin: 15px">
				<form action="" method="post">
					<input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" autocomplete="off" class="box"/><br /><br />
					<input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" class="box" /><br/><br />
					<input type="submit" name='login' value="Login" class='submit'/><br />
				</form>
			</div>
		</div>
		<br><br><form action='/astonevents/index.php'>
			<input type="submit" value="Home"/>
		</form>
	</div>
</body>
</html>



















<?php



/*
//set variables to values from header.php POST
$email = strip_tags($_POST['email']);
$password = strip_tags($_POST['password']);


$encryped_pw = crypt($password,'$1$somethin$');


try {
	$rows = $db->prepare("SELECT email,password,firstname,student,organiser FROM users WHERE email='$email'");
	$rows->bindParam(':email', $email, PDO::PARAM_STR, 100);
	$rows->execute();



	//$result=$row['password'];
} catch(PDOException $ex) {
	echo("Failed to get data from database.<br>");
	echo($ex->getMessage());
	exit;
}



if ($row['password']=$encryped_pw){
	echo "Correct password!";
	session_start();
	// Store Session Data
	$_SESSION['email']= $email;
	$name=$row["firstname"];
	$student=$row["student"];
	$organiser=$row["organiser"];
	$userid=$row["id"];

	$_SESSION['name']=$name;
	$_SESSION['student']=$student;
	$_SESSION['organiser']=$organiser;
	$_SESSION['id']=$userid;
	

	header( "Location: /astonevents/index.php" ); 
	
} else {
	echo "Wrong password!Please try again"; ?>
	<form action='/astonevents/index.php'>
		<input type="submit" value="Back to login"/>
	</form>


	<?php
}


*/

?>
