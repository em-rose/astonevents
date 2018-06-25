<?php

//fetch the deposit amount and get the new balance;
if (isset($_POST["deposit"])) {
# You could reference the withdraw.php to write this part; 
# firstly you need to check and ensure that the user has enter a valid value for deposit, 
# then call the model's deposit method which will update balance 
# then you should display the new balance
	if (preg_match('/^[0-9]+$/',trim($_POST["amount"]))){

		$balance = $this->model->deposit($_POST["id"], $_POST["amount"]);

		if ($balance != null){
			echo "<b><h3>Your New balance is: &pound; $balance</h3></b>";
		} else echo "<p>Sorry, transaction failure.</p>";
	
	} else { //validation fail
		echo "<p>Sorry, Please enter a postive integer.</p>";
	}

} 
else { //display the form	
?>
<h1>Deposit</h1>
<form method="post" action="">
<div>	Please enter the account ID
        <input type="text" name="id"/> </br><br>
		Please enter the amount to deposit
		<input type="text" name="amount"/>
        <input type="submit" name="deposit" value="deposit">
</div>
</form>
<?php
}
?>	