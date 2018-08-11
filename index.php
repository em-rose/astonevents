<?php include_once 'inc/header.php';
include 'inc/dbconnect.php';
// include the header (containing signup and register) + the DB connection (allows SQL queries to be ran)

?>



<head><title>Aston Events Home</title>
  <style type="text/css">
  table { border: 1px solid black; }
  th, td { padding: 10px; 
    border-bottom: 1px solid #ddd;}
    tr:hover {background-color:#f5f5f5;}
    th {
      background-color:#006D9C;
      color: white;
    }

  </style>
</head>
<section class="main-container">
  <div class="wrapper">
    <h1>Aston Events</h1>
  </div>
</section>




<h3>Upcoming events</h3>


<?php
if (isset($_GET['orderby'])){ 
  $orderby = $_GET['orderby'];
  //sets the sort/filter depending on if the select has been submitted
  ?>

  <form id="order_select" method="get" action="index.php?search=order_id">
    <!-- Drop down select for filters & sorts for the list of events
      Selects the selected value depending on what sort is already selected -->
      <select name="orderby" id="order_id">
        <option value="category" <?php if ($orderby=='category'){ ?> selected=selected <?php } ?> >Category</option>
        <option value="name" <?php if ($orderby=='name'){ ?> selected=selected <?php } ?> >Name</option>
        <option value="datetime" <?php if ($orderby=='datetime'){ ?> selected=selected <?php } ?> >Date</option>
        <option value="popularity" <?php if ($orderby=='popularity'){ ?> selected=selected <?php } ?> >Popularity</option>
        <option value="sportonly" <?php if ($orderby=='sportonly'){ ?> selected=selected <?php } ?> >Sport events only</option>
        <option value="cultureonly" <?php if ($orderby=='cultureonly'){ ?> selected=selected <?php } ?> >Culture events only</option>
        <option value="otheronly" <?php if ($orderby=='otheronly'){ ?> selected=selected <?php } ?> >Other events only</option>
      </select>
      <input type="submit" value="Search" >
    </form>
  <?php } else { ?>
    <!-- Drop down list for the first load of the main page of events to select filter/sorts -->
    <form id="order_select" method="get" action="index.php?search=order_id">
      <select name="orderby" id="order_id">
        <option value="category" selected=selected >Category</option>
        <option value="name" >Name</option>
        <option value="datetime" >Date</option>
        <option value="popularity" >Popularity</option>
        <option value="sportonly" >Sport events only</option>
        <option value="cultureonly" >Culture events only</option>
        <option value="otheronly" >Other events only</option>
      </select>
      <input type="submit" value="Search" >
    </form>
    <?php
  }
  ?>


  <!--h1>MENU</h1-->
  <table class="data-table" id="table">
    <thead> <!-- Headers for the list of events table - only shows the More info and Interest columns if a user is logged in -->
      <tr>
        <th>Event name</th>
        <th>Category</th>
        <th>Description</th>
        <th>Date</th>
        <th>Popularity</th>
        <?php if (isset($_SESSION['email'])){ ?>
          <th>More info</th>
          <th>Interest</th>

        <?php } ?>
        <th>Organiser</th>
      </tr>
    </thead>
    <tbody>

      <?php

      try {
//Runs the Db query depending on the sort that was selected by the select drop down.
        if (isset($_GET['orderby'])){
          $orderby=$_GET['orderby'];
          if ($_GET['orderby']=="popularity") {
            $rows = $db->query("SELECT E.`id`,E.`name`,E.`category`, E.`venue`,E.`description`,E.`datetime`, COUNT(*) AS popularity
              FROM `events` E 
              LEFT OUTER JOIN `event_interest` EI 
              ON EI.`event_id` = E.`id` 
              GROUP BY E.`id`
              ORDER BY `popularity` desc
              ");
        //Calculates the popularity by counting the number of times the event ID is in the event_interest table and sorts by it

          } elseif ($_GET['orderby']=="name") {
            $rows = $db->query("SELECT * FROM events ORDER BY name ASC");
        //Sort the results by event name

          } elseif ($_GET['orderby']=="datetime") {
            $rows = $db->query("SELECT * FROM events ORDER BY `datetime` ASC");
        //Sort the results by date

          } elseif ($_GET['orderby']=="sportonly") {
            $rows = $db->query("SELECT * FROM events WHERE `category` = 'Sport'");
        //Filter the events into sport only

          } elseif ($_GET['orderby']=="cultureonly") {
            $rows = $db->query("SELECT * FROM events WHERE `category` = 'Culture'");
        //Filter the events into culture only

          } elseif ($_GET['orderby']=="otheronly") {
            $rows = $db->query("SELECT * FROM events WHERE `category` = 'Other'");
        //Filter the events into other only

          }else {
            $rows = $db->query("SELECT * FROM events ORDER BY category ASC");
        } //if orderby isnt set, order by category
      }
      else {
        $rows = $db->query("SELECT * FROM events");
        //if orderby isnt set, just select all the events
      }




      if($rows->rowCount() > 0) {
        foreach($rows as $row) {
          $eventid=$row['id'];
//Loop through each result row of the event results
          //set usable variables from the row result






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
                //get the popularity on the fly for the current ID
              }
              catch(PDOException $e) {
                echo $e->getMessage();
                //error if the DB query fails
              }
              if (isset($popularity)){
                echo $popularity;
              } else {
                echo "0";
                //if count returns a null, default to 0
              }
              
              ?>


            </td>

            <?php 
            if (isset($_SESSION['email'])){ 
//if a user is logged in, show more details option
              ?>
              <td>
                <a href='eventdetails.php?event_id=<?php echo $eventid ?>'>More details</a>
              </td>
              <td>

                <?php
//if user logged in, show the register and unregister interest.
              //will show register if they are not found in events_interest for that event id
              // else will show unregister if they already exist
              //calls seperate scripts to update the events_interest table

                $u_id = $_SESSION['id'];

                try{
                  $stmt = $db->query("SELECT E.`name`,E.`id` 
                    FROM `events` E 
                    RIGHT OUTER JOIN event_interest EI 
                    ON E.`id`=EI.`event_id` 
                    RIGHT OUTER JOIN users U 
                    ON EI.`user_id` = U.`id` 
                    WHERE user_id='$u_id' 
                    AND E.`id` = '$e_id'
                    ");

                  $data = $stmt->fetch(PDO::FETCH_ASSOC);

                }
                catch(PDOException $e) {
                  echo $e->getMessage();
                }
                if (isset($data['name'])) {

                  ?>
                  <a href='unregisterinterest.php?event_id=<?php echo $eventid ?>'>Unregister</a>
                  <?php
                } else {
                  ?>
                  <a href='registerinterest.php?event_id=<?php echo $eventid ?>'>Register</a>
                <?php } ?>


              </td>
              <?php

            }
            ?>

            <td>
              <?php
              $e_id = $row['id'];
            //if user logged in:
              try{
                $stmt = $db->query("SELECT `firstname`,`surname`,`name` FROM `events` E
                  INNER JOIN `users` U
                  ON E.`organiser_id` = U.`id`
                  WHERE E.`id` = '$e_id'");

                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $organiser_firstname = $data['firstname'];
                $organiser_surname = $data['surname'];
              //get the organiser name from the user table joined through to select the right user for that event + outputs into readable form
              }
              catch(PDOException $e) {
                echo $e->getMessage();
              }

              echo $organiser_firstname." ".$organiser_surname;
              ?>


            </td>
          </tr>

          <?php
        }
      } else {
        echo("<tr><td colspan=5>No results.</td></tr>");
      //if no results found in DB then output this error
      }
    } catch(PDOException $ex) {
      echo("Failed to get data from database.<br>");
      echo($ex->getMessage());
      exit;
    //DB error message output
    }

    ?>

  </tbody>
</table>
<br><br>


<?php


if (isset($_SESSION['email'])){
//if the user is an organiser, show button to take to 'myevents' page - will show just their organised events

  if ($_SESSION['organiser']=='1'){ 
    $o_id=$_SESSION['id'];
    //if a user is logged in and they are an organiser, show a link to a list of their events
    ?>
    <form action='myevents.php'>
      <input type="submit" value="See My Events"/>
    </form>
  <?php }

}

?>