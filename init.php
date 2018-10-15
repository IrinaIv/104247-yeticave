<?php
require_once('./configuration.php');
require_once('./functions.php');
if (is_readable('config/database_local.php')) {
	require_once('config/database_local.php');
} else {
	require_once('config/database.php');
}

$connection = mysqli_connect($database['host'], $database['user'], $database['password'], $database['database']);
mysqli_set_charset($connection, 'utf8');

if (!$connection) {
	$error = mysqli_connect_error();
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> $error
	]);
	print($errorPage);
	exit();
} else {
	$categoriesSql = 'SELECT title FROM categories';
	$categoryList = getDataFromDatabase($connection, $categoriesSql);

	if (!$categoryList) {
		$errorPage = includeTemplate('error_page.php', [
			'error'	=> mysqli_error($connection)
		]);
		print($errorPage);
		exit();
	}
}