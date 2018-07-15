<?php include_once 'inc/header.php'; 

?>
  <section class="main-container">
    <div class="wrapper">
        <h2>Aston Events</h2>
    </div>
  </section>
  

<?php 
	
	include_once("controller/controller.php");

	$controller = new Controller();
	$controller->invoke();

?>