<?php
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

function getFormattedPrice($price) {
	$roundedPrice = ceil($price);

	return $roundedPrice >= 1000
		? number_format($roundedPrice, 0, '', ' ') . ' ₽'
		: $roundedPrice . ' ₽';
}