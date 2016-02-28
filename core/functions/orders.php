<?php

	function save_address($register_data){
		array_walk($register_data, 'array_sanitize');

		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
		$data = '\'' . implode('\', \'', $register_data) . '\'';

		mysql_query("INSERT INTO `address` ($fields) VALUES ($data)");
	}

	function save_items_order($register_data){
		array_walk($register_data, 'array_sanitize');

		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
		$data = '\'' . implode('\', \'', $register_data) . '\'';

		mysql_query("INSERT INTO `order_details` ($fields) VALUES ($data)")  or die(mysql_error());
	}

	function place_order($register_data){
		array_walk($register_data, 'array_sanitize');

		$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
		$data = '\'' . implode('\', \'', $register_data) . '\'';

		mysql_query("INSERT INTO `orders` ($fields) VALUES ($data)") or die(mysql_error());
	}

	function getOrderID(){
		return mysql_result(mysql_query("SELECT COUNT(`ord_id`) FROM `orders`"), 0) + 1;
	}
?>