<?php
require_once('./configuration.php');
require_once('./functions.php');
if (is_readable('config/database.local.php')) {
	require_once('config/database_local.php');
} else {
	require_once('config/database.php');
}

$connection = mysqli_connect($database['host'], $database['user'], $database['password'], $database['database']);
mysqli_set_charset($connection, 'utf8');

if (!$connection) {
	$error = mysqli_connect_error();
	print($error);
} else {
	$categoriesSql = 'SELECT title FROM categories';
	$categoryList = getDataFromDatabase($connection, $categoriesSql);

	$lotsSql = 'SELECT name, started_price, image AS img_url, categories.title AS category_name FROM lots'
		. ' JOIN categories ON lots.category_id = categories.category_id'
		. ' WHERE date_closed IS NULL'
		. ' ORDER BY date_created DESC';
	$lotList = getDataFromDatabase($connection, $lotsSql);
}