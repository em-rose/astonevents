<?php //include_once 'inc/header.php'; ?> 
<section class="wrapper">
  <h2>Sign-Up</h2>
  <form method="POST" class="signup_form" action="inc/register.php">
    First name: <input type="text" name="firstname" placeholder="Firstname" title="Please enter your first name"/>
    <br>
    Surname: <input type="text" name="surname" placeholder="Surname" title="Please enter your surname"/>
    <br>
    Password: <input type="password" name="password" placeholder="Password" title="Please enter your desired password."/>
    <br>
    Email: <input type="email" name="email" placeholder="E-mail" pattern=".+\@aston\.ac\.uk" title="Please enter a valid Aston email address"/>
    <button type="submit" name="submit">Sign up</button>
</form>
</section>
<?php include_once 'inc/footer.php'; ?>
