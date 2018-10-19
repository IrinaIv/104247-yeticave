<?php
require_once('./init.php');

if (!isset($_GET['id'])) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> 'Страницы не существует',
	]);
	print($errorPage);
	exit();
}

if (!$connection) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> mysqli_connect_error(),
	]);
	print($errorPage);
	exit();
}

$lotsSql = 'SELECT lot_id, author_id, name, description, image AS img_url,'
	. ' started_price, bet_step, date_closed, categories.title AS category_name FROM lots'
	. ' JOIN categories ON lots.category_id = categories.category_id'
	. ' WHERE lot_id = ' . intval($_GET['id']);
$lotData = getDataFromDatabase($connection, $lotsSql);

$betSql = 'SELECT user_id, price, date_created FROM bets'
	. ' WHERE lot_id = ' . intval($_GET['id'])
	. ' GROUP BY bet_id'
	. ' ORDER BY date_created DESC';
$betData = getDataFromDatabase($connection, $betSql);

if ($lotData === false || $betData === false) {
	$errorPage = includeTemplate('error_page.php', [
		'error'	=> mysqli_error($connection),
	]);
	print($errorPage);
	exit();
}

if (!$lotData) {
	http_response_code(404);
	exit();
}

$minBetPrice = ($betData[0]['price'] ?? $lotData[0]['started_price']) + $lotData[0]['bet_step'];
$isBetAddShown = isset($_SESSION['user'])
	&& strtotime($lotData[0]['date_closed']) > time()
	&& $_SESSION['user']['user_id'] !== $lotData[0]['author_id'];

/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['cost'])) {
		if (intval($_POST['cost']) >= $minBetPrice) {
			$sql = 'INSERT INTO bets (date_created, user_id, lot_id, price)'
				. ' VALUES (NOW(), ?, ?, ?)';
			$stmt = db_get_prepare_stmt($connection, $sql, [
				$_SESSION['user']['user_id'],
				$lotData[0]['lot_id'],
				$_POST['cost'],
			]);
			$result = mysqli_stmt_execute($stmt);

			if (!$result) {
				$errorPage = includeTemplate('error_page.php', [
					'error'	=> mysqli_error($connection),
				]);
				print($errorPage);
				exit();
			}
		}
	}
}*/ /* TODO */

$pageContent = includeTemplate('lot_page.php', [
	'isAuth'		=> isset($_SESSION['user']),
	'isBetAddShown'	=> $isBetAddShown,
	'lotData'		=> $lotData[0],
	'currentPrice'	=> $betData[0]['price'] ?? $lotData[0]['started_price'],
	'minBet'		=> $minBetPrice,
	'betAmount'		=> count($betData),
	'betList'		=> $betData,
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