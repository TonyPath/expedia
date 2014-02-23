<?php

if(!function_exists("t")) {

function t($string, array $args = array()) {
	foreach ($args as $key => $value) {
		switch ($key[0]) {
			case '@':
				// Escaped only.
				$args[$key] = check_plain($value);
				break;

			case '%':
			default:
				$args[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
				break;

			case '!':
		}
	}
	return strtr($string, $args);
}
}