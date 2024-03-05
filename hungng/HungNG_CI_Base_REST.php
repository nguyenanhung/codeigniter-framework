<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 23/06/2022
 * Time: 01:17
 */

use nguyenanhung\CodeIgniter\BaseREST\Request;
use nguyenanhung\CodeIgniter\BaseREST\Response;

if (!class_exists('HungNG_CI_Base_REST')) {
	/**
	 * RESTful API Controller
	 *
	 * @author  Nick Tsai <myintaer@gmail.com>
	 * @version 1.6.1
	 * @link    https://github.com/yidas/codeigniter-rest/
	 * @see     https://github.com/yidas/codeigniter-rest/blob/master/examples/RestController.php
	 * @see     https://en.wikipedia.org/wiki/Representational_state_transfer#Relationship_between_URL_and_HTTP_methods
	 *
	 * Controller extending:
	 * ```php
	 * class My_controller extends yidas\rest\Controller {}
	 * ```
	 *
	 * Route setting:
	 * ```php
	 * $route['resource_name'] = '[Controller]/route';
	 * $route['resource_name/(:num)'] = '[Controller]/route/$1';
	 * ```
	 */
	class HungNG_CI_Base_REST extends HungNG_CI_Base_Controllers
	{
		/**
		 * RESTful API resource routes
		 *
		 * public function index() {}
		 * protected function store($requestData=null) {}
		 * protected function show($resourceID) {}
		 * protected function update($resourceID, $requestData=null) {}
		 * protected function delete($resourceID=null) {}
		 *
		 * @var array RESTful API table of routes & actions
		 */
		protected $routes = array(
			'index' => 'index',
			'store' => 'store',
			'show' => 'show',
			'update' => 'update',
			'delete' => 'delete',
		);

		/**
		 * Behaviors of actions
		 *
		 * @var array
		 */
		private $behaviors = array(
			'index' => null,
			'store' => null,
			'show' => null,
			'update' => null,
			'delete' => null,
		);

		/**
		 * Pre-setting format
		 *
		 * @var string nguyenanhung\CodeIgniter\BaseREST\Response format
		 */
		protected $format;

		/**
		 * Body Format usage switch
		 *
		 * @var bool Default $bodyFormat for json()
		 */
		protected $bodyFormat = false;

		/** @var \nguyenanhung\CodeIgniter\BaseREST\Request */
		protected $request;

		/** @var \nguyenanhung\CodeIgniter\BaseREST\Response */
		protected $response;

		public function __construct()
		{
			parent::__construct();

			log_message('info', 'HungNG_CI_Base_REST Class Initialized');

			// Request initialization
			$this->request = new Request;
			// Response initialization
			$this->response = new Response;

			// Response setting
			if ($this->format) {
				$this->response->setFormat($this->format);
			}
		}

		/**
		 * Route bootstrap
		 *
		 * For Codeigniter route setting to implement RESTful API
		 *
		 * Without routes setting, `resource/{route-alias}` URI pattern is a limitation which CI3 would
		 * first map `controller/action` URI into action() instead of index($action)
		 *
		 * @param int|string $resourceID Resource ID
		 */
		public function route($resourceID = null)
		{
			switch ($this->request->getMethod()) {
				case 'POST':
					if (!$resourceID) {
						return $this->_action(array('store', $this->request->getBodyParams()));
					}
					break;
				case 'PATCH':
					// PATCH could only allow single element
					if (!$resourceID) {
						return $this->_defaultAction();
					}
				case 'PUT':
					return $this->_action(array('update', $resourceID, $this->request->getBodyParams()));
					break;
				case 'DELETE':
					return $this->_action(array('delete', $resourceID, $this->request->getBodyParams()));
					break;
				case 'GET':
				default:
					if ($resourceID) {
						return $this->_action(array('show', $resourceID));
					} else {
						return $this->_action(array('index'));
					}
					break;
			}
		}

		/**
		 * Alias of route()
		 *
		 * `resource/api` URI pattern
		 */
		public function api($resourceID = null)
		{
			return $this->route($resourceID);
		}

		/**
		 * Alias of route()
		 *
		 * `resource/ajax` URI pattern
		 */
		public function ajax($resourceID = null)
		{
			return $this->route($resourceID);
		}

		/**
		 * Output by JSON format with optinal body format
		 *
		 * @param array|mixed $data Callback data body, false will remove body key
		 * @param bool $bodyFormat Enable body format
		 * @param int $statusCode HTTP Status Code
		 * @param string $message Callback message
		 *
		 * @return string Response body data
		 *
		 * @throws \Exception
		 * @example
		 *  json(false, true, 401, 'Login Required', 'Unauthorized');
		 * @deprecated 1.3.0
		 *
		 */
		protected function json($data = array(), $bodyFormat = null, $statusCode = null, $message = null)
		{
			// Check default Body Format setting if not assigning
			$bodyFormat = ($bodyFormat !== null) ? $bodyFormat : $this->bodyFormat;

			if ($bodyFormat) {
				// Pack data
				$data = $this->_format($statusCode, $message, $data);
			} else {
				// JSON standard of RFC4627
				$data = is_array($data) ? $data : array($data);
			}

			return $this->response->json($data, $statusCode);
		}

		/**
		 * Format Response Data
		 *
		 * @param int $statusCode Callback status code
		 * @param string $message Callback status text
		 * @param array|mixed|bool $body Callback data body, false will remove body key
		 *
		 * @return array Formatted array data
		 * @deprecated 1.3.0
		 *
		 */
		protected function _format($statusCode = null, $message = null, $body = false)
		{
			$format = array();
			// Status Code field is necessary
			$format['code'] = ($statusCode) ?: $this->response->getStatusCode();
			// Message field
			if ($message) {
				$format['message'] = $message;
			}
			// Body field
			if ($body !== false) {
				$format['data'] = $body;
			}

			return $format;
		}

		/**
		 * Pack array data into body format
		 *
		 * You could override this method for your application standard
		 *
		 * @param array|mixed $data Original data
		 * @param int $statusCode HTTP Status Code
		 * @param string $message Callback message
		 *
		 * @return array Packed data
		 * @example
		 *  $packedData = pack(['bar'=>'foo], 401, 'Login Required');
		 */
		protected function pack($data, $statusCode = 200, $message = null)
		{
			$packBody = array();

			// Status Code
			if ($statusCode) {

				$packBody['code'] = $statusCode;
			}
			// Message
			if ($message) {

				$packBody['message'] = $message;
			}
			// Data
			if (is_array($data) || is_string($data)) {

				$packBody['data'] = $data;
			}

			return $packBody;
		}

		/**
		 * Default Action
		 */
		protected function _defaultAction()
		{
			/* Response sample code */ // $response->data = ['foo'=>'bar'];
			// $response->setStatusCode(401);

			// Codeigniter 404 Error Handling
			show_404();
		}

		/**
		 * Set behavior to a action before route
		 *
		 * @param String $action
		 * @param Callable $function
		 *
		 * @return boolean Result
		 */
		protected function _setBehavior($action, callable $function)
		{
			if (array_key_exists($action, $this->behaviors)) {

				$this->behaviors[$action] = $function;

				return true;
			}

			return false;
		}

		/**
		 * Action processor for route
		 *
		 * @param array $params Elements contains method for first and params for others
		 */
		private function _action($params)
		{
			// Shift and get the method
			$method = array_shift($params);

			// Behavior
			if ($this->behaviors[$method]) {
				$this->behaviors[$method]();
			}

			if (!isset($this->routes[$method])) {
				$this->_defaultAction();
			}

			// Get corresponding method name
			$method = $this->routes[$method];

			if (!method_exists($this, $method)) {
				$this->_defaultAction();
			}

			return call_user_func_array([$this, $method], $params);
		}
	}
}
