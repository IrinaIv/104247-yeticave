<?php
require_once('./init.php');

$pageContent = includeTemplate('index.php', [
	'categoryList'	=> $categoryList,
	'lotList'		=> $lotList,
]);
$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Главная',
	'isAuth'		=> rand(0, 1),
	'userAvatar'	=> 'img/user.jpg',
	'userName'		=> 'User',
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);