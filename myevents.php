<?php 
session_start();
include 'inc/dbconnect.php';
echo $_SESSION['id'];
?>
<head>
  <title>Aston Events - My Events</title>
  <style type="text/css">
  table { border: 1px solid black; }
  th, td { padding: 5px; }
</style>
</head>
<section class="main-container">
  <div class="wrapper">
    <h1>Aston Events - My Events</h1>
  </div>
</section>




<h3></h3>






<form id="order_select" method="get" action="myevents.php?search=order_id&organiser=<?php echo $o_id ?>">
  <select name="orderby" id="order_id">
    <option value="category">Category</option>
    <option value="name">Name</option>
    <option value="datetime">Date</option>
    <option value="popularity">Popularity</option>
  </select>
  <input type="submit" value="Search" >
</form>






<!--h1>MENU</h1-->
<table class="data-table" id="table">
  <thead>
    <tr>
      <th>Event name</th>
      <th>Category</th>
      <th>Description</th>
      <th>Date</th>
      <th>Popularity</th>
      <th>Edit</th>
    </tr>
  </thead>
  <tbody>

    <?php


    if (isset($_GET['organiser'])){
      $organiserid=$_GET['organiser'];

    

    if (isset($_GET['search'])){
      $_SESSION['orderby']=$_GET['search'];
    } else {
      $_SESSION['orderby']="category";
    }

    try {

      if ($_SESSION['orderby']=="category") {
        $o_id=$_SESSION['id'];
        echo $o_id;
        $rows = $db->query("SELECT * FROM events WHERE organiser_id = '$o_id' ORDER BY category DESC");
        

      } elseif ($_SESSION['orderby']=="name") {
        $o_id=$_SESSION['id'];
        echo $o_id;
        $rows = $db->query("SELECT * FROM events WHERE organiser_id = '$o_id' ORDER BY name DESC");
        
        
      } elseif ($_SESSION['orderby']=="datetime") {
        $rows = $db->query("SELECT * FROM events WHERE organiser_id = '$organiserid' ORDER BY `datetime` ASC");
        
      } elseif ($_SESSION['orderby']=="popularity") {

        $rows = $db->query("SELECT E.`id`,E.`name`,E.`category`, E.`venue`,E.`description`,E.`datetime`, COUNT(*) AS popularity
            FROM `events` E 
            LEFT OUTER JOIN `event_interest` EI 
            ON EI.`event_id` = E.`id` 
            GROUP BY E.`id`
            ORDER BY `popularity` desc
            ");
      }




      if($rows->rowCount() > 0) {
        foreach($rows as $row) {

          $eventid=$row['id'];
          ?>

          <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['datetime'] ?></td>
            
            <td>
              <?php
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
              if (isset($popularity)){ ?>
                <a href='eventpopularity.php?event_id=<?php echo $eventid ?>'><?php echo $popularity; ?></a>


              <?php } else {
                echo "0";
              }
              
              ?>


            </td>
            <td>
              <a href='editevent.php?event_id=<?php echo $eventid ?>'>Edit details</a>
            </td>
          </tr>

          <?php
        }
      } else {
        echo("<tr><td colspan=5>No results.</td></tr>");
      }
    } catch(PDOException $ex) {
      echo("Failed to get data from database.<br>");
      echo($ex->getMessage());
      exit;
    }
} else {
  echo("<tr><td colspan=5>No results.</td></tr>");
}
    
$o_id=$_SESSION['id'];
    ?>

  </tbody>
</table>


<?php

    
    ?>
    <a href='newevent.php?organiser=<?php echo $o_id ?>'>Add new event</a>


<br><br><form action='index.php'>
  <input type="submit" value="HOME"/>
</form>


