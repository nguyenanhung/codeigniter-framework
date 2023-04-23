<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('bear_basic_header_seo')) {
	/**
	 * Function bear_basic_header_seo
	 *
	 * @param $title
	 * @param $description
	 * @param $image
	 *
	 * @return mixed
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 23/04/2023 20:20
	 */
	function bear_basic_header_seo($title = '', $description = '', $image = '')
	{
		$CI =& get_instance();
		$cms = $CI->load->library('seo_onpage');

		return $cms->seo_onpage->published($title, $description, $image);
	}
}
