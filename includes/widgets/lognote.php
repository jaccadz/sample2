<div id='log-note'>Error</div>

<?php
	include '../../core/init.php';

?>

<div id='log-note' style='display:block'>
		
<?php 
if (empty($_POST) === false) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) === true || empty($password) === true){
		echo 'Please provide a username and password.';

	} else if (user_exists($username) === false) {
		echo 'Username does not exists.';
	} else {
		$login = login($username, $password);
		if ($login === false){
			echo 'Username/Password is incorrect.';
		}else{
			// set the user session
			// redirect user to home
			$_SESSION['user_id'] = $login;
			header('Location: index.php');
			exit(); 
 
		}
	}


}
?>
</p>
</div>