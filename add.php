<?php
require_once('./init.php');

if (!isset($_SESSION['user'])) {
	http_response_code(403);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$lot = $_POST;
	$required = ['lot_name', 'category', 'message', 'lot_rate', 'lot_step', 'lot_date'];
	$errors = [];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Это поле надо заполнить';
		}
	}

	if(!intval($lot['lot_rate']) > 0) {
		$errors['lot_rate'] = 'Укажите цену';
	}
	if(!intval($lot['lot_step']) > 0) {
		$errors['lot_step'] = 'Укажите шаг ставки';
	}
	if (strtotime(strip_tags($lot['lot_date'])) < time() + 1) {
		$errors['lot_date'] = 'Укажите будущую дату';
	}

	if ($_FILES['lot_img']['name']) {
		$tmpName = $_FILES['lot_img']['tmp_name'];
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$fileType = finfo_file($finfo, $tmpName);
		if ($fileType === 'image/jpeg' || $fileType === 'image/png') {
			$path = uniqid() . '.' . substr($fileType, 6);
			move_uploaded_file($tmpName, 'img/' . $path);
			$lot['img_path'] = 'img/' . $path;
		} else {
			$errors['file'] = 'Загрузите картинку в нужном формате';
		}
	} else {
		$errors['file'] = 'Вы не загрузили файл';
	}

	if (count($errors)) {
		$pageContent = includeTemplate('add_lot.php', [
			'categoryList'	=> $categoryList,
			'errors'		=> $errors,
			'lot'			=> $lot,
		]);
	} else {
		$sql = 'INSERT INTO lots(date_created, author_id, category_id, name, description, image, started_price, date_closed, bet_step)'
			. ' VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

		$stmt = db_get_prepare_stmt($connection, $sql, [
			$_SESSION['user']['user_id'],
			$lot['category'],
			$lot['lot_name'],
			$lot['message'],
			$lot['img_path'],
			intval($lot['lot_rate']),
			$lot['lot_date'],
			intval($lot['lot_step']),
		]);
		$result = mysqli_stmt_execute($stmt);

		if (!$result) {
			$errorPage = includeTemplate('error_page.php', [
				'error'	=> mysqli_error($connection),
			]);
			print($errorPage);
			exit();
		}

		$lot_id = mysqli_insert_id($connection);
		header('Location: lot.php?id=' . $lot_id);
		exit();
	}
} else {
	$pageContent = includeTemplate('add_lot.php', [
		'categoryList'	=> $categoryList,
		'errors'		=> [],
		'lot'			=> [],
	]);
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Добавление лота',
	'isAuth'		=> isset($_SESSION['user']),
	'userAvatar'	=> $_SESSION['user']['avatar'] ?? '',
	'userName'		=> $_SESSION['user']['name'] ?? '',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);