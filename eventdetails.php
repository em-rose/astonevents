<?php 
include 'inc/dbconnect.php';
session_start();
//include DB connection and start session

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


if (isset($_GET['event_id'])){
  $event_id=$_GET['event_id'];
//get the event id from the URL that was sent from the index.php
  try{
    $rows = $db->query("SELECT * FROM events WHERE id = '$event_id'");
    //query to get all the event details for the ID
  }

  catch(PDOException $ex) {
    echo("Failed to get data from database.<br>");
    echo($ex->getMessage());
    exit;
  }
}


if($rows->rowCount() > 0) {
  foreach($rows as $row) {
    $eventid=$row['id'];
    //outputs the results for the specific event for easy viewing. Includes the event image
    ?>


    <h3><?php echo $row['name']; ?></h3>

    Category : <?php echo $row['category']; ?><br>
    Description : <?php echo $row['description']; ?><br>
    Datetime of event : <?php echo $row['datetime']; ?><br>
    Popularity : <?php
    $e_id = $row['id'];
    //calculate the popularity of the event, the number  of people registered as interested.
    try{
      $stmt = $db->query("SELECT COUNT(*) AS popularity, E.`id` FROM `event_interest` EI
        INNER JOIN `events` E
        ON EI.`event_id` = E.`id`
        WHERE E.`id` = '$e_id'
        GROUP BY E.`id`");

      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      $popularity = $data['popularity'];
    }
    catch(PDOException $e) {
      echo $e->getMessage();
    }
    if (isset($popularity)){
      echo $popularity;
    } else {
      echo "0";
    }

    ?>

    <br> Organiser : <?php
    $o_id = $row['id'];
    try{
      $stmt = $db->query("SELECT `firstname`,`surname`,`name` FROM `events` E
        INNER JOIN `users` U
        ON E.`organiser_id` = U.`id`
        WHERE E.`id` = '$o_id'");
//statement to get the organiser first and last name to output for the user
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      $organiser_firstname = $data['firstname'];
      $organiser_surname = $data['surname'];
    }
    catch(PDOException $e) {
      echo $e->getMessage();
    }

    echo $organiser_firstname." ".$organiser_surname;
    ?>
    <br><br>
<!-- get the image filename (stored in the image column of the DB) and src the file in the images folder on the server -->
    <img src="images/<?= $row['image'] ?>" alt="<?= $row['name']?>" width="460" height="345"> 


    <br>

    <?php
  }
} 

//if the user is an organiser, show button to take to 'editdevent' page where they can change the details of the event

  if ($_SESSION['organiser']=='1' && $o_id==$_SESSION['id']){ 

?>

    <a href='editevent.php?event_id=<?php echo $eventid ?>'>Edit Event</a>

  <?php }

 ?>


<br><br><form action='index.php'>
  <input type="submit" value="HOME"/>
</form>
<!-- Button to go home

Link to the page to send an email to the event organiser -->
   <a href='sendemail.php?event_id=<?php echo $eventid ?>'>Send Email to Organiser</a>


