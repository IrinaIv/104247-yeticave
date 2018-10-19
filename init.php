<?php
require_once('./configuration.php');
require_once('./functions.php');
if (is_readable('config/database_local.php')) {
	require_once('config/database_local.php');
} else {
	require_once('config/database.php');
}

session_start();

$connection = mysqli_connect($database['host'], $database['user'], $database['password'], $database['database']);
mysqli_set_charset($connection, 'utf8');

if (!$connection) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> mysqli_connect_error(),
	]);
	print($errorPage);
	exit();
}

$categoriesSql = 'SELECT category_id, title FROM categories';
$categoryList = getDataFromDatabase($connection, $categoriesSql);

if ($categoryList === false) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> mysqli_error($connection),
	]);
	print($errorPage);
	exit();
}