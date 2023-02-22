<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 18/01/2023
 * Time: 00:23
 */
if (!function_exists('codeigniter_hmvc_module_exists')) {
	/**
	 * Check if a CodeIgniter module with the given name exists
	 *
	 * @param $module_name
	 *
	 * @return bool
	 */
	function codeigniter_hmvc_module_exists($module_name)
	{
		return in_array($module_name, codeigniter_hmvc_modules_list(false));
	}
}

if (!function_exists('codeigniter_hmvc_modules_list')) {
	/**
	 * Return the CodeIgniter modules list
	 *
	 * @param bool $with_location
	 *
	 * @return array
	 */
	function codeigniter_hmvc_modules_list($with_location = true)
	{
		!function_exists('directory_map') && get_instance()->load->helper('directory');

		$modules = array();

		foreach (Modules::$locations as $location => $offset) {

			$files = directory_map($location, 1);
			if (is_array($files)) {
				foreach ($files as $name) {
					if (is_dir($location . $name)) {
						$modules[] = $with_location ? array($location, $name) : $name;
					}
				}
			}
		}

		return $modules;
	}
}
