<?php
	//start the session for the user - keeps them logged 
session_start();
?>

<!-- This begins to create the page and links the relevant stylesheet" -->
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" type="text/css" href="includes/filostylesheet.css"> -->
</head>
<body>
	<header>
		<nav>
			<div class="navbar">
				<!-- This states that if the user is logged in, then welcome them to the website. -->
				<?php
				if(isset($_SESSION['email'])) {
					?>
					<!--echo session name needs FIXING -->
					<p> Logged in as: <?php echo $_SESSION['firstname']; ?> </p>
					<a href='inc/logout.php'>Click here to log out</a>


				<?php } else { ?>
					<form action='inc\login.php'>
						<input type="submit" value="Login"/>
					</form>

					<form action='register/register.php'>
						<input type="submit" value="Sign Up"/>
					</form>
				<?php } ?>
			</div>
		</nav>
	</header>