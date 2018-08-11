<?php
require 'inc/dbconnect.php';
//Include the db config file for the insert statement
session_start();
//get the ID from the session variables
$o_id=$_SESSION['id'];




if(isset($_POST['addevent'])) {
//if the form has been submitted do the following...



//code to upload the image to the local file server
  echo "file being uploaded";
  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  echo $target_file;
  $uploaderror = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploaderror = 0;
  }
//check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploaderror = 0;
  }
// Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploaderror = 0;
}
// Check if $uploaderror is set to 0 by an error
if ($uploaderror == 0) {
  echo "Sorry, your file was not uploaded."; ?>
  <a href='newevent.php'>Click here to reload the page & try again</a>

  <?php
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    //header("Location: newevent.php");
  } else {
    echo "There was an error uploading your file, please try again later";
  }
}



$errMsg = '';
    // Get data from the form
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
//if no errors from the form run the insert into the DB
    $sth=$db->prepare("INSERT INTO `events`(
      `category`, 
      `name`, 
      `datetime`, 
      `description`, 
      `organiser_id`, 
      `venue`,
      `image`)
      VALUES (
      :category,
      :name,
      :eventdate,
      :description,
      :o_id,
      :venue,
      :image) 
      ");
    $sth->bindParam(':category', $category, PDO::PARAM_STR, 64);
    $sth->bindParam(':name', $event_name, PDO::PARAM_STR, 50);
    $sth->bindParam(':eventdate', $eventdate, PDO::PARAM_STR, 50);
    $sth->bindParam(':description', $description, PDO::PARAM_STR, 256);
    $sth->bindParam(':o_id', $o_id, PDO::PARAM_INT);
    $sth->bindParam(':venue', $venue, PDO::PARAM_STR,50);
    $sth->bindParam(':image', $target_file, PDO::PARAM_STR,50);
    $sth->execute();

//output success message if new event successfully added, and link to go home
    ?>
    <p>Event successfully added! </p>
    <a href='/astonevents/index.php'>Click here to go back home & see the events</a>

    <?php

  } catch (PDOException $ex) {
//this catches the exception when it is thrown
    //outputs error if insert fails
    ?>
    <p>Sorry, a database error occurred. Please try again.</p>

    <p>(Error details: <?= $ex->getMessage() ?>)</p>
    <a href='/astonevents/newevent.php'>Back to add new event</a>

    <?php
  }


}
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
          <!-- Form below to add a new event -->
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

            Your organiser ID: <?= $o_id ?> <!-- Automatically sets the organiser ID from what is in the SESSION (as set at the top of the page) -->
            <?php
            if (isset($_SESSION['id'])){
              ?>
              <form id="order_select" method="get" action="">
                <select name="organiser_id" id="order_id">
                  <option value="<?= $o_id ?>"><?= $o_id?></option>
                </select>
              </form>

              <?php
            }
            ?>
            <br />



<!-- Form to upload an image for the event -->
            <form action="" method="post" enctype="multipart/form-data">
              Select image to upload:
              <input type="file" name="fileToUpload" id="fileToUpload">
              <input type="submit" value="Upload Image" name="upload">
            </form>
            <br><br>

<!-- Button to initiate the php above -->
            <input type="submit" name='addevent' value="Add Event" class='submit'/><br />

          </div>

        </form>


      </div>
    </div>

    <a href='myevents.php'>Back to My Events</a>
<!-- Link to go back to myevents and button to go home -->
    <br><br><form action='/astonevents/index.php'>
      <input type="submit" value="Home"/>
    </form>
  </div>
</body>
</html>