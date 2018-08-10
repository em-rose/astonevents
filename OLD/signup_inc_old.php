

<?php
require 'dbconnect.php';



if(isset($_POST['register'])) {
  $errMsg = '';
    // Get data from FROM
  $first_name = $_POST['first_name'];
  $surname = $_POST['surname'];
  $email = $_POST['email'];

  if ($_POST['user_type']=="student"){
    $student="1";
    $organiser="0";
  } else{
    $student="0";
    $organiser="1";
  }

  $password = $_POST['password'];
  $password_crypt = crypt($_POST['password'],'$1$somethin$');
  
  if($first_name == '')
    $errMsg = 'Enter your first name';
  if($surname == '')
    $errMsg = 'Enter your surname';
  if($email == '')
    $errMsg = 'Enter email';
  if($password == '')
    $errMsg = 'Enter password';
  if($errMsg == ''){

    try {
      $stmt=$db->prepare("SELECT `email`,
        FROM `users` 
        WHERE `email` = :email 
        ");
      $stmt->execute(array(
        ':email' => $email
      ));}
      catch(PDOException $e) {
          echo $e->getMessage();
        }

      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if($data == false){
        try {
          $stmt=$db->prepare("INSERT INTO `users` 
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
          $stmt->execute(array(
            ':email' => $email,
            ':password' => $password_crypt,
            ':first_name' => $first_name,
            ':surname' => $first_name,
            ':student' => $student,
            ':organiser' => $organiser
          ));




          header('Location: \astonevents\register\register.php?action=complete');
          exit;
        }
        catch(PDOException $e) {
          echo $e->getMessage();
        }
      } else {

        $errMsg = '$email already registed! Try a different email or <a href="/astonevents/inc/login.php">login</a>. ';
      }
    }
  }
  if(isset($_GET['action']) && $_GET['action'] == 'complete') {
    $errMsg = 'Registration successful. Now you can <a href="/astonevents/inc/login.php">login</a>';
  }
  ?>

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
          <input type="text" name="first_name" placeholder="First Name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name'] ?>" autocomplete="off" class="box"/><br /><br />
          <input type="text" name="surname" placeholder="Surname" value="<?php if(isset($_POST['surname'])) echo $_POST['surname'] ?>" autocomplete="off" class="box"/><br /><br />
          <input type="text" name="email" placeholder="Please enter a valid Aston email address" 
          pattern="[a-z0-9._%+-]+@aston.ac.uk$"
          value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" autocomplete="off" class="box"/><br /><br />

          Please Choose: <br>
          Student <input type="radio" value="student" name="user_type" required />

          Organiser <input type="radio" value="organiser" name="user_type" /><br /><br />

          <input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" class="box" /><br/><br />
          <input type="submit" name='register' value="Register!" class='submit'/><br />
        </form>
      </div>
    </div>
  </div>
</body>
</html>