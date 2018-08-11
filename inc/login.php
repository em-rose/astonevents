<?php
session_start();
require_once 'dbconnect.php';
//sets the session going when the user goes to login
//gets the DB config file


if(isset($_POST['login'])) {
	//if the HTML form has been submitted, do the following php code...
	$errMsg = '';
	//set error message to empty
		// Get data from form, if empty, sets the error message
	$email = $_POST['email'];
	$password = $_POST['password'];
	if($email == '')
		$errMsg = 'Enter email';
	if($password == ''){
		$errMsg = 'Enter password';
	} else {
		$password = crypt($_POST['password'],'$1$somethin$');
		//encrypts the password so to match the encrypted password that has been inserted into the DB
	}

	if($errMsg == '') {
		//if no errors with the form...
		try {
			$stmt = $db->prepare('SELECT id, firstname, email, password, student, organiser FROM users WHERE email = :email');
			//DB query of selecting the details that need matching to ensure that the user has inputted their details correctly
			$stmt->execute(array(
				':email' => $email
			));

			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			//sets the array of results to the data variable array
			if($data == false){
				$errMsg = "$email not found.";
				//if the input users email isnt found, show error message to screen
			}
			else {
				if($password == $data['password']) {
					//if the input password matchs the password in the DB...
					$_SESSION['firstname'] = $data['firstname'];
					$_SESSION['surname'] = $data['surname'];
					$_SESSION['email'] = $data['email'];
					$_SESSION['id'] = $data['id'];
					$_SESSION['student'] = $data['student'];
					$_SESSION['organiser'] = $data['organiser'];
					header('Location: /astonevents/index.php');
					exit;
					//if the email is found, output all the needed data to SESSION variables, for use later on in the website
					//then redirects home
				}
				else
					$errMsg = 'Password not match.';
				//output error if the input password doesnt match what is in the database
			}
		}
		catch(PDOException $e) {
			$errMsg = $e->getMessage();
			//output exception error if the DB query errors
		}
	}
}


?>


<!-- HTML form for logging in... -->
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
				//formatting for any error messages that are shown
			}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Login</b></div>
			<div style="margin: 15px">
				<form action="" method="post">
					<input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" 
					autocomplete="off" class="box"/><br /><br />
					<!-- if the user has already submitted the form, the values they submitted will stay in the corresponding field so that if there is errors they can modify instead of retyping -->
					<input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" class="box" /><br/><br />
					<!-- hashes password as its typed in -->
					<input type="submit" name='login' value="Login" class='submit'/><br />
					<!-- submit button, sends data and triggers the php scripting above -->
				</form>
			</div>
		</div>
		<br><br><form action='/astonevents/index.php'>
			<input type="submit" value="Home"/>
		</form>
		<!-- button to go back home -->
	</div>
</body>
</html>

