<?php 
	include 'core/init.php';
	include 'includes/overall/header.php'; 

		if  (empty($_POST) === false){
			$required_fields = array('username', 'password', 'r_password', 'lname', 'fname', 'email');
			foreach ($_POST as $key => $value) {
				if (empty($value) && in_array($key, $required_fields) === true) {
					$errors[] = 'Please fill up all remaining required fields.';
					break 1;
				}
			}


			if(empty($errors) === true){
				if(user_exists($_POST['username']) === true){
					$errors[] = 'Sorry, the username \'' . $_POST['username'] . '\' is already taken.';
				}
				if(preg_match("/\\s/", $_POST['username']) === true){
					$errors[] = 'Your username must not contain any space/s.';
				}
				if(strlen($_POST['password']) < 6){
					$errors[] = 'Your password must be atleast 6 characters.';
				}
				if($_POST['password'] !== $_POST['r_password']){
					$errors[] = 'Your passwords do not match.';
				}
				if(email_exists($_POST['email']) === true){
					$errors[] = 'Sorry, the email \'' . $_POST['email'] . '\' is already in use.';
				}
			}

		}else{
			$echo[] = 'No data received.';
		}
?>

<?php
	if (isset($_GET['success']) && empty($_GET['success'])){
		echo "<div class='general-note' style='height:50px; padding-top: 40px;display:block; margin-bottom:9px; margin-top:-9px; margin-bottom: 0px;'>
				<p>You are now a registered user. Please try to &nbsp; <a href='index.php' style='text-decoration: underline; color:orange;'><u>Login</u></a></p>
			   </div>";
	}else{
		if (empty($_POST) === false && empty($errors) === true){
		$register_data = array(
				'user_username' 	=> $_POST['username'],
				'user_pass' 		=> $_POST['password'],
				'user_email' 		=> $_POST['email'],
				'user_lname' 		=> $_POST['lname'],
				'user_fname' 		=> $_POST['fname'],
				'user_mname' 		=> $_POST['mname'],
				'user_gender' 		=> $_POST['gender'],
				'user_mobile' 		=> $_POST['mobile']
			);

		register_user($register_data);

		header('Location: register.php?success');
		exit();

		}else if(empty($errors) === false){ ?>
			<div class='general-note' style='display:block; margin-bottom:9px; margin-top:-9px;'><p> <?php
			echo output_errors($errors);?>
			</p></div><?php
		}

?>


<h1 class='section-title'>Registration</h1>
<div class ='container' id='reg-form'>
	<form class='two-col' id ='content' action='' method='POST'>
		<h3>User Information</h3>
			<div class='info' id='a_info'>
			<div class='log-row'>
				<label>* Username : </label>
				<input type='text' name='username' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>* Password : </label>
				<input type='password' name='password' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>* Confirm password : </label>
				<input type='password' name='r_password' tabindex='1' required>
			</div>
		</div><br>

		<div class='clearer'></div>

		<h3>Personal Information</h3>
			<div class='info' id='p_info'>
			<div class='log-row'>
				<label>* Lastname : </label>
				<input type='text' name='lname' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>* Firstname : </label>
				<input type='text' name='fname' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>Middlename : </label>
				<input type='text' name='mname' tabindex='1'required>
			</div>
			<div class='log-row'>
				<label>* Gender : </label>
				<select name='gender'>
					<option value='Male'>Male</option>
					<option value='Female'>Female</option>
				</select>	
			</div>
		</div><br>

		<div class='clearer'></div>

		<h3>Contact Information</h3>
			<div class='info' id='p_info'>
			<div class='log-row'>
				<label>* Email Address : </label>
				<input type='email' name='email' tabindex='1' required>
			</div>
			<div class='log-row'>
				<label>Mobile : </label>
				<input type='number' name='mobile' tabindex='1' required >
			</div>
			<div class='log-row'>
				<label>Landline : </label>
				<input type='number' name='landline' tabindex='1'>
			</div>
			<div class='log-row' id='buttons'>
				<input type='submit' value='Register' class='log-button'/>
				<input type='reset' value='Cancel' class='log-button'>
			</div>
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