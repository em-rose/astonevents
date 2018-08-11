<?php 
//Page to show the list of interested students in an event organised by the current user
include 'inc/dbconnect.php';
//gets db config files for sql queries

?>
<head>
  <title>Aston Event Details</title>
</head>
<section class="main-container">
  <div class="wrapper">
    <h1>Aston Events</h1>
  </div>
</section>




<h2>Event Details</h2>

<?php

//get the event ID from the URL - passed from the myevents page
if (isset($_GET['event_id'])){
  $event_id=$_GET['event_id'];
//set to a variable to use in the db query
  try{
    $stmt = $db->query("SELECT * FROM events WHERE id = '$event_id'");
  }

  catch(PDOException $ex) {
    echo("Failed to get data from database.<br>");
    echo($ex->getMessage());
    exit;
  }

  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  $eventname = $data['name'];
//output the event name for the interested users
  ?>
  <h3><?php echo $eventname; ?></h3>
  <h4>Interested students:</h4>
  <?php
//selects all the users that are interested in this event by joining to events interest table and selecting all that have a row with this event id in

  try{
    $rows = $db->query("SELECT `EI`.`event_id`, `firstname`,`surname` FROM `users` U INNER JOIN `event_interest` EI ON U.`id`=EI.`user_id` WHERE EI.`event_id` = '$event_id'");
  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }


}

if($rows->rowCount() > 0) {
  foreach($rows as $row) {
    $firstname= $row['firstname'];
    $surname = $row['surname'];
    if (isset($firstname)){
      //loop through the results, outputting to a list for ease of viewing
      ?>


      <li>
        <?=  $firstname." ".$surname ?>

      </li>

      <?php



    } else {
      echo "No students registered for event";
      //if no results found, output message
    }
  }
}
?>


<br><br><form action='myevents.php'>
  <input type="submit" value="Go Back"/>
</form>
<!-- button to go back a page -->



