<?php  

	include 'core/init.php';
	include 'includes/overall/header.php';
	if  (empty($_POST) === false){
			$required_fields = array('current_password', 'new_password', 're_password');
			foreach ($_POST as $key => $value) {
				if (empty($value) && in_array($key, $required_fields) === true) {
					$errors[] = 'Please fill up all remaining required fields.';
					break 1;
				}
			}

			if (trim($_POST['current_password']) === $user_data['user_pass']){
				if(trim($_POST['new_password']) !== trim($_POST['re_password'])){
					$errors[] = 'Your new passwords do not match.';
				}
			
			}else{
				$errors[] = 'Current password is incorrect.';
			}
	}
?>

<?php

	if (isset($_GET['success']) && empty($_GET['success'])){
		echo "<div class='general-note' style='margin-bottom: 50px;height:50px; padding-top: 40px;display:block;  margin-top:-9px; '>
				<p>Password successfully changed. <a href='index.php' style='text-decoration: underline; color:orange;'><u>Home</u></a></p> </div>";
	}else {

		if (empty($_POST) === false && empty($errors) === true){

			change_password($session_user_id, $_POST['new_password']);
			header('Location: password.php?success');

		}else if(empty($errors) === false){ ?>
				<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'><p> <?php
				echo output_errors($errors);?>
				</p></div><?php
		}

?>

<h1 class='section-title'>Change password</h1>
<div class ='container' id='reg-form'>
	<form class='two-col' id='content'action='' method='POST'>
		<h4>Login Information</h4>
			<div class='info' id='p_info'>
			<div class='log-row'>
				<label>Current password : </label>
				<input type='password' name='current_password' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>New password : </label>
				<input type='password' name='new_password' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>Confirm password : </label>
				<input type='password' name='re_password' tabindex='1' required>
			</div>
			<div class='log-row' id='buttons' style='margin-top: 0px; margin-right: 181px'>
				<input type='submit' value='Change password' class='log-button' tabindex='1'/>
			</div>
		</div>

		<div class='clearer'></div>
	</form>


	<?php include 'includes/aside.php'; ?>
</div>

<?php }
include 'includes/overall/footer.php'; ?>