<?php
$isAuth = rand(0, 1);
$userName = 'Ирина';
$userAvatar = 'img/user.jpg';
$categoryList = [
	'boards'	=> 'Доски и лыжи',
	'mounting'	=> 'Крепления',
	'shoes'		=> 'Ботинки',
	'clothes'	=> 'Одежда',
	'tools'		=> 'Инструменты',
	'other'		=> 'Разное',
];
$lotList = [
	[
		'title'		=> '2014 Rossignol District Snowboard',
		'category'	=> $categoryList['boards'],
		'price'		=> 10999,
		'url'		=> 'img/lot-1.jpg',
	],
	[
		'title'		=> 'DC Ply Mens 2016/2017 Snowboard',
		'category'	=> $categoryList['boards'],
		'price'		=> 159999,
		'url'		=> 'img/lot-2.jpg',
	],
	[
		'title'		=> 'Крепления Union Contact Pro 2015 года размер L/XL',
		'category'	=> $categoryList['mounting'],
		'price'		=> 8000,
		'url'		=> 'img/lot-3.jpg',
	],
	[
		'title'		=> 'Ботинки для сноуборда DC Mutiny Charocal',
		'category'	=> $categoryList['shoes'],
		'price'		=> 10999,
		'url'		=> 'img/lot-4.jpg',
	],
	[
		'title'		=> 'Куртка для сноуборда DC Mutiny Charocal',
		'category'	=> $categoryList['clothes'],
		'price'		=> 7500,
		'url'		=> 'img/lot-5.jpg',
	],
	[
		'title'		=> 'Маска Oakley Canopy',
		'category'	=> $categoryList['other'],
		'price'		=> 5400,
		'url'		=> 'img/lot-6.jpg',
	],
];