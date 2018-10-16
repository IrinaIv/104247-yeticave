<?php
require_once('./init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$form = $_POST;
	$required = ['email', 'password'];
	$errors = [];

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Это поле надо заполнить';
		}
	}

	if (filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
		$email = mysqli_real_escape_string($connection, $form['email']);
		$sql = "SELECT user_id, name, avatar, password, email FROM users WHERE email = '$email'";
		$result = mysqli_query($connection, $sql);

		$user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;

	} else {
		$errors['email'] = 'Неверный формат email';
	}

	if (!count($errors) && $user) {
		if (password_verify($form['password'], $user['password'])) {
			$_SESSION['user'] = $user;
		} else {
			$errors['password'] = 'Неверный пароль';
		}
	} else {
		$errors['email'] = 'Такой пользователь не найден';
	}

	if (count($errors)) {
		$page_content = includeTemplate('log_in.php', [
			'form'		=> $form,
			'errors'	=> $errors
		]);
	} else {
		header("Location: index.php");
		exit();
	}
} else {
	$pageContent = includeTemplate('log_in.php', []);
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Вход',
	'isAuth'		=> isset($_SESSION['user']),
	'userAvatar'	=> $_SESSION['user']['avatar'] ?? '',
	'userName'		=> $_SESSION['user']['name'] ?? '',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);