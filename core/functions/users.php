<?php
	function protected_page(){
		if (logged_in() === false){
			header('Location: protected.php');
		}
	}

	function change_password($user_id, $password){
		$user_id = (int)$user_id;

		mysql_query("UPDATE `users` SET `user_pass` = '" . $password . "' WHERE `user_id` = $user_id");
	}

	function update_user($update_data){
		global $session_user_id;
		array_walk($update_data, 'array_sanitize');

		foreach ($update_data as $field => $data) {
			$update[] = '`'. $field .'` = \'' . $data . '\'';
		}
		mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $session_user_id") or die(mysql_error());
		//return true;
	}

	function register_user($register_data){
		array_walk($register_data, 'array_sanitize');

		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
		$data = '\'' . implode('\', \'', $register_data) . '\'';

		mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	}

	function user_count(){
		return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_status` = 1"), 0);
	}

	function user_data($user_id){
		$data = array();
		$user_id = (int)$user_id;

		$func_num_args = func_num_args();
		$func_get_args = func_get_args();

		if ($func_num_args > 1){
			unset($func_get_args[0]);

			$fields = '`' . implode('`, `', $func_get_args) . '`';
			$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));

			return $data;
		}
	}

	function logged_in(){
		return (isset($_SESSION['user_id'])) ? true : false; 
	}

	function user_exists($username){
		$username = sanitize($username);
		$qry = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_username` = '$username'");
		return (mysql_result($qry, 0) == 1) ? true : false;
	}

	function email_exists($email){
		$email = sanitize($email);
		$qry = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_email` = '$email'");
		return (mysql_result($qry, 0) == 1) ? true : false;
	}

	function user_active($username){
		$username = sanitize($username);
		$qry = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_username` = '$username' AND `user_status` = 1");
		return (mysql_result($qry, 0) == 1) ? true : false;
	}
	
	function user_id_from_username($username){
		$username = sanitize($username);
		return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `user_username` = '$username'"), 0, 'user_id');
	}

	function login($username, $password){
		$user_id = user_id_from_username($username);
		
		$username = sanitize($username);

		return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_username` = '$username' AND `user_pass` ='$password'"), 0) == 1) ? $user_id : false;
	}
?>