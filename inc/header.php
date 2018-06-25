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
	if(isset($_SESSION['username'])) {
?>
		<p> Welcome, <?php echo $_SESSION['username'] ?> </p>
<?php } ?>
		
		<div class="navbar_login">		
		<?php
		//This checks if the user is logged n, if they are then display a log out button. If they are not, display a log in button.
			if(isset($_SESSION['username'])) { ?>
				
		<?php } else { ?>
				<form action="inc/login.php" method="POST">
				<input type="text" name="username" placeholder="Username">
				<input type="password" name="password" placeholder="Password">
				<button type="submit" name="submit">Login</button>
				</form>
				<a href="signup.php">Sign Up!</a>
		<?php } ?>
        </div>
      </div>
    </nav>
  </header>
