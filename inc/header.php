<?php
//header, attached to the login
//shows the login and register buttons if no user is logged in
//else shows who is logged in
//and shows a log out button for the user

	//start the session for the user - keeps them logged 
session_start();
?>

<html>
<body>
	<header>
		<nav>
			<div class="navbar">
				<!-- if the user is logged in, welcome them to the website. -->
				<?php
				if(isset($_SESSION['email'])) {
					?>
					<p> Logged in as: <?php echo $_SESSION['firstname']; ?> </p>
					<a href='inc/logout.php'>Click here to log out</a>


				<?php } else { ?>
					<!-- else shows login and register buttons for the users -->
					<form action='inc\login.php'>
						<input type="submit" value="Login"/>
					</form>

					<form action='register.php'>
						<input type="submit" value="Sign Up"/>
					</form>
				<?php } ?>
			</div>
		</nav>
	</header>