<?php
require_once('./init.php');

if (!$connection) {
	$error = mysqli_connect_error();
	$pageContent = includeTemplate('error_page.php', [
		'error'	=> $error
	]);
} else {
	$lotsSql = 'SELECT lot_id, name, started_price, image AS img_url, categories.title AS category_name FROM lots'
		. ' JOIN categories ON lots.category_id = categories.category_id'
		. ' WHERE date_closed IS NULL'
		. ' ORDER BY date_created DESC';
	$lotList = getDataFromDatabase($connection, $lotsSql);

	if (!empty($lotList)) {
		$pageContent = includeTemplate('index.php', [
			'categoryList'	=> $categoryList,
			'lotList'		=> $lotList,
		]);
	} else {
		$pageContent = includeTemplate('error_page.php', [
			'error'	=> $lotList
		]);
	}
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Главная',
	'isAuth'		=> rand(0, 1),
	'userAvatar'	=> 'img/user.jpg',
	'userName'		=> 'User',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);