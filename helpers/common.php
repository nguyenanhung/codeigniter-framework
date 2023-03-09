<?php
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/03/2023
 * Time: 23:00
 */
if (!function_exists('bear_str_to_lower')) {
	function bear_str_to_lower($str)
	{
		if (function_exists('mb_strtolower')) {
			return mb_strtolower($str, 'UTF-8');
		}

		return strtolower($str);
	}
}
if (!function_exists('bear_str_to_upper')) {
	function bear_str_to_upper($str)
	{
		if (function_exists('mb_strtoupper')) {
			return mb_strtoupper($str, 'UTF-8');
		}

		return strtoupper($str);
	}
}
if (!function_exists('bear_str_length')) {
	function bear_str_length($str)
	{
		if (function_exists('mb_strlen')) {
			return mb_strlen($str);
		}

		return strlen($str);
	}
}
