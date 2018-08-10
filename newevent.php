<?php
require 'inc/dbconnect.php';
    if (isset($_GET['organiser'])){
      $organiser_id=$_GET['organiser'];

}




if(isset($_POST['addevent'])) {
  $errMsg = '';
    // Get data from FROM
  $event_name = $_POST['event_name'];
  $eventdate = $_POST['datetime'];
  $venue = $_POST['venue'];
  $description = $_POST['description'];


  if ($_POST['category']=="sport"){
    $category="Sport";
  } elseif ($_POST['category']=="culture"){
    $category="Culture";
  } elseif ($_POST['category']=="other"){
    $category="Other";

    if($event_name == '')
      $errMsg = 'Enter your event name';
    if($eventdate == '')
      $errMsg = 'Enter the event date and time';
    if($venue == '')
      $errMsg = 'Enter the venue';
    if($description == '')
      $errMsg = 'Enter a description for the event';
    if(!isset($category))
      $errMsg = 'Please select event type';


  }


  if($errMsg == ''){
    try{

      $sth=$db->prepare("INSERT INTO `events`(
        `category`, 
        `name`, 
        `datetime`, 
        `description`, 
        `organiser_id`, 
        `venue`)
        VALUES (
        :category,
        :name,
        :eventdate,
        :description,
        :organiser_id,
        :venue) 
        ");
      $sth->bindParam(':category', $category, PDO::PARAM_STR, 64);
      $sth->bindParam(':name', $event_name, PDO::PARAM_STR, 50);
      $sth->bindParam(':eventdate', $eventdate, PDO::PARAM_STR, 50);
      $sth->bindParam(':description', $description, PDO::PARAM_STR, 256);
      $sth->bindParam(':organiser_id', $organiser_id, PDO::PARAM_INT);
      $sth->bindParam(':venue', $venue, PDO::PARAM_STR,50);
      $sth->execute();


      ?>
      <p>Successfully added! </p>
      <a href='/astonevents/index.php'>Click here to go back home & see the events</a>

      <?php

    } catch (PDOException $ex) {
//this catches the exception when it is thrown
      ?>
      <p>Sorry, a database error occurred. Please try again.</p>

      <p>(Error details: <?= $ex->getMessage() ?>)</p>
      <a href='/astonevents/newevent.php'>Back to add new event</a>

      <?php
    }


  }
}

if(isset($_GET['action']) && $_GET['action'] == 'joined') {
  $errMsg = 'Event added! View it on the <a href="/astonevents/index.php">home page</a>';
}
?>

<html>
<head><title>Add Event</title></head>
<style>
html, body {
  margin: 1px;
  border: 0;
}
</style>
<body>
  <div align="center">
    <div style=" border: solid 1px #006D9C; " align="left">
      <?php
      if(isset($errMsg)){
        echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
      }
      ?>
      <div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Add new event</b></div>
      <div style="margin: 15px">
        <form action="" method="post">
          <div class="header">   
            <h3>Enter the event details below</h3>
          </div>  
          <div class="sep"></div>
          <div class="inputs">

            Event name: <input type="text" name="event_name" required /><br />

            Date & time: <input type="datetime-local" name="datetime" required/><br />

            Venue: <input type="text" name="venue" required /><br /><br />

            Choose category: <br>
            Sport <input type="radio" value="sport" name="category" required />
            Culture <input type="radio" value="culture" name="category" required />
            Other <input type="radio" value="other" name="category" required /><br /><br />

            Description: <input type="text" name="description" required /><br />



            Your organiser ID: <?= $organiser_id ?>


            <?php
            if (isset($_SESSION['id'])){
        //if the user is an organiser, show button to take to 'myevents' page - will show just their organised events
              $o_id = $_SESSION['id'];
              ?>
              <form id="order_select" method="get" action="index.php?search=order_id">
                <select name="organiser_id" id="order_id">
                  <option value="<?= $o_id ?>"><?= $o_id?></option>
                </select>
                <input type="submit" value="Search" >
              </form>

              <?php
            }
            ?>
            <br />



            Image: <input type="file" name="image" required/><br />

            <input type="submit" name='addevent' value="Add Event" class='submit'/><br />

          </div>

        </form>


      </div>
    </div>
    <br><br><form action='/astonevents/index.php'>
      <input type="submit" value="Home"/>
    </form>
  </div>
</body>
</html>