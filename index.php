<?php include_once 'inc/header.php';
include 'inc/dbconnect.php';

?>
<head>
  <title>Aston Events Home</title>
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




<?php
if (isset($_GET['orderby'])){ 
  $orderby = $_GET['orderby'];
  ?>

  <form id="order_select" method="get" action="index.php?search=order_id">
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
  <form id="order_select" method="get" action="index.php?search=order_id">
    <select name="orderby" id="order_id">
      <option value="category" selected=selected >Category</option>
      <option value="name" >Name</option>
      <option value="datetime" >Date</option>
      <option value="popularity" >Popularity</option>
    </select>
    <input type="submit" value="Search" >
  </form>
  <?php
}
?>







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
        <th>Interest</th>

      <?php } ?>
      <th>Organiser</th>
    </tr>
  </thead>
  <tbody>

    <?php

    try {

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
        //echo "SELECT * FROM events ORDER BY `popularity` ASC";

        } elseif ($_GET['orderby']=="name") {
          $rows = $db->query("SELECT * FROM events ORDER BY name ASC");
        //echo "SELECT * FROM events ORDER BY name DESC";

        } elseif ($_GET['orderby']=="datetime") {
          $rows = $db->query("SELECT * FROM events ORDER BY `datetime` ASC");
        //echo "SELECT * FROM events ORDER BY `datetime` ASC";

        } elseif ($_GET['orderby']=="sportonly") {
          $rows = $db->query("SELECT * FROM events WHERE `category` = 'Sport'");
        //echo "SELECT * FROM events ORDER BY `datetime` ASC";

        } elseif ($_GET['orderby']=="cultureonly") {
          $rows = $db->query("SELECT * FROM events WHERE `category` = 'Culture'");
        //echo "SELECT * FROM events ORDER BY `datetime` ASC";

        } elseif ($_GET['orderby']=="otheronly") {
          $rows = $db->query("SELECT * FROM events WHERE `category` = 'Other'");
        //echo "SELECT * FROM events ORDER BY `datetime` ASC";

        }else {
          $rows = $db->query("SELECT * FROM events ORDER BY category ASC");
        } 
      }
      else {
        $rows = $db->query("SELECT * FROM events");
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
            <td>

              <?php


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
            try{
              $stmt = $db->query("SELECT `firstname`,`surname`,`name` FROM `events` E
                INNER JOIN `users` U
                ON E.`organiser_id` = U.`id`
                WHERE E.`id` = '$e_id'");

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


if (isset($_SESSION['email'])){
//if the user is an organiser, show button to take to 'myevents' page - will show just their organised events

  if ($_SESSION['organiser']=='1'){ 
    $o_id=$_SESSION['id'];
    
    ?>
    <a href='myevents.php?organiser=<?php echo $o_id ?>'>My Events</a>

  <?php }

}

?>