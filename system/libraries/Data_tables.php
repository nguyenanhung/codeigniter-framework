<?php
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/03/2023
 * Time: 15:01
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class CI_Data_tables
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class CI_Data_tables
{
	/**
	 * Database table
	 *
	 * @var    string
	 */
	private $table;

	/**
	 * Primary key
	 *
	 * @var    string
	 */
	private $primary_key;

	/**
	 * Columns to fetch
	 *
	 * @var    array
	 */
	private $columns;

	/**
	 * Where clause
	 *
	 * @var    mixed
	 */
	private $where;

	/**
	 * CI Singleton
	 *
	 * @var    object
	 */
	private $CI;

	/**
	 * GET request
	 *
	 * @var    array
	 */
	private $request;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param array $params Initialization parameters
	 */
	public function __construct($params)
	{
		log_message('info', 'CI_Data_tables Class Initialized');

		$this->table = (array_key_exists('table', $params) === true && is_string($params['table']) === true) ? $params['table'] : '';

		$this->primary_key = (array_key_exists('primary_key', $params) === true && is_string($params['primary_key']) === true) ? $params['primary_key'] : '';

		$this->columns = (array_key_exists('columns', $params) === true && is_array($params['columns']) === true) ? $params['columns'] : [];

		$this->where = (array_key_exists('where', $params) === true && (is_array($params['where']) === true || is_string($params['where']) === true)) ? $params['where'] : [];

		$this->CI =& get_instance();

		$this->request = $this->CI->input->get();

		$this->validate_table();

		$this->validate_primary_key();

		$this->validate_columns();

		$this->validate_request();
	}

	// --------------------------------------------------------------------

	/**
	 * Validate database table
	 */
	private function validate_table()
	{
		if ($this->CI->db->table_exists($this->table) === false) {
			$this->response(array('error' => 'Table doesn\'t exist.'));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Validate primary key
	 */
	private function validate_primary_key()
	{
		if ($this->CI->db->field_exists($this->primary_key, $this->table) === false) {
			$this->response(array('error' => 'Invalid primary key.'));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * validate columns to fetch
	 */
	private function validate_columns()
	{
		foreach ($this->columns as $column) {
			if (is_string($column) === false || $this->CI->db->field_exists($column, $this->table) === false) {
				$this->response(array('error' => 'Invalid column.'));
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * validate GET request
	 */
	private function validate_request()
	{
		if (count($this->request['columns']) !== count($this->columns)) {
			$this->response(array('error' => 'Column count mismatch.'));
		}

		foreach ($this->request['columns'] as $column) {
			if (isset($this->columns[$column['data']]) === false) {
				$this->response(array('error' => 'Missing column.'));
			}

			$this->request['columns'][$column['data']]['name'] = $this->columns[$column['data']];
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Generates the ORDER BY portion of the query
	 */
	private function order()
	{
		foreach ($this->request['order'] as $order) {
			$column = $this->request['columns'][$order['column']];

			if ($column['orderable'] === 'true') {
				$this->CI->db->order_by($column['name'], strtoupper($order['dir']));
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Generates the LIKE portion of the query
	 */
	private function search()
	{
		$global_search_value = $this->request['search']['value'];
		$likes = array();

		foreach ($this->request['columns'] as $column) {
			if ($column['searchable'] === 'true') {
				if (empty($global_search_value) === false) {
					$likes[] = array(
						'field' => $column['name'],
						'match' => $global_search_value
					);
				}

				if (empty($column['search']['value']) === false) {
					$likes[] = array(
						'field' => $column['name'],
						'match' => $column['search']['value']
					);
				}
			}
		}

		foreach ($likes as $index => $like) {
			if ($index === 0) {
				$this->CI->db->like($like['field'], $like['match']);
			} else {
				$this->CI->db->or_like($like['field'], $like['match']);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Generates the WHERE portion of the query
	 */
	private function where()
	{
		$this->CI->db->where($this->where);
	}

	// --------------------------------------------------------------------

	/**
	 * Send response to DataTables
	 *
	 * @param array $data
	 */
	private function response($data)
	{
		$this->CI->output->set_content_type('application/json');
		$this->CI->output->set_output(json_encode($data));
		$this->CI->output->_display();

		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * Calculate total number of records
	 *
	 * @return    int
	 */
	private function records_total()
	{
		$this->CI->db->reset_query();

		$this->where();

		$this->CI->db->from($this->table);

		return $this->CI->db->count_all_results();
	}

	// --------------------------------------------------------------------

	/**
	 * Calculate filtered records
	 *
	 * @return    int
	 */
	private function records_filtered()
	{
		$this->CI->db->reset_query();

		$this->search();

		$this->where();

		$this->CI->db->from($this->table);

		return $this->CI->db->count_all_results();
	}

	// --------------------------------------------------------------------

	/**
	 * Process
	 *
	 * @param string $row_id    = 'data'
	 * @param string $row_class = ''
	 */
	public function process($row_id = 'data', $row_class = '')
	{
		if (in_array($row_id, array('id', 'data', 'none'), true) === false) {
			$this->response(array('error' => 'Invalid DT_RowId.'));
		}

		if (is_string($row_class) === false) {
			$this->response(array('error' => 'Invalid DT_RowClass.'));
		}

		$columns = array();

		$add_primary_key = true;

		foreach ($this->columns as $column) {
			$columns[] = $column;

			if ($column === $this->primary_key) {
				$add_primary_key = false;
			}
		}

		if ($add_primary_key === true) {
			$columns[] = $this->primary_key;
		}

		$this->CI->db->select(implode(',', $columns));

		$this->order();

		$this->search();

		$this->where();

		$query = $this->CI->db->get($this->table, $this->request['length'], $this->request['start']);

		$data['data'] = array();

		foreach ($query->result_array() as $row) {
			$r = array();

			foreach ($this->columns as $column) {
				$r[] = $row[$column];
			}

			if ($row_id === 'id') {
				$r['DT_RowId'] = $row[$this->primary_key];
			}

			if ($row_id === 'data') {
				$r['DT_RowData'] = array(
					'id' => $row[$this->primary_key]
				);
			}

			if ($row_class !== '') {
				$r['DT_RowClass'] = $row_class;
			}

			$data['data'][] = $r;
		}

		$data['draw'] = (int) $this->request['draw'];

		$data['recordsTotal'] = $this->records_total();

		$data['recordsFiltered'] = $this->records_filtered();

		$this->response($data);
	}
}
