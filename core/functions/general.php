<?php

	function array_sanitize(&$item){
		$item = mysql_real_escape_string($item);
	}

	function sanitize($data){
		return mysql_real_escape_string($data);
	}

	function output_errors($errors){
		$output = array();

		return implode (' <br>', $errors);
	} 

	function hasError($errors){
		if(empty($errors)){
			$hasError = false;
		}else{
			$hasError = true;
		}
	}
?>