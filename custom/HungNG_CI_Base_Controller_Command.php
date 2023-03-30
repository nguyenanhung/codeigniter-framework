<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 20/03/2023
 * Time: 10:50
 */
if (!class_exists('HungNG_CI_Base_Controller_Command')) {
	class HungNG_CI_Base_Controller_Command extends HungNG_CI_Base_Controllers
	{
		public function __construct()
		{
			parent::__construct();

			log_message('info', 'HungNG_CI_Base_Controller_Command Class Initialized');
		}

		/**
		 * Function flush_opcache
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 20/03/2023 56:22
		 */
		public function flush_opcache()
		{
			$this->opcache_flush_reset();
		}

		/**
		 * Function clean_file_cache
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 20/03/2023 56:34
		 */
		public function clean_file_cache()
		{
			$this->command_clean_cache_file();
		}

		/**
		 * Function clean_apc_cache
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 20/03/2023 56:38
		 */
		public function clean_apc_cache()
		{
			$this->command_clean_cache_apc();
		}
	}
}
