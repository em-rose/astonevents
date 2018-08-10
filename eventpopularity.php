<?php 
include 'inc/dbconnect.php';


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
    $stmt = $db->query("SELECT * FROM events WHERE id = '$event_id'");
  }

  catch(PDOException $ex) {
    echo("Failed to get data from database.<br>");
    echo($ex->getMessage());
    exit;
  }

                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $eventname = $data['name'];

?>
   <h3><?php echo $eventname; ?></h3>
<h4>Interested students:</h4>
<?php


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
      ?>


      <li>
        <?=  $firstname." ".$surname ?>

      </li>

      <?php



    } else {
      echo "No students registered for event";
    }
  }
}
?>


<br><br><form action='index.php'>
  <input type="submit" value="HOME"/>
</form>



