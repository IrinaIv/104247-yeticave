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
	}

	$lotsSql = 'SELECT name, description, image AS img_url, started_price, bet_step, categories.title AS category_name FROM lots'
		. ' JOIN categories ON lots.category_id = categories.category_id'
		. ' WHERE lot_id = ' . intval($_GET['id']);
	$lotData = getDataFromDatabase($connection, $lotsSql);

	$betSql = 'SELECT price FROM bets'
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

	if (!$lotData) { /* TODO !check or array === 0 */
		http_response_code(404);
		exit();
	}
}

$pageContent = includeTemplate('lot_page.php', [
	'isAuth'		=> isset($_SESSION['user']),
	'lotData'		=> $lotData[0],
	'currentPrice'	=> $betData[0]['price'] ?? $lotData[0]['started_price'],
	'betAmount'		=> 0, /* TODO count */
	'betList'		=> [], /* TODO list */
]);

print(getLayoutContent($lotData[0]['name'], $pageContent, $categoryList));