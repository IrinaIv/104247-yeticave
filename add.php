<?php
require_once('./init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$lot = $_POST;
	$required = ['lot_name', 'category', 'message', 'lot_rate', 'lot_step', 'lot_date'];
	$errors = [];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Это поле надо заполнить';
		}
	}

	if(!$lot['lot_rate'] > 0) {
		$errors['lot_rate'] = 'Цена должна быть больше 0';
	}

	if ($_FILES['lot_img']['name']) {
		$tmpName = $_FILES['lot_img']['tmp_name'];
		$path = $_FILES['lot_img']['name'];
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$fileType = finfo_file($finfo, $tmpName);
		if ($fileType === 'image/jpeg' || $fileType === 'image/png') {
			move_uploaded_file($tmpName, 'img/' . $path);
			$lot['img_path'] = $path;
		} else {
			$errors['file'] = 'Загрузите картинку в нужном формате';
		}
	} else {
		$errors['file'] = 'Вы не загрузили файл';
	}

	if (count($errors)) {
		$pageContent = includeTemplate('add_lot.php', [
			'categoryList'	=> $categoryList,
			'formError'		=> 'form--invalid',
			'errors'		=> $errors,
			'lot'			=> $lot,
		]);
	} else {
		$sql = 'INSERT INTO lots(date_created, author_id, category_id, name, description, image, started_price, date_closed, bet_step)'
			. ' VALUES (NOW(), 1, ?, ?, ?, ?, ?, ?, ?)';

		$stmt = db_get_prepare_stmt($connection, $sql, [
			$lot['category'],
			$lot['lot_name'],
			$lot['message'],
			$lot['img_path'],
			intval($lot['lot_rate']),
			$lot['lot_date'],
			intval($lot['lot_step']),
		]);
		$result = mysqli_stmt_execute($stmt);

		if ($result) {
			$lot_id = mysqli_insert_id($connection);

			header("Location: lot.php?id=" . $lot_id);
		} else {
			$errorPage = includeTemplate('error_page.php', [
				'error'	=> mysqli_error($connection)
			]);
			print($errorPage);
			exit();
		}
	}
} else {
	$pageContent = includeTemplate('add_lot.php', [
		'categoryList'	=> $categoryList,
		'formError'		=> '',
		'errors'		=> [],
		'lot'			=> [],
	]);
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Добавление лота',
	'isAuth'		=> rand(0, 1),
	'userAvatar'	=> 'img/user.jpg',
	'userName'		=> 'User',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);