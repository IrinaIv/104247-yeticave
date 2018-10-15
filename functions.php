<?php

/**
 * Функция-шаблонизатор
 * @param string $name имя шаблона
 * @param array $data данные для шаблона
 * @return string
 */
function includeTemplate($name, $data) {
	$name = 'templates/' . $name;

	if (!is_readable($name)) {
		return '';
	}

	ob_start();
	extract($data);
	require($name);

	return ob_get_clean();
}

/**
 * Функция форматирует цену с разделением групп
 * @param float|integer $price цена
 * @return float|string
 */
function getFormattedPrice($price) {
	$roundedPrice = ceil($price);

	return $roundedPrice >= 1000
		? number_format($roundedPrice, 0, '', ' ')
		: $roundedPrice;
}

/**
 * Функция считает, сколько секунд осталось до полуночи, и преобразует результат к формату ЧЧ:ММ
 * @return false|string
 */
function getFormattedTimeDifference() {
	$tomorrowTime = strtotime('tomorrow');
	$secsToMidnight = $tomorrowTime - time();

	return gmdate('H:i', $secsToMidnight);
}

/**
 * @param $connection
 * @param $sqlRequest
 * @return array|null|string
 */
function getDataFromDatabase($connection, $sqlRequest) {
	$result = mysqli_query($connection, $sqlRequest);

	return $result
		? mysqli_fetch_all($result, MYSQLI_ASSOC)
		: mysqli_error($connection); /* TODO error */
}