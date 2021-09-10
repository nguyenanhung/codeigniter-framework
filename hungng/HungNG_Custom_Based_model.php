<?php
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
	 * @property \CI_Loader           $load
	 * @property \CI_DB_query_builder $db
	 */
	class HungNG_Custom_Based_model extends CI_Model
	{
		public $db;
		public $tableName;
		public $primary_key;
		public $is_not;
		public $or_higher;
		public $is_higher;
		public $or_smaller;
		public $is_smaller;
		public $start_time;
		public $end_time;

		/**
		 * HungNG_Custom_Based_model constructor.
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 */
		public function __construct()
		{
			parent::__construct();
			$this->db          = '';
			$this->tableName   = '';
			$this->primary_key = 'id';
			$this->is_not      = ' !=';
			$this->or_higher   = ' >=';
			$this->is_higher   = ' >';
			$this->or_smaller  = ' <=';
			$this->is_smaller  = ' <';
			$this->start_time  = ' 00:00:00';
			$this->end_time    = ' 23:59:59';
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

		/**
		 * Function page_limit
		 *
		 * @param int $size
		 * @param int $page
		 *
		 * @return mixed|void
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/25/2021 53:15
		 */
		public function page_limit($size = 500, $page = 0)
		{
			if ($size != 'no_limit') {
				if ($page != 0) {
					if (!$page || $page <= 0 || empty($page)) {
						$page = 1;
					}
					$start = ($page - 1) * $size;
				} else {
					$start = $page;
				}

				return $this->db->limit($size, $start);
			}
		}

		/**
		 * Function _page_limit
		 *
		 * @param int $size
		 * @param int $page
		 *
		 * @return \CI_DB_pdo_driver
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:54
		 */
		public function _page_limit($size = 500, $page = 0)
		{
			return $this->page_limit($size, $page);
		}

		/**
		 * Function check_exists
		 *
		 * @param string $value
		 * @param null   $field
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:20
		 */
		public function check_exists($value = '', $field = null)
		{
			$this->db->select('id');
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
		 * @param string $field
		 *
		 * @return array|array[]|object|object[]
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 30:03
		 */
		public function get_all_asc($field = '*')
		{
			$this->db->select($field);
			$this->db->from($this->tableName);
			$this->db->order_by($field, 'ASC');

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
		 * Function get_info
		 *
		 * @param string $value
		 * @param null   $field
		 * @param false  $array
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
			} else {
				return $this->db->get()->row();
			}
		}

		/**
		 * Function get_value
		 *
		 * @param string $value_input
		 * @param null   $field_input
		 * @param null   $field_output
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
			// Query
			if (null !== $field_output) {
				if (null === $query->row()) {
					return null;
				} else {
					return $query->row()->$field_output;
				}
			} else {
				return $query->row();
			}
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
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->tableName, $data);

			return $this->db->affected_rows();
		}

		/**
		 * Function delete
		 *
		 * @param string $id
		 *
		 * @return false|int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:40
		 */
		public function delete($id = '')
		{
			if (empty($id)) {
				return false;
			}
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->tableName);

			return $this->db->affected_rows();
		}

		/**
		 * Function request_builder
		 *
		 * @param $search
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 08/16/2021 29:37
		 */
		public function request_builder($search)
		{
			if (!empty($search)) {
				foreach ($search as $field => $value) {
					if ($this->db->field_exists($field, $this->tableName)) {
						if (!empty($value)) {
							if (is_array($value)) {
								$this->db->where_in($this->tableName . '.' . $field, $value);
							} else {
								$this->db->like($this->tableName . '.' . $field, $value);
							}
						}
					}
					if ($field == 'sort') {
						$sort   = (strpos($value, '-') === false) ? 'DESC' : 'ASC';
						$column = (strpos($value, '-') === false) ? $value : substr($value, 1);
						if ($this->db->field_exists($column, $this->tableName)) {
							$this->db->order_by($this->tableName . '.' . $column, $sort);
						}
					}
				}
			}
		}

		/**
		 * __destruct models
		 */
		public function __destruct()
		{
			if ($this->db != '') {
				$this->close();
			}
		}
	}
}
