<?php
//php to insert into the events 

include 'inc/dbconnect.php';
//include DB config file

session_start();
$user_id = $_SESSION['id'];

if (isset($_GET['event_id'])){
  $event_id=$_GET['event_id'];
  //gets the event ID from the URL that is sent through from the index page.
}

try{
// inserts into the event interest table the event id and the users id that is logged in
      $sth=$db->prepare("INSERT INTO `event_interest` (
      	`event_id`, 
      	`user_id`) 
      	VALUES (
      	:event_id,
      	:user_id
        )");
      $sth->bindParam(':event_id', $event_id, PDO::PARAM_INT);
      $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $sth->execute();

      header("Location: index.php");
      //redirects back to the home page, so none of this is shown to the user

    } catch (PDOException $ex) {
//this catches the exception when it is thrown
      ?>
      <p>Sorry, a database error occurred. Please try again.</p>
<!-- does output error is it fails, gives button to go back home to try again -->
      <p>(Error details: <?= $ex->getMessage() ?>)</p>
      <a href='/astonevents/index.php'>Back to home</a>

      <?php
    }




?>

