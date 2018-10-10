<?php
require_once('./configuration.php');
require_once('config/database.php');
require_once('./functions.php');

$connection = mysqli_connect($database['host'], $database['user'], $database['password'], $database['database']);
mysqli_set_charset($connection, 'utf8');

$categoryList = [];
$lotList = [];

if (!$connection) {
	$error = mysqli_connect_error();
	print($error);
} else {
	$categoriesSql = 'SELECT * FROM categories';
	$categoriesResult = mysqli_query($connection, $categoriesSql);

	if ($categoriesResult) {
		$categoryList = mysqli_fetch_all($categoriesResult, MYSQLI_ASSOC);
	} else {
		$error = mysqli_error($connection);
		print($error);
	}

	$lotsSql = 'SELECT bets.lot_id, name, started_price, image, COUNT(bet_id) AS bets_count, MAX(bets.price) AS bets_max_price, title FROM lots'
		. ' JOIN bets ON lots.lot_id = bets.lot_id'
		. ' JOIN categories ON lots.category_id = categories.category_id'
		. ' WHERE date_closed IS NULL'
		. ' GROUP BY bets.lot_id';
	$lotsResult = mysqli_query($connection, $lotsSql);

	if ($lotsResult) {
		$lotList = mysqli_fetch_all($lotsResult, MYSQLI_ASSOC);
	} else {
		$error = mysqli_error($connection);
		print($error);
	}
}