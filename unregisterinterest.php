<?php
include 'inc/dbconnect.php';
//get DB config
session_start();
$user_id = $_SESSION['id'];
//sets user id to what is in the session variable from the logged in user

if (isset($_GET['event_id'])){
  $event_id=$_GET['event_id'];
  //get the event ID from the URL that is sent through from the index page
}

try{
//db query to delete from the event_interest table where the user id is the user logged in and the event id is the one that is sent through 
  $sth=$db->prepare("DELETE 
    FROM `event_interest` 
    WHERE `event_id` = :event_id 
    AND `user_id` = :user_id
    ");
  $sth->bindParam(':event_id', $event_id, PDO::PARAM_INT);
  $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $sth->execute();

  header("Location: index.php");
//automatic redirection to the home page so the user doesnt see any of the internal workings of this code
} catch (PDOException $ex) {
//this catches the exception when it is thrown
  ?>
  <p>Sorry, a database error occurred. Please try again.</p>

  <p>(Error details: <?= $ex->getMessage() ?>)</p>
  <a href='/astonevents/index.php'>Back to home</a>
  <!-- outputs error message and link to go back home to allow them to try again -->
  <?php
}

?>