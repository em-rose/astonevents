<?php
include 'inc/dbconnect.php';
session_start();
echo $_SESSION['id'];
$user_id = $_SESSION['id'];

if (isset($_GET['event_id'])){
  $event_id=$_GET['event_id'];
  echo $event_id;
}

try{

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

    } catch (PDOException $ex) {
//this catches the exception when it is thrown
      ?>
      <p>Sorry, a database error occurred. Please try again.</p>

      <p>(Error details: <?= $ex->getMessage() ?>)</p>
      <a href='/astonevents/index.php'>Back to home</a>

      <?php
    }




?>

