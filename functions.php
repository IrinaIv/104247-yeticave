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
 * Функция считает, сколько секунд осталось до переданного времени, и преобразует результат к формату ЧЧ:ММ
 * @param string $futureTime Будущее время
 * @return string
 */
function getFormattedTimeDifference($futureTime) {
	$secsToFutureTime = strtotime($futureTime) - time();
	$hours = floor($secsToFutureTime / 3600);
	$minutes = floor(($secsToFutureTime % 3600) / 60);

	return $hours . ':' . $minutes;
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

/**
 * Функция определения единственного/множественного числа
 * @param integer $n Число
 * @param array $forms Массив склонений
 * @return mixed
 */
function pluralForm($n, $forms) {
	$n = abs(intval($n));

	return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
}

/**
 * Функция возвращает, сколько времени прошло от переданной даты до текущего времени
 * @param string $date Дата
 * @return string
 */
function getFormattedPastTime($date) {
	$dateInterval = time() - strtotime($date);

	if ($dateInterval >= 86400) {
		$days = floor($dateInterval / 86400);
		return $days . ' ' . pluralForm($days, ['день', 'дня', 'дней']) . ' назад';
	} elseif ($dateInterval >= 3600) {
		$hours = floor($dateInterval / 3600);
		return $hours . ' ' . pluralForm($hours, ['час', 'часа', 'часов']) . ' назад';
	} elseif ($dateInterval >= 60) {
		$minutes = floor($dateInterval / 60);
		return $minutes . ' ' . pluralForm($minutes, ['минуту', 'минуты', 'минут']) . ' назад';
	} else {
		return $dateInterval . ' ' . pluralForm($dateInterval, ['секунду', 'секунды', 'секунд']) . ' назад';
	}
}