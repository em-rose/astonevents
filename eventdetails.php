<?php 
include 'inc/dbconnect.php';
session_start();

// Uploaded image to the file server
// Store file name in the DB





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

  try{
    $rows = $db->query("SELECT * FROM events WHERE id = '$event_id'");
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
    ?>


    <h3><?php echo $row['name']; ?></h3>

    Category : <?php echo $row['category']; ?><br>
    Description : <?php echo $row['description']; ?><br>
    Datetime of event : <?php echo $row['datetime']; ?><br>
    Popularity : <?php
    $e_id = $row['id'];
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

    <?php
    echo '<img src="data:image/jpeg;base64,'.base64_encode( $data['picture'] ).'"/>'; 

    ?>

    <br>

    <?php
  }
} 
 echo $o_id."<br>";
 echo $_SESSION['id'];


//if the user is an organiser, show button to take to 'myevents' page - will show just their organised events

  if ($_SESSION['organiser']=='1' && $o_id==$_SESSION['id']){ 

?>

    <a href='editevent.php?event_id=<?php echo $eventid ?>'>Edit Event</a>

  <?php }

 ?>


<br><br><form action='index.php'>
  <input type="submit" value="HOME"/>
</form>



