<?php
//php code to send an email to the organiser of an event
include 'inc/dbconnect.php';
session_start();
if (isset($_GET['event_id'])){
    $e_id=$_GET['event_id'];

    $u_id  = $_SESSION['id'];
    $u_firstname = $_SESSION['firstname'];
    $u_surname = $_SESSION['surname'];
    $u_email = $_SESSION['email'];
//set user variables using the SESSION variables

}

//DB query to get the email address associated with the organiser of the selected event (event id sent from the previous page via the URL)
try{
    $rows = $db->query("SELECT `email`, E.`name`, E.`id` FROM `events` E
        INNER JOIN `event_interest` EI
        ON E.`id`=EI.`event_id`
        INNER JOIN `users` U
        ON U.`id` = EI.`user_id`
        WHERE E.`id` = $e_id
        ");
}

catch(PDOException $ex) {
    echo("Failed to get data from database.<br>");
    echo($ex->getMessage());
    exit;
}
//set the organiser email from the output of the DB query + set the event name
if($rows->rowCount() > 0) {
  foreach($rows as $row) {
    $o_email = $row['email'];
    $e_name = $row['name'];

}
}



if(isset($_POST['sendemail'])) {
//if the form below is submitted, run the below PHP...
    //email will be sent to the organisers email
    //subject is set to the event name + 'enquiry' on the end
    $email_to = $o_email;
    $email_subject = $e_name." - Enquiry";


//error function if theres errors with the email form
    function died($error) {
        // error message
        echo "Sorry, there is an error with your messsage. ";
        echo "(Error message: ".$error.")<br /><br />";
        echo "<a href 'sendemail.php'>Please fix and try again. </a>";
        die();
    }


    // validation expected data exists
    if(!isset($_POST['comments'])) {
        died('Please fill in your message for the event organiser');       
}

    $comments = $_POST['comments']; // required

    $error_message = "";

//if message is less  than 2 characters, output error
    if(strlen($comments) < 2) {
        $error_message .= 'The message you entered is not valid.';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

//start of the message that the organiser will receive
    $email_message = "Form details below.\n\n";


//function to remove any bad connect from the message, anything that will break it or attack the php script
    function clean_string($string) {
      $badcontent = array("content-type","bcc:","to:","cc:","href");
      return str_replace($badcontent,"",$string);
  }



  $email_message .= "First Name: ".$u_firstname."\n";
  $email_message .= "Last Name: ".$u_surname."\n";
  $email_message .= "Email: ".$u_email."\n";
  $email_message .= "Comments: ".clean_string($comments)."\n";
// clean the string, remove any instances stated in the clean string function

// create email headers, then send email
  $headers = 'From: '.$u_email."\r\n".
  'Reply-To: '.$u_email."\r\n" .
  'X-Mailer: PHP/' . phpversion();
  @mail($o_email, $email_subject, $email_message, $headers);  
  ?>

  <!-- success message that email has been sent -->

  Your email has been sent to the event organiser.

  <?php

}
?>


<h1>Send an email to the organiser</h1>
<!-- form for the user to input into a message for the organiser, just the one input as the rest is picked up from SESSION variables or the DB query gets it -->
<form name="contactform" method="post" action="">
    <table width="450px">
        <tr>
         <td valign="top">
          <label for="comments">Message: </label>
      </td>
      <td valign="top">
          <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
      </td>
  </tr>
  <tr>
     <td colspan="2" style="text-align:center">
        <input type="submit" name="sendemail" value="Send Email" class="submit">
        <!-- button to send email, triggers the above php code -->
    </td>
</tr>
</table>
</form>

<!-- button to go back home -->
    <form action='index.php'>
      <input type="submit" value="Home"/>
    </form>
