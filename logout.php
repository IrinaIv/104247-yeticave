<?php
require_once('./init.php');

if (isset($_SESSION['user'])) {
	$_SESSION = [];
	header("Location: index.php");
	exit();
}