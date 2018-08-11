<?php 
session_start();
include 'inc/dbconnect.php';

//include DB config file, allows for DB connections
$o_id=$_SESSION['id'];
?>
<head>
  <title>Aston Events - My Events</title>
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
    <h1>Aston Events - My Events</h1>
  </div>
</section>

<?php
if (isset($_GET['orderby'])){ 
  $orderby = $_GET['orderby'];
  //sets the sort/filter depending on if the select has been submitted
  ?>

  <form id="order_select" method="get" action="myevents.php?search=order_id">
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
  <form id="order_select" method="get" action="myevents.php?search=order_id">
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





<!--The table headings for the results -->
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
//set orderby to the value from the select list
    //if none selected, just set it to order by category


    if (isset($_GET['orderby'])){
      $orderby=$_GET['orderby'];
    } else {
      $orderby="category";
    }

    try {
//depending on the order by chosen from the select, run the corresponding db query 
      if ($orderby=="category") {
        $rows = $db->query("SELECT * FROM events WHERE organiser_id = '$o_id' ORDER BY category DESC");
        

      } elseif ($orderby=="name") {
        $rows = $db->query("SELECT * FROM events WHERE organiser_id = '$o_id' ORDER BY name ASC");
        
        
      } elseif ($orderby=="datetime") {
        $rows = $db->query("SELECT * FROM events WHERE organiser_id = '$o_id' ORDER BY `datetime` ASC");
        
      } elseif ($orderby=="popularity") {
//query to count the popularity of an event using the event_interest page, then sorting by it
        $rows = $db->query("SELECT E.`id`,E.`name`,E.`category`, E.`venue`,E.`description`,E.`datetime`, COUNT(*) AS popularity
          FROM `events` E 
          LEFT OUTER JOIN `event_interest` EI 
          ON EI.`event_id` = E.`id` 
          WHERE E.`organiser_id` = '$o_id'
          GROUP BY E.`id`
          ORDER BY `popularity` desc
          ");
      }  elseif ($_GET['orderby']=="sportonly") {
        $rows = $db->query("SELECT * FROM events WHERE `category` = 'Sport' AND organiser_id = '$o_id'");
        //Filter the events into sport only

      } elseif ($_GET['orderby']=="cultureonly") {
        $rows = $db->query("SELECT * FROM events WHERE `category` = 'Culture' AND organiser_id = '$o_id'");
        //Filter the events into culture only

      } elseif ($_GET['orderby']=="otheronly") {
        $rows = $db->query("SELECT * FROM events WHERE `category` = 'Other' AND organiser_id = '$o_id'");
        //Filter the events into other only
      }



      if($rows->rowCount() > 0) {
        foreach($rows as $row) {
//loops through the results, one row at a time, outputting the values into the table
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
//calculates popularity on the fly for each event
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $popularity = $data['popularity'];
              }
              catch(PDOException $e) {
                echo $e->getMessage();
              }
              if (isset($popularity)){ ?>
                <a href='eventpopularity.php?event_id=<?php echo $eventid ?>'><?php echo $popularity; ?></a>
              <?php 
//the popularity number becomes a link to the eventpopularity.php page - the user can see who is signed up for their event
            } else {
                echo "0";
              }

              ?>


            </td>
            <td>
              <a href='editevent.php?event_id=<?php echo $eventid ?>'>Edit details</a>
              <!-- link to edit the event. takes the user to the editevent page, and send the event id so the right event details are loaded for editing -->
            </td>
          </tr>

          <?php
        }
      } else {
        echo("<tr><td colspan=5>No events have been found for your user.</td></tr>");
        //if no results are found in the db, output a message for the user
      }
    } catch(PDOException $ex) {
      echo("Failed to get data from database.<br>");
      echo($ex->getMessage());
      exit;
    }

    ?>

  </tbody>
</table>





<!-- Buttons to go to add a new event, and to go home -->
<br><br><form action='newevent.php'>
  <input type="submit" value="Add New Event"/>
</form>


<br><br><form action='index.php'>
  <input type="submit" value="Home"/>
</form>


