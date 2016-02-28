<?php 

	include 'core/init.php';
	include 'includes/overall/header.php';

	if  (empty($_POST) === false){
			$required_fields = array('lname', 'fname', 'email', 'mobile');
			foreach ($_POST as $key => $value) {
				if (empty($value) && in_array($key, $required_fields) === true) {
					$errors[] = 'Please fill up all remaining required fields.';
					break 1;
				}
			}

			if(empty($errors) === true){
				if(email_exists($_POST['email']) === true && $user_data['user_email'] !== $_POST['email']){
					$errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use.';
				}
			}

		}else{
			$echo[] = 'No data received.';
	}
?>

<?php

	if (isset($_GET['success']) === true && empty($_GET['success']) === true){
		echo "<div class='general-note' style='height:50px; padding-top: 40px;display:block; margin-bottom:9px; margin-top:-9px; margin-bottom: 0px;'>
				<p>Updates on your account/personal information, successfully  changed. &nbsp; Go to <a href='index.php' style='text-decoration: underline; color:orange;'><u>Home</u></a> or 
			    <a href='profile.php' style='text-decoration: underline; color:orange;'><u>Profile</u></a></div>";
	}else{
		if (empty($_POST) === false && empty($errors) === true){
		$update_data = array(
				'user_email' 		=> $_POST['email'],
				'user_lname' 		=> $_POST['lname'],
				'user_fname' 		=> $_POST['fname'],
				'user_mname' 		=> $_POST['mname'],
				'user_gender' 		=> $_POST['gender'],
				'user_mobile' 		=> $_POST['mobile']
			);

		update_user($update_data);

		header('Location: settings.php?success');
		exit(); 

		}else if(empty($errors) === false){ ?>
			<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'><p> <?php
			echo output_errors($errors);?>
			</p></div><?php
		}
	
?>

<h1 class='section-title'>Account settings</h1>
<div class ='container' id='reg-form'>
	<form class='two-col' id = 'content' action='' method='POST'>
		<h4>Current Personal Information</h4>
			<div class='info' id='p_info'>
			<div class='log-row'>
				<label>* Lastname : </label>
				<input type='text' name='lname' tabindex='1' required value='<?php echo $user_data['user_lname']?>'>
			</div>
			<div class='log-row'>
				<label>* Firstname : </label>
				<input type='text' name='fname' tabindex='1' required value='<?php echo $user_data['user_fname']?>'>
			</div>
			<div class='log-row'>
				<label>Middlename : </label>
				<input type='text' name='mname' tabindex='1'required value='<?php echo $user_data['user_mname']?>'>
			</div>
			<div class='log-row'>
				<label>* Gender : </label>
				<select name='gender' value="Female">  
					<?php
						if($user_data['user_gender'] === 'Male'){
							echo '<option value=\'Male\' selected>Male</option>';
							echo '<option value=\'Female\'>Female</option>';
						}else{
							echo '<option value=\'Male\'>Male</option>';
							echo '<option value=\'Female\' selected>Female</option>';
						}
 					?>
				</select>	
			</div>
		</div><br>

		<div class='clearer'></div>
		<?php if ($user_data['user_type'] === 'Customer'){ ?> 
			<div style='display: block'>
		<?php } else {?>
			<div style='display: none'>
		<?php }?>		
		<h4>Current Contact Information</h4>
			<div class='info' id='p_info'>
				<div class='log-row'>
					<label>* Email Address : </label>
					<input type='email' name='email' tabindex='1' required value='<?php echo $user_data['user_email']?>'>
				</div>
				<div class='log-row'>
					<label>Mobile : </label>
					<input type='number' name='mobile' tabindex='1' required value='<?php echo $user_data['user_mobile']?>'>
				</div>
				<div class='log-row'>
					<label>Landline : </label>
					<input type='number' name='landline' tabindex='1' required value='<?php echo $user_data['user_landline']?>'>
				</div>
			</div>
		</div>
		<div class='clearer'></div>
		<div class='log-row' id='buttons' style='width: 418px;'>
			<input type='submit' value='Save changes' class='log-button'/>
			<input type='reset' value='Cancel' class='log-button'>
		</div>
		<div class='clearer'></div>
	</form>

	<?php include 'includes/aside.php'; ?>
</div>

<?php }

if (isset($_GET['success']) && empty($_GET['success'])){
		include 'includes/widgets/a-links.php';
	}
include 'includes/overall/footer.php'; ?>