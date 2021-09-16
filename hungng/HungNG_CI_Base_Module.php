<?php
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
	 * @property \CI_Loader          load
	 * @property \CI_Benchmark       benchmark
	 * @property \CI_Config          config
	 * @property \CI_Input           input
	 * @property \CI_Output          output
	 * @property \CI_User_agent      user_agent
	 * @property \CI_Lang            lang
	 * @property \CI_Cache           cache
	 * @property \CI_Parser          parser
	 * @property \CI_Session         session
	 * @property \CI_Security        security
	 * @property \CI_Upload          upload
	 * @property \CI_Image_lib       image_lib
	 * @property \CI_Form_validation form_validation
	 * @property \CI_Encrypt         encrypt
	 * @property \CI_Encryption      encryption
	 * @property \CI_Table           table
	 * @property \CI_Email           email
	 * @property \CI_Typography      typography
	 * @property \CI_Calendar        calendar
	 * @property \CI_Pagination      pagination
	 * @property \CI_Zip             zip
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
			$method    = $this->input->method(true);
			$ip        = getIPAddress();
			$userAgent = $this->input->user_agent(true);
			$message   = 'Received ' . $method . ' Request from IP: ' . $ip . ' - With User Agent: ' . $userAgent;
			log_message('debug', $message);
			if (is_array($response) || is_object($response)) {
				$response = json_encode($response);
			}
			$this->output->set_status_header($status)
						 ->set_content_type('application/json', 'utf-8')
						 ->set_output($response)
						 ->_display();
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
			$errorMessage = "Error Code: " . $exception->getCode() .
							" - Error File: " . $exception->getFile() .
							" - Error Line: " . $exception->getLine() .
							" - Error Message: " . $exception->getMessage();
			log_message('error', $errorMessage);
			log_message('error', $exception->getTraceAsString());

			$response            = array();
			$response['code']    = StatusCodes::HTTP_BAD_REQUEST;
			$response['message'] = StatusCodes::$statusTexts[StatusCodes::HTTP_BAD_REQUEST];
			if (
				(
					defined('ENVIRONMENT') &&
					(ENVIRONMENT === 'development' || ENVIRONMENT === 'staging' || ENVIRONMENT === 'testing')
				)
				||
				in_array(getIPAddress(), config_item('whitelist_ip'))
			) {
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
			$response                 = array();
			$response['code']         = StatusCodes::HTTP_BAD_REQUEST;
			$response['message']      = StatusCodes::$statusTexts[StatusCodes::HTTP_BAD_REQUEST];
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
			$response            = array();
			$response['code']    = StatusCodes::HTTP_FORBIDDEN;
			$response['message'] = StatusCodes::$statusTexts[StatusCodes::HTTP_FORBIDDEN];
			if ((defined('_PROCESS_TEST_') && _PROCESS_TEST_ === true) || in_array(getIPAddress(), config_item('whitelist_ip'))) {
				$response['validSignature'] = $validSignature;
			}

			return $response;
		}
	}
}
