<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!class_exists('HungNG_Router')) {
	/* load the MX_Router class */
	require_once __DIR__ . '/../thirdParty/MX/Router.php';

	/**
	 * Class HungNG_Router
	 *
	 * @author    713uk13m <dev@nguyenanhung.com>
	 * @copyright 713uk13m <dev@nguyenanhung.com>
	 */
	class HungNG_Router extends MX_Router
	{
	}
}
