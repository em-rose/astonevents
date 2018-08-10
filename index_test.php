<?php include_once 'inc/header.php';
include 'inc/dbconnect.php';

?>
<head>
  <title>Aston Events Home</title>
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->

  <link rel="stylesheet" type="text/css" href="../css/stylesheet.css"/>
  <link rel="stylesheet" type="text/css" href="../css/modal.css"/>
  <style type="text/css">
  table { border: 1px solid black; }
  th, td { padding: 5px; }
</style>
</head>
<section class="main-container">
  <div class="wrapper">
    <h1>Aston Events</h1>
  </div>
</section>




<h3>Upcoming events</h3>






<form id="order_select" method="get" action="index.php?search=order_id">
  <select name="orderby" id="order_id">
    <option value="category">Category</option>
    <option value="name">Name</option>
    <option value="datetime">Date</option>
    <option value="popularity">Popularity</option>
  </select>
  <input type="submit" value="Search" >
</form>

<a href='index.php?filter=sport'>Sports</a>

<form action='index.php?filter=sport'>
  <input type="submit" value="Sport"/>
</form>
<form action='index.php?filter=culture'>
  <input type="submit" value="Culture"/>
</form>
<form action='index.php?filter=other'>
  <input type="submit" value="Other"/>
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
      <?php if (isset($_SESSION['email'])){ ?>
        <th>More info</th>
      <?php } ?>
      <th>Organiser</th>
    </tr>
  </thead>
  <tbody>

    <?php

//Get filter from the button clicked - value in URL, else ALL
    if (isset($_GET['filter'])){
      if ($_GET['filter']=='sport'){
        $filter = "(SELECT `id` FROM events WHERE category='sport')";
      } elseif ($_GET['filter']=='culture'){
        $filter = "(SELECT `id` FROM events WHERE category='culture')";
      } elseif ($_GET['filter']=='other'){
        $filter = "(SELECT `id` FROM events WHERE category='other')";
      }
    }else {
      $filter = "(SELECT `id` FROM events)";
    }


    try {

      if (isset($_GET['orderby'])){
        if ($_GET['orderby']=="popularity") {
          $rows = $db->query("SELECT * FROM events WHERE `id` IN '$filter' ORDER BY `popularity` ASC");
        //echo "SELECT * FROM events ORDER BY `popularity` ASC";

        } elseif ($_GET['orderby']=="name") {
          $rows = $db->query("SELECT * FROM events WHERE `id` IN '$filter' ORDER BY name ASC");
        //echo "SELECT * FROM events ORDER BY name DESC";

        } elseif ($_GET['orderby']=="datetime") {
          $rows = $db->query("SELECT * FROM events WHERE `id` IN '$filter' ORDER BY `datetime` ASC");
        //echo "SELECT * FROM events ORDER BY `datetime` ASC";

        } 
      }
      else {
        $rows = $db->query("SELECT * FROM events 
          WHERE `id` 
          IN 
          (SELECT `id` FROM events)");
        //echo "SELECT * FROM events ORDER BY category DESC";
      }




      if($rows->rowCount() > 0) {
        foreach($rows as $row) {
          $eventid=$row['id'];
//Select organiser - JOIN to user table






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
              if (isset($popularity)){
                echo $popularity;
              } else {
                echo "0";
              }
              
              ?>


            </td>




            <?php 
            if (isset($_SESSION['email'])){ ?>
             <td>

              <a href='eventdetails.php?event_id=<?php echo $eventid ?>'>More details</a>
            </td>
          <?php }
          ?>





          <td>
            <?php
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

  ?>

</tbody>
</table>
<br><br>


<?php

if (isset($_SESSION['organiser'])){


  if ($_SESSION['organiser']=='1'){ 

    ?>
    <form action='myevents.php'>
      <input type="submit" value="My Events"/>
    </form>





  <?php }
}


//WHERE ID IN ($filter)





?>