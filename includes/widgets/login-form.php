<div id='login'>
<form action='login.php' method='POST' name='login'>
	
	<h1>Member Login</h1>
	<div class='log-row'>
		<label>Username : </label>
		<input type='text' name='username' tabindex='1'>
	</div>
	<div class='log-row'>
		<label>Password :</label>
		<input type='password' name='password' tabindex='2'>
	</div>
		<div class='log-row'>
		<input id='log-button'type='submit' value='Login' tabindex='3'>
	</div>

	<?php
		if (empty($errors) === false){ 
		echo output_errors($errors);
	?>
		<div id='log-note' style='display:block'>
	<?php 
	}else{ ?>
		<div id='log-note' style='display:none'>
	<?php
	}
	?>
	</div>
	<div id='links'>
		<a href="register.php"><small>Sign up</small></a><br>
		<a href="#"><small>Forgot your password ?</small></a>	
	</div>							
</form>		
</div>
<div class='clearer'></div>
