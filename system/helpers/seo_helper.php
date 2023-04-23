<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('bear_simple_seo_header')) {
	/**
	 * Function bear_simple_seo_header
	 *
	 * @param $title
	 * @param $description
	 * @param $image
	 *
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 23/04/2023 23:49
	 */
	function bear_simple_seo_header($title = '', $description = '', $image = '')
	{
		$CI =& get_instance();
		$cms = $CI->load->library('seo_onpage');
		/** @var \CI_Seo_onpage $seo */
		$seo = $cms->seo_onpage;
		$seo->published($title, $description, $image);
	}
}
