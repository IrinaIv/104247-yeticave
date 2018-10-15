<?php
require_once('./init.php');

if (isset($_GET['id'])) {
	if (!$connection) {
		$error = mysqli_connect_error();
		print($error);
	} else {
		$lotsSql = 'SELECT name, description, image AS img_url, bet_step, categories.title AS category_name FROM lots'
			. ' JOIN categories ON lots.category_id = categories.category_id'
			. ' WHERE lot_id = ' . $_GET['id'];
		$lotData = getDataFromDatabase($connection, $lotsSql);

		$betSql = 'SELECT price FROM bets'
		. ' WHERE lot_id = ' . $_GET['id']
		. ' GROUP BY bet_id'
		. ' ORDER BY date_created DESC';
		$betData = getDataFromDatabase($connection, $betSql);

		if (empty($lotData) || empty($betData)) {
			http_response_code(404);
			exit();
		}
	}
}

$pageContent = includeTemplate('lot_page.php', [
	'lotData'		=> $lotData[0],
	'currentPrice'	=> (int)$betData[0]['price']
]);

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Главная', /* TODO page */
	'isAuth'		=> rand(0, 1),
	'userAvatar'	=> 'img/user.jpg',
	'userName'		=> 'User',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);