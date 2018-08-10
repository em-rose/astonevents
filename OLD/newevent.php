<?php

session_start();

?>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form id="sign_up" method="post" action="register/addnewevent.php">
      <div class="header">   
        <h3>Add a new event</h3>
        <p>Enter the event details below</p>
      </div>  
      <div class="sep"></div>
      <div class="inputs">

        Event name: <input type="text" name="event_name" required /><br />

        Date & time: <input type="datetime-local" name="datetime" required/><br />

        Venue: <input type="text" name="venue" required /><br /><br />

        Choose category: <br>
        Sport <input type="radio" value="sport" name="category" required />
        Culture <input type="radio" value="culture" name="category" required />
        Other <input type="radio" value="sport" name="other" required /><br /><br />

        Description: <input type="text" name="password" required /><br />



        Your organiser ID: 


        <?php
        if (isset($_SESSION['id'])){
        //if the user is an organiser, show button to take to 'myevents' page - will show just their organised events
          $o_id = $_SESSION['id'];
            ?>
            <form id="order_select" method="get" action="index.php?search=order_id">
              <select name="orderby" id="order_id">
                <option value="<?= $o_id ?>"><?= $o_id?></option>
              </select>
              <input type="submit" value="Search" >
            </form><br />

          <?php
        }
        ?>




        Image: <input type="file" name="image" required/><br />

        <button type="submit" id="submit" href="#">Add event </a>

        </div>

      </form>
    </div>
  </div>

  <script src="../js/validate.js"></script>
  <script src="../js/modal.js"></script>