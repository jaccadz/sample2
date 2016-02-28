<?php
	session_start();
	//error_reporting(0);

	require 'database/connect.php';
	require 'functions/general.php';
	require 'functions/users.php';
	require 'functions/products.php';
	require 'functions/orders.php';
	
	if (logged_in() === true){
		$session_user_id = $_SESSION['user_id'];
		$user_data = user_data($session_user_id, 'user_id', 'user_lname', 'user_fname', 
					'user_mname', 'user_gender','user_email', 'user_mobile', 'user_landline',
					'user_username', 'user_pass', 'user_dateReg', 'user_type', 
					'user_status' );
	}
	
	$errors = array();
	$note = array();
?>