<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/02/2023
 * Time: 19:25
 */
if (!class_exists('HungNG_CI_Base_Custom_Model_Credentials_model')) {
	/**
	 * Class HungNG_CI_Base_Custom_Model_Credentials_model
	 *
	 * @author    713uk13m <dev@nguyenanhung.com>
	 * @copyright 713uk13m <dev@nguyenanhung.com>
	 *
	 * @property CI_DB_pdo_driver|CI_DB_mysqli_driver|CI_DB_query_builder|CI_DB_driver $db  This is the platform-independent base Query Builder implementation class
	 */
	class HungNG_CI_Base_Custom_Model_Credentials_model extends HungNG_Custom_Based_model
	{
		const IS_ACTIVE = 1;
		const ROLE_PUSH = 1;
		const ROLE_PULL = 2;
		const ROLE_FULL = 3;

		protected $fieldUsername;
		protected $fieldStatus;
		protected $fieldRole;

		/**
		 * HungNG_Basic_Custom_Credentials_model constructor.
		 *
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 */
		public function __construct()
		{
			parent::__construct();
			$this->db = $this->load->database('default', true, true);
			$this->tableName = 'credentials';
			$this->primary_key = 'id';
			$this->fieldUsername = 'username';
			$this->fieldStatus = 'status';
			$this->fieldRole = 'role';
		}

		/**
		 * Function checkCredentials
		 *
		 * @param string $username
		 *
		 * @return int
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 35:51
		 */
		public function checkCredentials($username = '')
		{
			$this->db->select($this->primary_key);
			$this->db->from($this->tableName);
			$this->db->where($this->fieldUsername, $username);
			$this->db->where($this->fieldStatus, self::IS_ACTIVE);
			return $this->db->count_all_results();
		}

		/**
		 * Function getInfoCredentials
		 *
		 * @param string $username
		 *
		 * @return array|mixed|object|null
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 40:35
		 */
		public function getInfoCredentials($username = '')
		{
			$this->db->select();
			$this->db->from($this->tableName);
			$this->db->where($this->fieldUsername, $username);
			$this->db->where($this->fieldStatus, self::IS_ACTIVE);
			$info = $this->db->get()->row();
			if (empty($info)) {
				return null;
			}

			return $info;
		}

		/**
		 * Function checkUserRoleIsFull
		 *
		 * @param string $username
		 *
		 * @return bool
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 41:52
		 */
		public function checkUserRoleIsFull($username = '')
		{
			$this->db->select($this->primary_key);
			$this->db->from($this->tableName);
			$this->db->where($this->fieldUsername, $username);
			$this->db->where($this->fieldStatus, self::IS_ACTIVE);
			$this->db->where($this->fieldRole, self::ROLE_FULL);
			$result = $this->db->count_all_results();
			if ($result) {
				return true;
			}

			return false;
		}

		/**
		 * Function checkUserRoleIsPull
		 *
		 * @param string $username
		 *
		 * @return bool
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 42:35
		 */
		public function checkUserRoleIsPull($username = '')
		{
			$this->db->select($this->primary_key);
			$this->db->from($this->tableName);
			$this->db->where($this->fieldUsername, $username);
			$this->db->where($this->fieldStatus, self::IS_ACTIVE);
			$this->db->where_in($this->fieldRole, array(self::ROLE_FULL, self::ROLE_PULL));
			$result = $this->db->count_all_results();
			if ($result) {
				return true;
			}

			return false;
		}

		/**
		 * Function checkUserRoleIsPush
		 *
		 * @param string $username
		 *
		 * @return bool
		 * @author   : 713uk13m <dev@nguyenanhung.com>
		 * @copyright: 713uk13m <dev@nguyenanhung.com>
		 * @time     : 09/03/2021 42:58
		 */
		public function checkUserRoleIsPush($username = '')
		{
			$this->db->select($this->primary_key);
			$this->db->from($this->tableName);
			$this->db->where($this->fieldUsername, $username);
			$this->db->where($this->fieldStatus, self::IS_ACTIVE);
			$this->db->where_in($this->fieldRole, array(self::ROLE_FULL, self::ROLE_PUSH));
			$result = $this->db->count_all_results();
			if ($result) {
				return true;
			}

			return false;
		}
	}
}
