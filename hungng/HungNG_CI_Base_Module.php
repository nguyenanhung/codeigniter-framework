<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/16/2021
 * Time: 22:02
 */
if (!class_exists('HungNG_CI_Base_Module')) {
	/**
	 * Class HungNG_CI_Base_Module
	 *
	 * @author    713uk13m <dev@nguyenanhung.com>
	 * @copyright 713uk13m <dev@nguyenanhung.com>
	 *
	 * @property CI_Benchmark                                      $benchmark                           This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
	 * @property CI_Calendar                                       $calendar                            This class enables the creation of calendars
	 * @property CI_Cache                                          $cache                               Caching Class
	 * @property CI_Cart                                           $cart                                Shopping Cart Class
	 * @property CI_Config                                         $config                              This class contains functions that enable config files to be managed
	 * @property CI_Controller                                     $controller                          This class object is the super class that every library in CodeIgniter will be assigned to
	 * @property CI_DB_forge                                       $dbforge                             Database Forge Class
	 * @property CI_DB_pdo_driver|CI_DB_query_builder|CI_DB_driver $db                                  This is the platform-independent base Query Builder implementation class
	 * @property CI_DB_utility                                     $dbutil                              Database Utility Class
	 * @property CI_Driver_Library                                 $driver                              Driver Library Class
	 * @property CI_Email                                          $email                               Permits email to be sent using Mail, Sendmail, or SMTP
	 * @property CI_Encrypt                                        $encrypt                             Provides two-way keyed encoding using Mcrypt
	 * @property CI_Encryption                                     $encryption                          Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions
	 * @property CI_Exceptions                                     $exceptions                          Exceptions Class
	 * @property CI_Form_validation                                $form_validation                     Form Validation Class
	 * @property CI_FTP                                            $ftp                                 FTP Class
	 * @property CI_Hooks                                          $hooks                               Provides a mechanism to extend the base system without hacking
	 * @property CI_Image_lib                                      $image_lib                           Image Manipulation class
	 * @property CI_Input                                          $input                               Pre-processes global input data for security
	 * @property CI_Javascript                                     $javascript                          Javascript Class
	 * @property CI_Jquery                                         $jquery                              Jquery Class
	 * @property CI_Lang                                           $lang                                Language Class
	 * @property CI_Loader                                         $load                                Loads framework components
	 * @property CI_Log                                            $log                                 Logging Class
	 * @property CI_Migration                                      $migration                           All migrations should implement this, forces up() and down() and gives access to the CI super-global
	 * @property CI_Model                                          $model                               CodeIgniter Model Class
	 * @property CI_Output                                         $output                              Responsible for sending final output to the browser
	 * @property CI_Pagination                                     $pagination                          Pagination Class
	 * @property CI_Parser                                         $parser                              Parser Class
	 * @property CI_Profiler                                       $profiler                            This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
	 * @property CI_Router                                         $router                              Parses URIs and determines routing
	 * @property CI_Security                                       $security                            Security Class
	 * @property CI_Session                                        $session                             Session Class
	 * @property CI_Table                                          $table                               Lets you create tables manually or from database result objects, or arrays
	 * @property CI_Trackback                                      $trackback                           Trackback Sending/Receiving Class
	 * @property CI_Typography                                     $typography                          Typography Class
	 * @property CI_Unit_test                                      $unit                                Simple testing class
	 * @property CI_Upload                                         $upload                              File Uploading Class
	 * @property CI_URI                                            $uri                                 Parses URIs and determines routing
	 * @property CI_User_agent                                     $agent                               Identifies the platform, browser, robot, or mobile device of the browsing agent
	 * @property CI_Xmlrpc                                         $xmlrpc                              XML-RPC request handler class
	 * @property CI_Xmlrpcs                                        $xmlrpcs                             XML-RPC server class
	 * @property CI_Zip                                            $zip                                 Zip Compression Class
	 * @property CI_Utf8                                           $utf8                                Provides support for UTF-8 environments
	 */
	class HungNG_CI_Base_Module extends MX_Controller
	{
		/**
		 * HungNG_CI_Base_Module constructor.
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 */
		public function __construct()
		{
			parent::__construct();
		}

		/**
		 * Function defaultJsonResponseInfo
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 25/06/2022 20:41
		 */
		protected function defaultJsonResponseInfo()
		{
			$response = array(
				'code'         => StatusCodes::HTTP_OK,
				'message'      => StatusCodes::$statusTexts[StatusCodes::HTTP_OK],
				'info'         => array(
					'name'     => 'Nguyen An Hung',
					'email'    => 'dev@nguyenanhung.com',
					'web'      => 'https://nguyenanhung.com',
					'blog'     => 'https://blog.nguyenanhung.com',
					'facebook' => 'https://facebook.com/nguyenanhung',
					'github'   => 'https://github.com/nguyenanhung'
				),
				'request_data' => array(
					'ip'             => getIPAddress(),
					'user_agent'     => $this->input->user_agent(true),
					'request_method' => $this->input->method(true)
				)
			);
			$this->output->set_status_header()->set_content_type('application/json', 'utf-8')->set_output(json_encode($response, JSON_PRETTY_PRINT))->_display();
			exit;
		}

		/**
		 * Function renderOutput
		 *
		 * @param $response
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 38:04
		 */
		protected function renderOutput($response)
		{
			$method = $this->input->method(true);
			$ip = getIPAddress();
			$userAgent = $this->input->user_agent(true);
			$message = 'Received ' . $method . ' Request from IP: ' . $ip . ' - With User Agent: ' . $userAgent;
			if (method_exists($this, 'log')) {
				$this->log('RequestAPI', $message, $response);
			}
			$this->output->set_status_header()->set_content_type('application/json', 'utf-8')->set_output(json_encode($response))->_display();
			exit;
		}

		/**
		 * Function renderOutputPretty
		 *
		 * @param $response
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 38:04
		 */
		protected function renderOutputPretty($response)
		{
			$method = $this->input->method(true);
			$ip = getIPAddress();
			$userAgent = $this->input->user_agent(true);
			$message = 'Received ' . $method . ' Request from IP: ' . $ip . ' - With User Agent: ' . $userAgent;
			if (method_exists($this, 'log')) {
				$this->log('RequestAPI', $message, $response);
			}
			$this->output->set_status_header()->set_content_type('application/json', 'utf-8')->set_output(json_encode($response, JSON_PRETTY_PRINT))->_display();
			exit;
		}

		/**
		 * Function jsonResponse
		 *
		 * @param array|object|string $response
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/16/2021 12:51
		 */
		protected function jsonResponse($response = array(), $status = 200)
		{
			$method = $this->input->method(true);
			$ip = getIPAddress();
			$userAgent = $this->input->user_agent(true);
			$message = 'Received ' . $method . ' Request from IP: ' . $ip . ' - With User Agent: ' . $userAgent;
			log_message('debug', $message);
			if (is_array($response) || is_object($response)) {
				$response = json_encode($response);
			}
			$this->output->set_status_header($status)->set_content_type('application/json', 'utf-8')->set_output($response)->_display();
			exit;
		}

		/**
		 * Function jsonResponsePretty
		 *
		 * @param array|object|string $response
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/16/2021 12:51
		 */
		protected function jsonResponsePretty($response = array(), $status = 200)
		{
			$method = $this->input->method(true);
			$ip = getIPAddress();
			$userAgent = $this->input->user_agent(true);
			$message = 'Received ' . $method . ' Request from IP: ' . $ip . ' - With User Agent: ' . $userAgent;
			log_message('debug', $message);
			if (is_array($response) || is_object($response)) {
				$response = json_encode($response, JSON_PRETTY_PRINT);
			}
			$this->output->set_status_header($status)->set_content_type('application/json', 'utf-8')->set_output($response)->_display();
			exit;
		}

		/**
		 * Function errorExceptionResponse
		 *
		 * @param $exception
		 *
		 * @return array
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/16/2021 14:58
		 */
		protected function errorExceptionResponse($exception)
		{
			$errorMessage = "Error Code: " . $exception->getCode() . " - Error File: " . $exception->getFile() . " - Error Line: " . $exception->getLine() . " - Error Message: " . $exception->getMessage();
			log_message('error', $errorMessage);
			log_message('error', $exception->getTraceAsString());

			$response = array();
			$response['code'] = StatusCodes::HTTP_BAD_REQUEST;
			$response['message'] = StatusCodes::$statusTexts[StatusCodes::HTTP_BAD_REQUEST];
			if ((defined('ENVIRONMENT') && (ENVIRONMENT === 'development' || ENVIRONMENT === 'staging' || ENVIRONMENT === 'testing')) || in_array(getIPAddress(), config_item('whitelist_ip'), true)) {
				$response['error'] = array(
					'Code'          => $exception->getCode(),
					'File'          => $exception->getFile(),
					'Line'          => $exception->getLine(),
					'Message'       => $exception->getMessage(),
					'TraceAsString' => $exception->getTraceAsString(),
				);
			}

			return $response;
		}

		/**
		 * Function errorResponse
		 *
		 * @param string|array|object|bool $message
		 *
		 * @return array
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/16/2021 15:43
		 */
		protected function errorResponse($message = '')
		{
			$response = array();
			$response['code'] = StatusCodes::HTTP_BAD_REQUEST;
			$response['message'] = StatusCodes::$statusTexts[StatusCodes::HTTP_BAD_REQUEST];
			$response['errorMessage'] = $message;

			return $response;
		}

		/**
		 * Function errorMethodResponse
		 *
		 * @return array
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/16/2021 15:36
		 */
		protected function errorMethodResponse()
		{
			return array(
				'code'    => StatusCodes::HTTP_METHOD_NOT_ALLOWED,
				'message' => StatusCodes::$statusTexts[StatusCodes::HTTP_METHOD_NOT_ALLOWED]
			);
		}

		/**
		 * Function errorCredentialsResponse
		 *
		 * @param string|array|object|bool $message
		 *
		 * @return array
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 22:30
		 */
		protected function errorCredentialsResponse($message = '')
		{
			return array(
				'code'         => StatusCodes::HTTP_FORBIDDEN,
				'message'      => StatusCodes::$statusTexts[StatusCodes::HTTP_FORBIDDEN],
				'errorMessage' => $message
			);
		}

		/**
		 * Function errorSignatureResponse
		 *
		 * @param array $validSignature
		 *
		 * @return array
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/16/2021 17:32
		 */
		protected function errorSignatureResponse($validSignature = array())
		{
			$response = array();
			$response['code'] = StatusCodes::HTTP_FORBIDDEN;
			$response['message'] = StatusCodes::$statusTexts[StatusCodes::HTTP_FORBIDDEN];
			if ((defined('_PROCESS_TEST_') && _PROCESS_TEST_ === true) || in_array(getIPAddress(), config_item('whitelist_ip'), true)) {
				$response['validSignature'] = $validSignature;
			}

			return $response;
		}

		/**
		 * Function log
		 *
		 * @param $name
		 * @param $message
		 * @param $context
		 * @param $inputLevel
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 25/06/2022 32:45
		 */
		protected function log($name = '', $message = '', $context = array(), $inputLevel = 'info')
		{
			try {
				if (class_exists('Monolog\Logger') && class_exists('Monolog\Formatter\LineFormatter') && class_exists('Monolog\Handler\StreamHandler')) {
					$useLevel = bear_str_to_lower($inputLevel);
					switch ($useLevel) {
						case 'debug':
							$keyLevel = Monolog\Logger::DEBUG;
							break;
						case 'notice':
							$keyLevel = Monolog\Logger::NOTICE;
							break;
						case 'warning':
							$keyLevel = Monolog\Logger::WARNING;
							break;
						case 'error':
							$keyLevel = Monolog\Logger::ERROR;
							break;
						case 'critical':
							$keyLevel = Monolog\Logger::CRITICAL;
							break;
						case 'alert':
							$keyLevel = Monolog\Logger::ALERT;
							break;
						case 'emergency':
							$keyLevel = Monolog\Logger::EMERGENCY;
							break;
						default:
							$keyLevel = Monolog\Logger::INFO;
					}
					if (directory_exists(__DIR__ . '/../../../../storage/logs')) {
						$logPath = realpath(__DIR__ . '/../../../../storage/logs') . '/';
					} elseif (defined('APPPATH')) {
						$logPath = APPPATH . '/logs-data/';
					} else {
						$logPath = dirname(__DIR__) . '/logs-data/';
					}
					$fileName = $logPath . 'Log-' . date('Y-m-d') . '.log';
					$formatter = new Monolog\Formatter\LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n", "Y-m-d H:i:s u");
					$stream = new Monolog\Handler\StreamHandler($fileName, $keyLevel, true, 0777);
					$stream->setFormatter($formatter);
					$logger = new Monolog\Logger(trim($name));
					$logger->pushHandler($stream);
					if (is_array($context)) {
						$logger->$useLevel($message, $context);
					} else {
						$logger->$useLevel($message . json_encode($context));
					}
				} else {
					log_message($inputLevel, $name . " | Error Message: " . $message . ' | Context: ' . json_encode($context));
				}
			} catch (InvalidArgumentException $exception) {
				log_message('error', $exception->getMessage());
				log_message('error', $exception->getTraceAsString());
			} catch (Exception $exception) {
				log_message('error', $exception->getMessage());
				log_message('error', $exception->getTraceAsString());
			}
		}

		/**
		 * Function storeLogging
		 *
		 * @param $level
		 * @param $name
		 * @param $message
		 * @param $context
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 26/02/2023 18:26
		 */
		protected function storeLogging($level = 'info', $name = 'logger', $message = '', $context = array())
		{
			$this->log($name, $message, $context, $level);
		}

		/**
		 * Function default_base_flush_logs
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 26/12/2022 04:29
		 */
		protected function default_base_flush_logs()
		{
			if (is_cli()) {
				try {
					$file = new \nguyenanhung\MyDebug\Manager\File();
					$file->setInclude(array('*.log', '*.txt', 'log-*.php'));
					if (defined('APPPATH')) {
						$applicationPath = APPPATH;
					} else {
						$applicationPath = dirname(__DIR__) . '/';
					}
					$response = array(
						'status' => 'OK',
						'time'   => date('Y-m-d H:i:s'),
						'data'   => array(
							'logs'      => $file->cleanLog($applicationPath . 'logs', 7),
							'logs-data' => $file->cleanLog($applicationPath . 'logs-data', 7)
						)
					);
					log_message('debug', 'Clean Log Result: ' . json_encode($response));
					$output = defined('JSON_PRETTY_PRINT') ? json_encode($response, JSON_PRETTY_PRINT) : json_encode($response);
					$this->output->set_status_header()->set_content_type('application/json', 'utf-8')->set_output($output . PHP_EOL)->_display();
					exit;
				} catch (Exception $e) {
					$message = 'Code: ' . $e->getCode() . ' - File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
					log_message('error', $message);
					echo $message . PHP_EOL;
					exit;
				}
			} else {
				$info = array(
					'method'          => $this->input->method(true),
					'ip_address'      => $this->input->ip_address(),
					'user_agent'      => $this->input->user_agent(true),
					'request_headers' => $this->input->request_headers(true)
				);
				log_message('error', json_encode($info));
				show_404();
			}
		}

		/**
		 * Function opcache_flush_reset
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 26/12/2022 01:36
		 */
		protected function opcache_flush_reset()
		{
			if (function_exists('opcache_reset') && is_cli()) {
				opcache_reset();
			} else {
				show_404();
			}
		}

		/**
		 * Function command_clean_cache_file
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 12/02/2023 08:12
		 */
		protected function command_clean_cache_file()
		{
			if (is_cli()) {
				$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
				$this->cache->clean();
			} else {
				show_404();
			}
		}

		/**
		 * Function command_clean_cache_apc
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 12/02/2023 08:36
		 */
		protected function command_clean_cache_apc()
		{
			if (is_cli()) {
				$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				$this->cache->clean();
			} else {
				show_404();
			}
		}
	}
}
