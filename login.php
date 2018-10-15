<?php
require_once('./init.php');

session_start();

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
		$sql = "SELECT user_id FROM users WHERE email = '$email'";
		$result = mysqli_query($connection, $sql);

		$user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;

	} else {
		$errors['email'] = 'Неверный формат email';
	}
} else {
	$pageContent = includeTemplate('log_in.php', []);
}

$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Вход',
	'isAuth'		=> false,
	'userAvatar'	=> '',
	'userName'		=> '',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);