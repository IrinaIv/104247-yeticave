<?php
require_once('./init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = $_POST;
	$required = ['email', 'password', 'name', 'message'];
	$errors = [];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Это поле надо заполнить';
		}
	}

	if ($_FILES['user_img']['name']) {
		$tmpName = $_FILES['user_img']['tmp_name'];
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$fileType = finfo_file($finfo, $tmpName);
		if ($fileType === 'image/jpeg' || $fileType === 'image/png') {
			$path = uniqid() . '.' . substr($fileType, 6);
			move_uploaded_file($tmpName, 'img/' . $path);
			$user['img_path'] = 'img/' . $path;
		} else {
			$errors['file'] = 'Загрузите картинку в нужном формате';
		}
	}

	if (filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
		$email = mysqli_real_escape_string($connection, $user['email']);
		$sql = "SELECT user_id FROM users WHERE email = '$email'";
		$result = mysqli_query($connection, $sql);

		if (!$result) {
			$errorPage = includeTemplate('error_page.php', [
				'error'	=> mysqli_error($connection),
			]);
			print($errorPage);
			exit();
		}

		if (mysqli_num_rows($result) > 0) {
			$errors['email'] = 'Пользователь с этим email уже зарегистрирован';
		}

	} else {
		$errors['email'] = 'Неверный формат email';
	}

	if (count($errors)) {
		$pageContent = includeTemplate('sign_up.php', [
			'errors'		=> $errors,
			'user'			=> $user,
		]);
	} else {
		$password = password_hash($user['password'], PASSWORD_DEFAULT);
		$sql = 'INSERT INTO users (date_registered, name, email, password, avatar, contacts)'
			. ' VALUES (NOW(), ?, ?, ?, ?, ?)';
		$stmt = db_get_prepare_stmt($connection, $sql, [
			$user['name'],
			$user['email'],
			$password,
			$user['img_path'] ?? '',
			$user['message']
		]);
		$res = mysqli_stmt_execute($stmt);

		if (!$res) {
			$errorPage = includeTemplate('error_page.php', [
				'error'	=> mysqli_error($connection),
			]);
			print($errorPage);
			exit();
		}

		header('Location: login.php');
		exit();
	}
} else {
	$pageContent = includeTemplate('sign_up.php', []);
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Регистрация',
	'isAuth'		=> isset($_SESSION['user']),
	'userAvatar'	=> $_SESSION['user']['avatar'] ?? '',
	'userName'		=> $_SESSION['user']['name'] ?? '',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);