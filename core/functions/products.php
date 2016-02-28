<?php

	function product_data($product_id){
		$data = array();
		$product_id = (int)$product_id;

		$func_num_args = func_num_args();
		$func_get_args = func_get_args();

		if ($func_num_args > 1){
			unset($func_get_args[0]);

			$fields = '`' . implode('`, `', $func_get_args) . '`';
			$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `products` WHERE `prd_id` = $product_id"));

			return $data;
		}
	}

	function get_category($cat_id){
		return mysql_query("SELECT `cat_name` FROM `categories` WHERE `cat_id` = $cat_id");
	}

	function product_exists($product){
		$product = sanitize($product);
		$qry = mysql_query("SELECT COUNT(`prd_name`) FROM `products` WHERE `prd_name` = '$product'");
		return (mysql_result($qry, 0) == 1) ? true : false;
	}

	function archived_product($product){
		$product = sanitize($product);
		$qry = mysql_query("SELECT COUNT(`prd_name`) FROM `products` WHERE `prd_name` = '$product' AND `prd_status` = 'Unavailable'");
		return (mysql_result($qry, 0) == 1) ? true : false;
	}

	function search_product($search){
		$search = sanitize($search);
		$qry = mysql_query("SELECT COUNT(`prd_name`) FROM `products` WHERE `prd_name` = '$product' AND `prd_status` = 'Available'");
		return (mysql_result($qry, 0) == 1) ? true : false;
	}

	function count_product(){
		return mysql_result(mysql_query("SELECT COUNT(`prd_id`) FROM `products`"), 0);
	}

	function count_category(){
		return mysql_result(mysql_query("SELECT COUNT(`cat_id`) FROM `categories`"), 0);
	}

	function del_product($delete_product){	
		$delete_product = mysql_real_escape_string($delete_product);
		mysql_query("UPDATE `products` SET prd_status = 'Unavailable' WHERE prd_name ='" . $delete_product . "'") or die(mysql_error());
	}

	function add_cat($cat_name){
		mysql_query("INSERT INTO `categories` VALUES ". $cat_name . "\"")  or die(mysql_error());
	}

	function update_product($update_data, $id){
		array_walk($update_data, 'array_sanitize');

		foreach ($update_data as $field => $data) {
			$update[] = '`'. $field .'` = \'' . $data . '\'';
		}
		mysql_query("UPDATE `products` SET " . implode(', ', $update) . " WHERE `prd_id` = $id") or die(mysql_error());
	}

	function add_product($register_data){
		array_walk($register_data, 'array_sanitize');

		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
		$data = '\'' . implode('\', \'', $register_data) . '\'';

		mysql_query("INSERT INTO `products` ($fields) VALUES ($data)")  or die(mysql_error());
	}


	//    <input type="button" value="button1" onClick="this.form.action='your_first_action_url'; this.form.submit()">

?>