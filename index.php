<?php
require_once('./functions.php');
require_once('./data.php');

$pageContent = includeTemplate('index.php', [
	'categoryList'	=> $categoryList,
	'lotList'		=> $lotList,
	'timer'			=> getFormattedTimeDifference("Europe/Moscow"),
]);
$layoutContent = includeTemplate('layout.php', [
	'title'			=> 'Главная',
	'isAuth'		=> $isAuth,
	'userAvatar'	=> $userAvatar,
	'userName'		=> $userName,
	'content'		=> $pageContent,
	'categoryList'	=> $categoryList,
]);

print($layoutContent);