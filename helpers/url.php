<?php
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/04/2021
 * Time: 07:04
 */

if (!function_exists('assets_url')) {
	/**
	 * Function assets_url
	 *
	 * @param string $uri
	 * @param null   $protocol
	 * @param string $folder
	 *
	 * @return string
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/04/2021 06:42
	 */
	function assets_url($uri = '', $protocol = null, $folder = 'assets/')
	{
		$fileExt = substr(trim($uri), strrpos(trim($uri), '.') + 1);
		$fileExt = strtoupper($fileExt);
		$version = '';

		if ($fileExt == 'CSS' || $fileExt == 'JS') {
			$version = config_item('assets_version');
		}

		return trim(base_url($folder . $uri, $protocol) . $version);
	}
}
if (!function_exists('templates_url')) {
	/**
	 * Function templates_url
	 *
	 * @param string $uri
	 * @param null   $protocol
	 * @param string $folder
	 *
	 * @return string
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/04/2021 07:23
	 */
	function templates_url($uri = '', $protocol = null, $folder = 'templates/')
	{
		$fileExt = substr(trim($uri), strrpos(trim($uri), '.') + 1);
		$fileExt = strtoupper($fileExt);
		$version = '';

		if ($fileExt == 'CSS' || $fileExt == 'JS') {
			$version = config_item('assets_version');
		}

		return trim(base_url($folder . $uri, $protocol) . $version);
	}
}
