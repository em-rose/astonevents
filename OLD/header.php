<?php
	//start the session for the user - keeps them logged 
	session_start();
?>


<div class="topnav" id="myTopnav">
	
	
	<h2 id=logo>Aston Events</h2>
	
	
	<!-- Dynamic Elements --> 
	<?php if(isset($_SESSION['username'])) : ?>
		<h2 id="user_text">Hello <?php echo $_SESSION['name'];?></h2>

		<a id=logout href="logout.php">Log Out</a>
			
	<?php endif; ?>
	
	
	<?php if(!isset($_SESSION['username'])) : ?>
			<a id=login>Login</a>
			<?php include 'login.php'; ?>		
			<div id="lModal" class="modal">
					<div class="modal-content">
					<span class="logclose">&times;</span>
							<form id="log_in" method="post" action="">
									<div class="header">

											<h3>Log In</h3>

											<p>Enter your details below</p>
									</div>

									<div class="sep"></div>

									<div class="inputs">	
											<input type="email" placeholder="e-mail" 
											pattern=".+\@aston\.ac.uk"
											title="Please enter a valid Aston email address"
											name="email" autofocus required />

											<input type="password" id="password" placeholder="Enter password" name="password" required />
										
											<div class="error"><?php echo $error;?>

											<input type="submit" id="submit" href="#" name="submit" value="Login" /> 
									</div>
									</div>
									
							</form>
					</div>
			</div>



			<a id=reg>Register</a>
					<!-- Popout Sign Up -->
					<div id="rModal" class="modal">

						<!-- Modal content -->
						<div class="modal-content">
							<span class="close">&times;</span>

								<form id="sign_up" method="post" action="process.php">

									<div class="header">

										<h3>Sign Up</h3>

										<p>Enter your details below</p>

									</div>

									<div class="sep"></div>

									<div class="inputs">

										<input type="text" placeholder="First names" name="first" required />

										<input type="text" placeholder="Surname" name="surname" required/>

										<input type="email" placeholder="e-mail" 
										pattern="(.*\@aston\.ac.uk)"
										title="Please enter a valid Aston email address"
										name="email" autofocus required/>

										<input type="password" id="password" placeholder="Enter password" name="password" required />

										<input type="password" id="password2" placeholder="Confirm password" name="passwordCheck" required/>

										<div class="checkboxy">
											<input name="cecky" id="checky" value="1" type="checkbox" /><label class="terms">I accept the terms of use</label>
										</div>

										<button type="submit" id="submit" href="#">SIGN UP </a>

									</div>

								</form>
						</div>
					</div>
	<?php endif; ?>
	<!-- End of Dynamic elements -->
	
</div>
<script src="../js/modal.js"></script>
<script src="../js/validate.js"></script>