<?php
require 'inc/dbconnect.php';
if (isset($_GET['event_id'])){
  $event_id=$_GET['event_id'];
  //get the event_id from the URL that was send from the previous page
}
if(isset($_POST['update'])) {
  //if the HTML form has been posted then...
  $errMsg = '';
  //set to NULL
    // Get data from FROM
  $name = $_POST['name'];
  $description = $_POST['description'];
  $venue = $_POST['venue'];
  $eventdate = $_POST['eventdatetime'];
  if ($_POST['category']=="sport"){
    $category="Sport";
  } elseif ($_POST['category']=="culture"){
    $category="Culture";
  } elseif ($_POST['category']=="other"){
    $category="Other";

    if($name == '')
      $errMsg = 'Enter your event name';
    if($eventdate == '')
      $errMsg = 'Enter the event date and time';
    if($venue == '')
      $errMsg = 'Enter the venue';
    if($description == '')
      $errMsg = 'Enter a description for the event';
    if(!isset($category))
      $errMsg = 'Please select event type';
// error message that will be output if the form isnt correctly filled out

  }


  if($errMsg == ''){
    try{
// if no errors then...
      $sth=$db->prepare("UPDATE `events` 
        SET
        `category`=:category,
        `name`=:name,
        `datetime`=:eventdate,
        `description`=:description,
        `venue`=:venue 
        WHERE `id` = '$event_id'
        ");
      $sth->bindParam(':category', $category, PDO::PARAM_STR, 64);
      $sth->bindParam(':name', $name, PDO::PARAM_STR, 50);
      $sth->bindParam(':eventdate', $eventdate, PDO::PARAM_STR, 50);
      $sth->bindParam(':description', $description, PDO::PARAM_STR, 100);
      $sth->bindParam(':venue', $venue, PDO::PARAM_INT);
      $sth->execute();
//run update statement on the DB for this event id
      ?>
      <p>Successfully updated your event! </p>
      <a href='/astonevents/index.php'>Click here to go back home</a>

      <?php
// successful message and link to go back home.
    } catch (PDOException $ex) {
//this catches the exception when it is thrown
      ?>
      <p>Sorry, a database error occurred. Please try again.</p>

      <p>(Error details: <?= $ex->getMessage() ?>)</p>
      <a href='/astonevents/index.php'>Back to home</a>

      <?php
      //link to go home if it errors
    }


  }
}









if(isset($_GET['action']) && $_GET['action'] == 'joined') {
  $errMsg = 'Event edited. Go <a href="/astonevents/index.php">home</a> to see events';
}
//success message output when form has been completed, links back to home page







//get event details for the event id sent to the page

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



?>


<html>
<head><title>Edit event</title></head>
<style>
html, body {
  margin: 1px;
  border: 0;
}
</style>






<?php





if($rows->rowCount() > 0) {
  foreach($rows as $row) {
    $eventid=$row['id'];

    //output the row results to a form for editing
    //puts the default value into the form
    //submits and sets the php going
    ?>




    <body>
      <div align="center">
        <div style=" border: solid 1px #006D9C; " align="left">
          <?php
          if(isset($errMsg)){
            echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
          }
          ?>
          <div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Edit <?= $row['name'] ?></b></div>
          <div style="margin: 15px">
            <form action="" method="post">
              Event Name <br>
              <input type="text" name="name" value="<?= $row['name'] ?>" autocomplete="off" class="box"/><br /><br />
              Description <br>
              <input type="text" name="description" value="<?= $row['description'] ?>" autocomplete="off" class="box"/><br /><br />

              Please Choose Category: <br>
              Sport <input type="radio" value="sport" name="category" <?php if ($row['category']=='Sport'){ ?> checked <?php } ?> required />

              Culture <input type="radio" value="culture" name="category" <?php if ($row['category']=='Culture'){ ?> checked <?php } ?> />

              Other <input type="radio" value="other" name="category" <?php if ($row['category']=='Other'){ ?> checked <?php } ?> /><br /><br />

              Venue: <br>
              <input type="text" name="venue" value="<?= $row['venue'] ?>" autocomplete="off" class="box"/><br /><br />
              Date and time: <br>
              <input type="datetime-local" name="eventdatetime" value="<?= $row['datetime'] ?>" autocomplete="off" class="box"/><br /><br />

              <input type="submit" name='update' value="Update" class='submit'/><br />
            </form>


          </div>
        </div>
        <br><br><form action='/astonevents/index.php'>
          <!-- home button -->
          <input type="submit" value="Home"/>
        </form>
      </div>
    </body>
    </html>


    <?php
  }
}
?>