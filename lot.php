<?php
require_once('./init.php');

if (isset($_GET['id'])) {
	if (!$connection) {
		$error = mysqli_connect_error();
		$errorPage = includeTemplate('error_page.php', [
			'error'	=> $error
		]);
		print($errorPage);
		exit();
	} else {
		$lotsSql = 'SELECT name, description, image AS img_url, started_price, bet_step, categories.title AS category_name FROM lots'
			. ' JOIN categories ON lots.category_id = categories.category_id'
			. ' WHERE lot_id = ' . intval($_GET['id']);
		$lotData = getDataFromDatabase($connection, $lotsSql);

		$betSql = 'SELECT price FROM bets'
		. ' WHERE lot_id = ' . intval($_GET['id'])
		. ' GROUP BY bet_id'
		. ' ORDER BY date_created DESC';
		$betData = getDataFromDatabase($connection, $betSql);

		if (!$lotData) {
			http_response_code(404);
			exit();
		}
	}
}

$pageContent = includeTemplate('lot_page.php', [
	'isAuth'		=> isset($_SESSION['user']),
	'lotData'		=> $lotData[0],
	'currentPrice'	=> $betData[0]['price'] ?? $lotData[0]['started_price'],
	'betAmount'		=> 0,
	'betList'		=> [],
]);

$layoutContent = includeTemplate('layout.php', [
	'title'			=> $lotData[0]['name'],
	'isAuth'		=> isset($_SESSION['user']),
	'userAvatar'	=> $_SESSION['user']['avatar'] ?? '',
	'userName'		=> $_SESSION['user']['name'] ?? '',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);