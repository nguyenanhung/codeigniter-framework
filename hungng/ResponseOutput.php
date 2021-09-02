<?php
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/03/2021
 * Time: 02:17
 */
if (!class_exists('ResponseOutput')) {
	/**
	 * Class ResponseOutput
	 *
	 * @author    713uk13m <dev@nguyenanhung.com>
	 * @copyright 713uk13m <dev@nguyenanhung.com>
	 */
	class ResponseOutput
	{
		/**
		 * Function writeLn
		 *
		 * @param        $message
		 * @param string $newLine
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/02/2021 42:50
		 */
		public static function writeLn($message, $newLine = "\n")
		{
			if (function_exists('json_encode') && (is_array($message) || is_object($message))) {
				$message = json_encode($message);
			}
			echo $message . $newLine;
		}
	}
}
