<?php

/**
 * Функция-шаблонизатор
 * @param string $name Имя шаблона
 * @param array $data Данные для шаблона
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
 * @param float|integer $price Цена
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
 * Функция для получения данных из БД
 * @param mysqli $connection Ресурс соединения
 * @param string $sqlRequest SQL-запрос
 * @return array|bool|null
 */
function getDataFromDatabase($connection, $sqlRequest) {
	$result = mysqli_query($connection, $sqlRequest);

	return $result
		? mysqli_fetch_all($result, MYSQLI_ASSOC)
		: false;
}

/**
 * Функция создает подготовленное выражение на основе готового SQL-запроса и переданных данных
 * @param mysqli $connection Ресурс соединения
 * @param string $sqlRequest SQL-запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 * @return bool|mysqli_stmt
 */
function db_get_prepare_stmt($connection, $sqlRequest, $data = []) {
	$stmt = mysqli_prepare($connection, $sqlRequest);

	if ($data) {
		$types = '';
		$stmt_data = [];

		foreach ($data as $value) {
			$type = null;

			if (is_int($value)) {
				$type = 'i';
			}
			else if (is_string($value)) {
				$type = 's';
			}
			else if (is_double($value)) {
				$type = 'd';
			}

			if ($type) {
				$types .= $type;
				$stmt_data[] = $value;
			}
		}

		$values = array_merge([$stmt, $types], $stmt_data);

		$func = 'mysqli_stmt_bind_param';
		$func(...$values);
	}

	return $stmt;
}