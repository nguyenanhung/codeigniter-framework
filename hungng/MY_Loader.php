<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 30/07/2022
 * Time: 00:38
 */
if (!class_exists('MY_Loader')) {
	if (!file_exists(APPPATH . 'core/MY_Loader.php')) {
		class MY_Loader extends HungNG_Loader
		{
		}
	}
}
