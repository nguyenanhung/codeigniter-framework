<?php
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/03/2023
 * Time: 23:55
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * HTML Breadcrumb Generating Class
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 *
 * ------------ Example Construction
 * Load library breadcrumb
 * $this->load->library('breadcrumb');
 *
 * Custom style
 * $template = [
 *     'tag_open' => '<ol class="breadcrumb">',
 *     'crumb_open' => '<li class="breadcrumb-item">',
 *     'crumb_active' => '<li class="breadcrumb-item active" aria-current="page">'
 * ];
 * $this->breadcrumb->set_template($template);
 *
 * Add items
 * $this->breadcrumb->add_item($breadcrumb_items);
 *
 * Generate breadcrumb
 * $data['breadcrumb_bootstrap_style'] = $this->breadcrumb->generate();
 */
class CI_Breadcrumb
{
	protected $CI;

	private $breadcrumb = array();

	/**
	 * breadcrumb layout template
	 *
	 * @var array
	 */
	public $template = null;

	/**
	 * Newline setting
	 *
	 * @var string
	 */
	public $newline = "\n";

	/**
	 * Set the template from the breadcrumb config file if it exists
	 *
	 * @param array $config (default: array())
	 *
	 * @return    void
	 */
	public function __construct($config = array())
	{
		$this->CI =& get_instance();

		$this->CI->load->helper('url');

		// initialize config
		foreach ($config as $key => $val) {
			$this->template[$key] = $val;
		}

		log_message('info', 'Breadcrumb Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Set the template
	 *
	 * @param array $template
	 *
	 * @return    bool
	 */
	public function set_template($template)
	{
		if (!is_array($template)) {
			return false;
		} else {
			$this->template = $template;

			return true;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Function add_item
	 *
	 * @param $args
	 *
	 * @return false|void
	 * @author   : 713uk13m <dev@nguyenanhung.com>
	 * @copyright: 713uk13m <dev@nguyenanhung.com>
	 * @time     : 09/03/2023 57:18
	 */
	public function add_item($args)
	{
		if (!is_array($args) or empty($args)) {
			return false;
		} else {
			foreach ($args as $key => $value) {
				$href = site_url($value);

				$this->breadcrumb[$href] = array(
					'page' => $key,
					'href' => $href
				);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the breadcrumb
	 *
	 * @param mixed $breadcrumb_data
	 *
	 * @return    string|void
	 */
	public function generate()
	{
		if ($this->breadcrumb) {
			// Compile and validate the template date
			$this->_compile_template();

			// Build the breadcrumb
			$out = $this->template['tag_open'] . $this->newline;

			foreach ($this->breadcrumb as $key => $value) {
				$keys = array_keys($this->breadcrumb);

				if (end($keys) == $key) {
					$out .= $this->template['crumb_active'] . $value['page'] . $this->template['crumb_close'] . $this->newline;
				} else {
					$out .= $this->template['crumb_open'];
					$out .= anchor($value['href'], $value['page']);
					$out .= $this->template['crumb_close'];
					$out .= $this->newline;
				}
			}

			$out .= $this->template['tag_close'] . $this->newline;

			// Clear Breadcrumb class properties before generating the breadcrumb
			$this->clear();

			return $out;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Clears the breadcrumb arrays. Useful if multiple tables are being generated
	 *
	 * @return    self
	 */
	public function clear()
	{
		$this->breadcrumb = array();

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Compile Template
	 *
	 * @return    void
	 */
	protected function _compile_template()
	{
		if ($this->template === null) {
			$this->template = $this->_default_template();

			return;
		}

		$this->temp = $this->_default_template();

		foreach (array('tag_open', 'tag_close', 'crumb_open', 'crumb_close', 'crumb_active') as $val) {
			if (!isset($this->template[$val])) {
				$this->template[$val] = $this->temp[$val];
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Default Template
	 *
	 * @return    array
	 */
	protected function _default_template()
	{
		return array(
			'tag_open'     => '<ol>',
			'tag_close'    => '</ol>',
			'crumb_open'   => '<li>',
			'crumb_close'  => '</li>',
			'crumb_active' => '<li class="active">'
		);
	}
}
