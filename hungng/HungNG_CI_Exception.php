<?php

defined('BASEPATH') or exit('No direct script access allowed');

class HungNG_CI_Exception extends Exception
{
	/**
	 * HungNG_CI_Exception constructor.
	 *
	 * @param $message
	 * @param $code
	 *
	 * @throws \HungNG_CI_Exception
	 *
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 */
	public function __construct($message = null, $code = 0)
	{
		if ( ! $message) {
			throw new $this('Unknown ' . get_class($this));
		}
		$error_message = $message . ' - If you believe this is a codebase or framework bug, please report it and let us know here: ' . CI3_FRAMEWORK_ISSUES . ' - Codebase will be improved by your contributions. Thank you!';
		parent::__construct($error_message, $code);
	}
}
