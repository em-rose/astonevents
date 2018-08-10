<?php
//session_start();
require_once 'dbconnect.php';
 
$error = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
    if(empty($_POST["email"]) || empty($_POST["password"]))
    {
        $error = "Both fields are required.";
    }else
    {
        // Define $email and $password
        $email=$_POST['email'];
        $password=$_POST['password'];

        // To protect from MySQL injection
        $email = stripslashes($email);
        $password = stripslashes($password);
      

       $row = $db->query("SELECT email,password,firstname,student,organiser FROM users WHERE email='$username'");
      
      
      
      function validate_pw($input_pass, $hash){
        /* Regenerating the with an available hash as the options parameter should
         * produce the same hash if the same password is passed.
         */
        return crypt($input_pass, $hash)==$hash;
      } 
      
      
      
        if(mysqli_num_rows($result) == 1)
        {
            //crypt($password, $hashedPassword) == $hashedPassword;
            if (validate_pw($password, $row[1])) {
               $_SESSION['id'] = $row[0]; // Initializing Session // Redirecting To Other Page
               $_SESSION['password'] =$row[1];
              $error = "";
               header("location: home.php");
                exit;
              
            }
            else{
              $error = "Incorrect username or password.";
            }
             
        }else{
            $error = "Incorrect username or password.";
            
        }

        

    }
}
 
?>