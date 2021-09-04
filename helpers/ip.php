<?php
/**
 * Project codeigniter-basic-helper
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/07/2021
 * Time: 01:09
 */
if (!function_exists('getIPAddress')) {
	/**
	 * Function getIPAddress
	 *
	 * @param bool $convertToInteger
	 *
	 * @return false|int|string
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 10/09/2020 59:22
	 */
	function getIPAddress($convertToInteger = false)
	{
		$ip_keys = array(
			0 => 'HTTP_X_FORWARDED_FOR',
			1 => 'HTTP_X_FORWARDED',
			2 => 'HTTP_X_IPADDRESS',
			3 => 'HTTP_X_CLUSTER_CLIENT_IP',
			4 => 'HTTP_FORWARDED_FOR',
			5 => 'HTTP_FORWARDED',
			6 => 'HTTP_CLIENT_IP',
			7 => 'HTTP_IP',
			8 => 'REMOTE_ADDR'
		);
		foreach ($ip_keys as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);
					if ($convertToInteger === true) {
						return ip2long($ip);
					}

					return $ip;
				}
			}
		}

		return false;
	}
}
if (!function_exists('validateIP')) {
	/**
	 * Function validateIP
	 *
	 * @param $ip
	 *
	 * @return bool
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 10/09/2020 59:32
	 */
	function validateIP($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
			return false;
		}

		return true;
	}
}
if (!function_exists('validateIPV4')) {
	/**
	 * Function validateIPV4
	 *
	 * @param $ip
	 *
	 * @return bool
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 10/09/2020 59:36
	 */
	function validateIPV4($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
			return false;
		}

		return true;
	}
}
if (!function_exists('validateIPV6')) {
	/**
	 * Function validateIPV6
	 *
	 * @param $ip
	 *
	 * @return bool
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 10/09/2020 59:40
	 */
	function validateIPV6($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {

			return false;
		}

		return true;
	}
}
