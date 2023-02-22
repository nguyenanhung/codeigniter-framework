<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 22/02/2023
 * Time: 23:06
 */
if (!class_exists('HungNG_CI_Base_Controller_Default_Page')) {
	/**
	 * Class HungNG_CI_Base_Controller_Default_Page
	 *
	 * @author    713uk13m <dev@nguyenanhung.com>
	 * @copyright 713uk13m <dev@nguyenanhung.com>
	 */
	class HungNG_CI_Base_Controller_Default_Page extends HungNG_CI_Base_Controllers
	{
		public $template = 'Custom/';

		/**
		 * HungNG_CI_Base_Controller_Default_Page constructor.
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 */
		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('url', 'html'));
			$this->load->library('parser');
		}

		/**
		 * Function index
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/02/2023 08:10
		 */
		public function index()
		{
			$this->load->view('welcome');
		}

		/**
		 * Function maintenance
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/02/2023 08:07
		 */
		public function maintenance()
		{
			$this->load->view($this->template . 'Maintenance');
		}

		/**
		 * Function under_construction
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/02/2023 08:05
		 */
		public function under_construction()
		{
			$data = array(
				'title'         => 'Coming Soon',
				'heading'       => 'I\'ll be back',
				'site_name'     => config_item('cms_site_name'),
				'site_author'   => POWERED_HUNGNG_NAME . ' - ' . POWERED_HUNGNG_EMAIL,
				'url_assets'    => assets_themes('Clouds'),
				'url_facebook'  => site_url(),
				'url_twitter'   => site_url(),
				'url_briefcase' => site_url(),
				'url_transit'   => site_url()
			);
			$this->parser->parse($this->template . 'Clouds_under_construction', $data);
		}

		/**
		 * Function error404
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/02/2023 08:01
		 */
		public function error404()
		{
			$data = array(
				'name'          => '404',
				'title'         => 'PAGE NOT FOUND',
				'heading'       => 'The page you requested was not found.',
				'site_name'     => config_item('cms_site_name'),
				'site_author'   => POWERED_HUNGNG_NAME . ' - ' . POWERED_HUNGNG_EMAIL,
				'site_link'     => config_item('base_url'),
				'url_assets'    => assets_themes('Sailors'),
				'url_facebook'  => site_url(),
				'url_twitter'   => site_url(),
				'url_briefcase' => site_url(),
				'url_transit'   => site_url()
			);
			$this->parser->parse($this->template . 'Sailor_error', $data);
		}
	}
}
