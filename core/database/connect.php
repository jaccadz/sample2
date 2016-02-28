<?php
	$connect_error = 'Sorry, we\'re experiencing connection problem with the database.';
	mysql_connect('localhost', 'root', '') or die($connect_error);
	mysql_select_db('lri') or die($connect_error);
?>