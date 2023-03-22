<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 08/25/2021
 * Time: 13:50
 */
if (!class_exists('HungNG_Custom_Based_model')) {
	/**
	 * Class HungNA_Based_model
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
	class HungNG_Custom_Based_model extends CI_Model
	{
		const OPERATOR_EQUAL_TO = '=';
		const OPERATOR_NOT_EQUAL_TO = '!=';
		const OPERATOR_LESS_THAN = '<';
		const OPERATOR_LESS_THAN_OR_EQUAL_TO = '<=';
		const OPERATOR_GREATER_THAN = '>';
		const OPERATOR_GREATER_THAN_OR_EQUAL_TO = '>=';
		const OPERATOR_IS_SPACESHIP = '<=>';
		const OPERATOR_IS_IN = 'IN';
		const OPERATOR_IS_LIKE = 'LIKE';
		const OPERATOR_IS_LIKE_BINARY = 'LIKE BINARY';
		const OPERATOR_IS_ILIKE = 'ilike';
		const OPERATOR_IS_NOT_LIKE = 'NOT LIKE';
		const OPERATOR_IS_NULL = 'IS NULL';
		const OPERATOR_IS_NOT_NULL = 'IS NOT NULL';
		const ORDER_ASCENDING = 'ASC';
		const ORDER_DESCENDING = 'DESC';
		const ORDER_RANDOM = 'RAND';
		const DEFAULT_STATUS_IS_ACTIVE = 1;
		const DEFAULT_STATUS_IS_DE_ACTIVE = 0;

		/** @var \CI_DB_query_builder $db */
		protected $db;

		/** @var string $tableName */
		protected $tableName;

		/** @var string $primary_key */
		protected $primary_key;

		/** @var string $is_not $is_not */
		protected $is_not;

		/** @var string $or_higher */
		protected $or_higher;

		/** @var string $is_higher */
		protected $is_higher;

		/** @var string $or_smaller */
		protected $or_smaller;

		/** @var string $is_smaller */
		protected $is_smaller;

		/** @var array $field */
		protected $field = array();

		/** @var string $start_time */
		protected $start_time;

		/** @var string $end_time */
		protected $end_time;

		/** @var string $created_at */
		protected $created_at;

		/** @var string $updated_at */
		protected $updated_at;

		/** @var string $deleted_at */
		protected $deleted_at;

		/** @var string $published_at */
		protected $published_at;

		/**
		 * HungNG_Custom_Based_model constructor.
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 */
		public function __construct()
		{
			parent::__construct();
			$this->db = $this->load->database('default', true, true);
			$this->tableName = '';
			$this->primary_key = 'id';
			$this->created_at = 'created_at';
			$this->updated_at = 'updated_at';
			$this->deleted_at = 'deleted_at';
			$this->published_at = 'published_at';
			$this->is_not = ' !=';
			$this->or_higher = ' >=';
			$this->is_higher = ' >';
			$this->or_smaller = ' <=';
			$this->is_smaller = ' <';
			$this->start_time = ' 00:00:00';
			$this->end_time = ' 23:59:59';
		}

		/**
		 * __destruct models
		 */
		public function __destruct()
		{
			if (is_object($this->db)) {
				$this->close();
			}
		}

		/**
		 * Function setDb
		 *
		 * @param string $db_group
		 *
		 * @return $this
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 12/09/2020 38:49
		 */
		public function setDb($db_group = '')
		{
			$this->db = $this->load->database($db_group, true, true);

			return $this;
		}

		/**
		 * Function setTableName
		 *
		 * @param string $tableName
		 *
		 * @return $this
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:49
		 */
		public function setTableName($tableName = '')
		{
			$this->tableName = $tableName;

			return $this;
		}

		/**
		 * Function getTableName
		 *
		 * @return string
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:45
		 */
		public function getTableName()
		{
			return $this->tableName;
		}

		/**
		 * Function close
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/25/2021 52:39
		 */
		public function close()
		{
			$this->db->close();
		}

		// ---------------------------------------------------------------------------------------------------------------------------------------- //

		/**
		 * Function get_off_set
		 *
		 * @param $size
		 * @param $page
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/03/2023 13:24
		 */
		public function get_off_set($size = 500, $page = 0)
		{
			$size = (int) $size;
			$page = (int) $page;
			if ($page !== 0) {
				if ($page <= 0 || empty($page)) {
					$page = 1;
				}
				$start = ($page - 1) * $size;
			} else {
				$start = $page;
			}

			return (int) $start;
		}

		/**
		 * Function page_limit
		 *
		 * @param int $size
		 * @param int $page
		 *
		 * @return \CI_DB_query_builder
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 03/06/2022 20:38
		 */
		public function page_limit($size = 500, $page = 0)
		{
			if ($size !== 'no_limit') {
				$start = $this->get_off_set($size, $page);

				return $this->db->limit($size, $start);
			}

			return $this->db;
		}

		/**
		 * Function _page_limit alias of page_limit
		 *
		 * @param int $size
		 * @param int $page
		 *
		 * @deprecated use page_limit method
		 * @return \CI_DB_query_builder
		 * @author     : 713uk13m <dev@nguyenanhung.com>
		 * @copyright  : 713uk13m <dev@nguyenanhung.com>
		 * @time       : 08/16/2021 30:54
		 */
		public function _page_limit($size = 500, $page = 0)
		{
			return $this->page_limit($size, $page);
		}

		/**
		 * Function bind_order_result
		 *
		 * Lưu ý: mặc định sẽ order theo giá trị $direction và $field, $field truyền vào
		 * Trong trường hợp sử dụng $table=order_by_field, cần setup cả table và field trong biến $order_by_field trước khi truyền vào để order cho đúng
		 *
		 * @param $order_by_field
		 * @param $direction
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 11/02/2023 49:18
		 */
		public function bind_order_result($order_by_field, $direction = 'desc', $field = 'id', $table = '')
		{
			return $this->build_order_result($order_by_field, $direction, $field, $table);
		}

		/**
		 * Function build_order_result
		 *
		 * Lưu ý: mặc định sẽ order theo giá trị $direction và $field, $field truyền vào
		 * Trong trường hợp sử dụng $table=order_by_field, cần setup cả table và field trong biến $order_by_field trước khi truyền vào để order cho đúng
		 *
		 * @param $order_by_field
		 * @param $direction
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 28:15
		 */
		public function build_order_result($order_by_field, $direction = 'desc', $field = 'id', $table = '')
		{
			if (!empty($table)) {
				$tableName = trim($table) . '.';
			} else {
				$tableName = $this->tableName . '.';
			}
			if ($table === 'order_by_field') {
				$tableName = '';
			}
			if (isset($order_by_field) && is_array($order_by_field) && count($order_by_field) > 0) {
				foreach ($order_by_field as $f) {
					$this->db->order_by($tableName . $f['field_name'], $f['order_value']);
				}
			} else {
				$direction = strtoupper(trim($direction));
				if ($direction === 'RANDOM') {
					$this->db->order_by($tableName . $field, 'RANDOM');
				} else {
					$this->db->order_by($tableName . $field, $direction);
				}
			}

			return $this->db;
		}

		/**
		 * Function build_list_id_with_parent_id - Tạo 1 list các ID, trong đó chứa các tập con phụ thuộc của ID đ
		 *
		 * @param array|object|mixed $allSubId
		 * @param string|int         $parentId
		 *
		 * @return array|string|int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 13:31
		 */
		public function build_list_id_with_parent_id($allSubId, $parentId)
		{
			if (is_array($allSubId) || is_object($allSubId)) {
				// Xác định lấy toàn bộ tin tức ở các category con
				$countSub = count($allSubId); // Đếm bảng ghi Category con
				if ($countSub) {
					// Nếu tồn tại các category con
					$listSub = array();
					$listSub[] = $parentId; // Push category cha
					foreach ($allSubId as $item) {
						$itemId = is_array($item) ? $item['id'] : $item->id;
						$listSub[] = $itemId; // Push các category con vào mảng dữ liệu
					}

					return $listSub;
				}
			}

			return $parentId;
		}

		/**
		 * Function prepare_simple_wheres_not_statement
		 *
		 * @param $value
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 31:03
		 */
		public function prepare_simple_wheres_not_statement($value, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			if ($value !== null) {
				if (is_array($value)) {
					$this->db->where_not_in($tableName . '.' . $field, $value);
				} else {
					$this->db->where($tableName . '.' . $field . $this->is_not, $value);
				}
			}

			return $this->db;
		}

		/**
		 * Function prepare_simple_wheres_statement
		 *
		 * @param $value
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 31:11
		 */
		public function prepare_simple_wheres_statement($value, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			if ($value !== null) {
				if (is_array($value)) {
					$this->db->where_in($tableName . '.' . $field, $value);
				} else {
					$this->db->where($tableName . '.' . $field, $value);
				}
			}

			return $this->db;
		}

		/**
		 * Function prepare_wheres_statement
		 *
		 * @param $wheres
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 50:08
		 */
		public function prepare_wheres_statement($wheres)
		{
			if (!empty($wheres) && is_array($wheres) && count($wheres) > 0) {
				foreach ($wheres as $field => $value) {
					if (is_array($value)) {
						if (isset($value['field'], $value['value'])) {
							if (is_array($value['value'])) {
								$this->db->where_in($value['field'], $value['value']);
							} else {
								$this->db->where($value['field'] . ' ' . trim($value['operator']), $value['value']);
							}
						} else {
							$this->db->where_in($field, $value);
						}
					} else {
						$this->db->where($field, $value);
					}
				}
			}

			return $this->db;
		}

		/**
		 * Function prepare_wheres_not_statement
		 *
		 * @param $wheres
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 50:13
		 */
		public function prepare_wheres_not_statement($wheres)
		{
			if (!empty($wheres) && is_array($wheres) && count($wheres) > 0) {
				foreach ($wheres as $field => $value) {
					if (is_array($value)) {
						if (isset($value['field'], $value['value'])) {
							if (is_array($value['value'])) {
								$this->db->where_not_in($value['field'], $value['value']);
							} else {
								$this->db->where($value['field'] . ' ' . trim($value['operator']), $value['value']);
							}
						} else {
							$this->db->where_not_in($field, $value);
						}
					} else {
						$this->db->where($field . $this->is_not, $value);
					}
				}
			}

			return $this->db;
		}

		/**
		 * Function only_status_is_active
		 *
		 * @param $act
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 42:52
		 */
		public function only_status_is_active($act = true, $field = 'status', $table = '')
		{
			if ($act === true) {
				$useTable = !empty($table) ? trim($table) : $this->tableName;
				$useField = !empty($field) ? trim($field) : 'status';
				$tableExists = $this->db->table_exists($useTable);
				$fieldExists = $this->db->field_exists($useField, $useTable);
				if ($tableExists === false || $fieldExists === false) {
					return $this->db;
				}

				return $this->db->where($useTable . '.' . $useField, self::DEFAULT_STATUS_IS_ACTIVE);
			}

			return $this->db;
		}

		/**
		 * Function only_status_is_de_active
		 *
		 * @param $act
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 42:52
		 */
		public function only_status_is_de_active($act = true, $field = 'status', $table = '')
		{
			if ($act === true) {
				$tableName = !empty($table) ? trim($table) : $this->tableName;
				$useField = !empty($field) ? trim($field) : 'status';
				$tableExists = $this->db->table_exists($tableName);
				$fieldExists = $this->db->field_exists($useField, $tableName);
				if ($tableExists === false || $fieldExists === false) {
					return $this->db;
				}

				return $this->db->where($tableName . '.' . $useField, self::DEFAULT_STATUS_IS_DE_ACTIVE);
			}

			return $this->db;
		}

		/**
		 * Function bind_recursive_from_category
		 *
		 * @param $allSubId
		 * @param $parentId
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 00:20
		 */
		public function bind_recursive_from_category($allSubId, $parentId, $field = 'categoryId', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$listID = $this->build_list_id_with_parent_id($allSubId, $parentId);
			if (is_array($listID)) {
				$this->db->where_in($tableName . '.' . $field, $listID);
			} else {
				$this->db->where($tableName . '.' . $field, $listID);
			}

			return $this->db;
		}

		/**
		 * Function filter_by_primary_id
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 03:06
		 */
		public function filter_by_primary_id($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			if ($id !== null) {
				if (is_array($id)) {
					$this->db->where_in($tableName . '.' . $field, $id);
				} else {
					$this->db->where($tableName . '.' . $field, $id);
				}
			}

			return $this->db;
		}

		/**
		 * Function build_operator_equal_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 03:02
		 */
		public function build_operator_equal_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			if ($id !== null) {
				if (is_array($id)) {
					$this->db->where_in($tableName . '.' . $field, $id);
				} else {
					$this->db->where($tableName . '.' . $field, $id);
				}
			}

			return $this->db;
		}

		/**
		 * Function build_operator_not_equal_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 02:59
		 */
		public function build_operator_not_equal_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			if ($id !== null) {
				if (is_array($id)) {
					$this->db->where_not_in($tableName . '.' . $field, $id);
				} else {
					$this->db->where($tableName . '.' . $field . $this->is_not, $id);
				}
			}

			return $this->db;
		}

		/**
		 * Function build_operator_less_than_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 02:56
		 */
		public function build_operator_less_than_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->db->where($tableName . '.' . $field . ' ' . self::OPERATOR_LESS_THAN, $id);

			return $this->db;
		}

		/**
		 * Function build_operator_greater_than_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 02:53
		 */
		public function build_operator_greater_than_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->db->where($tableName . '.' . $field . ' ' . self::OPERATOR_GREATER_THAN, $id);

			return $this->db;
		}

		/**
		 * Function build_operator_less_than_or_equal_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 02:50
		 */
		public function build_operator_less_than_or_equal_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->db->where($tableName . '.' . $field . ' ' . self::OPERATOR_LESS_THAN_OR_EQUAL_TO, $id);

			return $this->db;
		}

		/**
		 * Function build_operator_greater_than_or_equal_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 02:46
		 */
		public function build_operator_greater_than_or_equal_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->db->where($tableName . '.' . $field . ' ' . self::OPERATOR_GREATER_THAN_OR_EQUAL_TO, $id);

			return $this->db;
		}

		/**
		 * Function build_operator_space_ship_to
		 *
		 * @param $id
		 * @param $field
		 * @param $table
		 *
		 * @return bool|\CI_DB_query_builder|object
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 02:41
		 */
		public function build_operator_space_ship_to($id, $field = 'id', $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->db->where($tableName . '.' . $field . ' ' . self::OPERATOR_IS_SPACESHIP, $id);

			return $this->db;
		}

		// ------------------------------------------ Database Metadata ------------------------------------------ //

		/**
		 * Function list_tables
		 *
		 * @return array|false|string
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 21:09
		 */
		public function list_tables()
		{
			return $this->db->list_tables();
		}

		/**
		 * Function table_exists
		 *
		 * @param $table
		 *
		 * @return bool
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 25:08
		 */
		public function table_exists($table)
		{
			return $this->db->table_exists($table);
		}

		/**
		 * Function list_fields_on_table
		 *
		 * @param $table
		 *
		 * @return array|false|string
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 25:23
		 */
		public function list_fields_on_table($table)
		{
			return $this->db->list_fields($table);
		}

		/**
		 * Function field_exists_on_table
		 *
		 * @param $field
		 * @param $table
		 *
		 * @return bool
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 26:47
		 */
		public function field_exists_on_table($field, $table)
		{
			return $this->db->field_exists($field, $table);
		}

		/**
		 * Function list_all_field_data
		 *
		 * @param $table
		 *
		 * @return array|false
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 26:44
		 */
		public function list_all_field_data($table)
		{
			return $this->db->field_data($table);
		}

		// ---------------------------------------------------------------------------------------------------------------------------------------- //

		/**
		 * Function check_exists
		 *
		 * @param string $value
		 * @param mixed  $field
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:20
		 */
		public function check_exists($value = '', $field = null)
		{
			$this->db->select($this->primary_key);
			$this->db->from($this->tableName);
			if ($field === null) {
				$this->db->where($this->primary_key, $value);
			} else {
				$this->db->where($field, $value);
			}

			return $this->db->count_all_results();
		}

		/**
		 * Function get_last_id
		 *
		 * @param string $field
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:12
		 */
		public function get_last_id($field = 'id')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);
			$this->db->limit(1);
			$this->db->order_by($field, 'DESC');
			$row = $this->db->get()->row();
			if (is_object($row)) {
				return $row->$field;
			}

			return 0;
		}

		/**
		 * Function get_first_id
		 *
		 * @param $field
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 08:37
		 */
		public function get_first_id($field = 'id')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);
			$this->db->limit(1);
			$this->db->order_by($field, 'ASC');
			$row = $this->db->get()->row();
			if (is_object($row)) {
				return $row->$field;
			}

			return 0;
		}

		/**
		 * Function get_random_id
		 *
		 * @param $field
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/02/2023 08:41
		 */
		public function get_random_id($field = 'id')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);
			$this->db->limit(1);
			$this->db->order_by($field, 'RANDOM');
			$row = $this->db->get()->row();
			if (is_object($row)) {
				return $row->$field;
			}

			return 0;
		}

		/**
		 * Function get_all
		 *
		 * @param string $field
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:08
		 */
		public function get_all($field = '*')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);

			return $this->db->get()->result();
		}

		/**
		 * Function get_all_asc
		 *
		 * @param $field
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 19:08
		 */
		public function get_all_asc($field = '*')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);
			$this->db->order_by($field, 'ASC');

			return $this->db->get()->result();
		}

		/**
		 * Function get_all_desc
		 *
		 * @param $field
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 16/02/2023 19:03
		 */
		public function get_all_desc($field = '*')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);
			$this->db->order_by($field, 'DESC');

			return $this->db->get()->result();
		}

		/**
		 * Function count_all
		 *
		 * @param string $field
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:00
		 */
		public function count_all($field = '*')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);

			return $this->db->count_all_results();
		}

		/**
		 * Function count_all_from_table
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/13/2021 07:51
		 */
		public function count_all_from_table()
		{
			return $this->db->count_all($this->tableName);
		}

		/**
		 * Function get_list_distinct
		 *
		 * @param string $field
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:58
		 */
		public function get_list_distinct($field = '*')
		{
			$this->db->distinct();
			$this->db->select($field);
			$this->db->from($this->tableName);

			return $this->db->get()->result();
		}

		/**
		 * Function get_data_simple_result
		 *
		 * @param string   $select
		 * @param array    $wheres
		 * @param int      $size
		 * @param int      $page
		 * @param string[] $orderBy
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/13/2021 16:49
		 */
		public function get_data_simple_result($select = '*', $wheres = array(), $size = 75, $page = 0, $orderBy = array('id' => 'DESC'))
		{
			$this->db->select($select);
			$this->db->from($this->tableName);
			if (count($wheres) > 0) {
				foreach ($wheres as $field => $value) {
					if (is_array($value)) {
						$this->db->where_in($this->tableName . '.' . $field, $value);
					} else {
						$this->db->where($this->tableName . '.' . $field, $value);
					}
				}
			}
			$this->page_limit($size, $page);
			foreach ($orderBy as $key => $val) {
				$this->db->order_by($this->tableName . '.' . $key, $val);
			}

			return $this->db->get()->result();
		}

		/**
		 * Function get_all_data_simple_result
		 *
		 * @param mixed $options
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 25/11/2021 46:10
		 */
		public function get_all_data_simple_result($options = null)
		{
			$this->db->from($this->tableName);
			if (is_array($options)) {
				foreach ($options as $field => $value) {
					if (is_array($value)) {
						$this->db->where_in($field, $value);
					} else {
						$this->db->where($field, $value);
					}
				}
			}

			return $this->db->get()->result();
		}

		/**
		 * Function get_info
		 *
		 * @param string $value
		 * @param mixed  $field
		 * @param bool   $array
		 *
		 * @return array|mixed|object|null
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:55
		 */
		public function get_info($value = '', $field = null, $array = false)
		{
			$this->db->from($this->tableName);
			if ($field === null) {
				$this->db->where($this->primary_key, $value);
			} else {
				$this->db->where($field, $value);
			}
			if ($array === true) {
				return $this->db->get()->row_array();
			}

			return $this->db->get()->row();
		}

		/**
		 * Function get_value
		 *
		 * @param string $value_input
		 * @param mixed  $field_input
		 * @param mixed  $field_output
		 *
		 * @return array|mixed|object|null
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:51
		 */
		public function get_value($value_input = '', $field_input = null, $field_output = null)
		{
			if (null !== $field_output) {
				$this->db->select($field_output);
			}
			$this->db->from($this->tableName);
			if ($field_input === null) {
				$this->db->where($this->primary_key, $value_input);
			} else {
				$this->db->where($field_input, $value_input);
			}
			$query = $this->db->get();
			if (null !== $field_output) {
				if (null === $query->row()) {
					return null;
				}

				return $query->row()->$field_output;
			}

			return $query->row();
		}

		/**
		 * Function add
		 *
		 * @param array $data
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:47
		 */
		public function add($data = array())
		{
			$this->db->insert($this->tableName, $data);

			return $this->db->insert_id();
		}

		/**
		 * Function insert_batch
		 *
		 * @param array $data
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:44
		 */
		public function insert_batch($data = array())
		{
			$this->db->insert_batch($this->tableName, $data);

			return $this->db->insert_id();
		}

		/**
		 * Function update
		 *
		 * @param string $id
		 * @param array  $data
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:32
		 */
		public function update($id = '', $data = array())
		{
			if (empty($id)) {
				log_message('error', 'Update method give Input Primary Key is Empty');

				return 0;
			}
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->tableName, $data);

			return $this->db->affected_rows();
		}

		/**
		 * Function where_update
		 *
		 * @param $wheres
		 * @param $data
		 * @param $table
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/03/2023 32:40
		 */
		public function where_update($wheres, $data, $table = '')
		{
			if (empty($wheres)) {
				log_message('error', 'Update method give Input Wheres is Empty');

				return 0;
			}
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->prepare_wheres_statement($wheres);
			$this->db->update($tableName, $data);

			return $this->db->affected_rows();
		}

		/**
		 * Function delete
		 *
		 * @param string $id
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/20/2021 38:36
		 */
		public function delete($id = '')
		{
			if (empty($id)) {
				log_message('error', 'Delete method give Input Primary Key is Empty');

				return 0;
			}
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->tableName);

			return $this->db->affected_rows();
		}

		/**
		 * Function where_delete
		 *
		 * @param $wheres
		 * @param $data
		 * @param $table
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 22/03/2023 33:27
		 */
		public function where_delete($wheres, $data, $table = '')
		{
			if (empty($wheres)) {
				log_message('error', 'Delete method give Input Wheres is Empty');

				return 0;
			}
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			$this->prepare_wheres_statement($wheres);
			$this->db->delete($tableName, $data);

			return $this->db->affected_rows();
		}

		/**
		 * Function request_builder
		 *
		 * @param $search
		 * @param $table
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:37
		 */
		public function request_builder($search, $table = '')
		{
			$tableName = !empty($table) ? trim($table) : $this->tableName;
			if (!empty($search)) {
				foreach ($search as $field => $value) {
					if (!empty($value) && $this->db->field_exists($field, $tableName)) {
						if (is_array($value)) {
							$this->db->where_in($tableName . '.' . $field, $value);
						} else {
							$this->db->like($tableName . '.' . $field, $value);
						}
					}
					if ($field === 'sort') {
						$sort = (strpos($value, '-') === false) ? 'DESC' : 'ASC';
						$column = (strpos($value, '-') === false) ? $value : substr($value, 1);
						if ($this->db->field_exists($column, $tableName)) {
							$this->db->order_by($tableName . '.' . $column, $sort);
						}
					}
				}
			}
		}
	}
}
