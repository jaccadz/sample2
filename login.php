 <?php
include 'core/init.php';
include 'includes/overall/slideheader.php';
?>
<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'>
		<p>
<?php 
if (empty($_POST) === false) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) === true || empty($password) === true){
		$errors[] = 'Please, kindly provide a username/password.';

	} else if (user_exists($username) === false) {
		$errors[] = 'Username or Password is incorrect.';
	} else if (user_active($username) === false){
		$errors[] = 'The account is already been deactivated. Please kindly contact the admins.';
	}else {
		$login = login($username, $password);
		if ($login === false){
			$errors[] =  'Username or Password is incorrect.';
		}else{
			// set the user session
			// redirect user to home
			$_SESSION['user_id'] = $login;
			header('Location: index.php');
			exit(); 
		}
	}
}else{
	$errors[] = 'No data received.';
}

if (empty($errors) === false){
	hasError(true);
	echo output_errors($errors);
}else{
	hasError(false);
}
?>
</p>
</div>
<article id='a-links' class='container'>
	<section class='sect1'>
		<a href="1">
		<strong>Lorem Ipsilum</strong><br>
		<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et al.</span><small>Read more..</small>
		</a>
	</section>
	<section class='sect2'>
		<a href="2">
		<strong>Lorem Ipsilum</strong><br>
		<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et al.</span><small>Read more..</small>
		</a>
	</section>
	<section class='sect3'>
		<a href="3">
		<strong>Lorem Ipsilum</strong><br>
		<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et al.</span><small>Read more..</small>	
		</a>
	</section>
	<div class='clearer'></div>
</article> <!-- **********  END MAIN CONTENT  *************8 -->

<?php
	include 'includes/overall/footer.php';
?>