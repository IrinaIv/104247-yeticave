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
function getFormattedTimeDifference() {
	$tomorrowTime = strtotime('tomorrow');
	$secsToMidnight = $tomorrowTime - time();

	return date('H:i', $secsToMidnight);
}