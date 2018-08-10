<?php include('register.php');



if(isset($_GET['msg'])){
  echo $_GET['msg'];
}



if(isset($_GET['msg'])){
  ?>
  <script type='text/javascript'>
    window.location = '#bigBoxID';
  </script>
  <?php
}
?>


<!DOCTYPE html>


<html>
<head>
  <title>Sign up</title>
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->


</head>
<body>


  <div class="header">
    <h2>Register for Aston Events</h2>
  </div>



  <form method="post" action="register.php">
    <?php include('error.php'); ?>
    <div class="input-group">
      <label>First Name</label>
      <input type="text" name="firstname" value="<?php echo $firstname; ?>">
    </div>
    <div class="input-group">
      <label>Surname</label>
      <input type="text" name="surname" value="<?php echo $surname; ?>">
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password_1">
    </div>
    <div class="input-group">
      <label>Confirm password</label>
      <input type="password" name="password_2">
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="reg_user">Register</button>
    </div>
    <p>
      Already have an account? <a href="/astonevents/index.php">Sign in</a>
    </p>


    <div class="outerBox" id="bigBoxID">
      <div class="popup">
        <h2 class="firstTimerFont" style="text-align: center">Salut et bienvenue!</h2>

      </div>
    </div>



  </form>
</body>
</html>


