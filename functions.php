<?php

/**
 * @param $name
 * @param $data
 * @return string
 */
function includeTemplate($name, $data) {
	$name = 'templates/' . $name;
	$result = '';

	if (!file_exists($name)) {
		return $result;
	}

	ob_start();
	extract($data);
	require($name);

	$result = ob_get_clean();

	return $result;
}

/**
 * @param $price
 * @return float|string
 */
function getFormattedPrice($price) {
	$roundedPrice = ceil($price);

	return $roundedPrice >= 1000
		? number_format($roundedPrice, 0, '', ' ')
		: $roundedPrice;
}

/**
 * @return string
 */
function getFormattedTimeDifference($timezone) {
	// Где ее задавать? в index.php или внутри функции параметром?
	date_default_timezone_set($timezone);

	$tomorrowTime = strtotime('tomorrow');
	$secsToMidnight = $tomorrowTime - time();

	/*
	 * return date('H:i', $secsToMidnight);
	 * Возвращает время по гринвичу, игнорируя указанный timezone
	 * Если в date() не передавать timestamp, то указанная timezone учитывается
	 * При gmdate() все в точности наоборот
	 * Почему так?
	 */
	return gmdate('H:i', $secsToMidnight);
}