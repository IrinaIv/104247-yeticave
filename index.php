<?php
require_once('./init.php');

if (!$connection) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> mysqli_connect_error(),
	]);
	print($errorPage);
	exit();
}

$lotsSql = 'SELECT lot_id, name, started_price, image AS img_url, date_closed, categories.title AS category_name FROM lots'
	. ' JOIN categories ON lots.category_id = categories.category_id'
	. ' WHERE date_closed IS NULL OR date_closed > NOW()'
	. ' ORDER BY date_created DESC';
$lotList = getDataFromDatabase($connection, $lotsSql);

if ($lotList === false) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> mysqli_error($connection),
	]);
	print($errorPage);
	exit();
}

if (count($lotList) === 0) {
	$pageContent = includeTemplate('error_page.php', [
		'error'	=> 'Нет лотов',
	]);
} else {
	$pageContent = includeTemplate('index.php', [
		'categoryList'	=> $categoryList,
		'lotList'		=> $lotList,
	]);
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Главная',
	'isAuth'		=> isset($_SESSION['user']),
	'userAvatar'	=> $_SESSION['user']['avatar'] ?? '',
	'userName'		=> $_SESSION['user']['name'] ?? '',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);