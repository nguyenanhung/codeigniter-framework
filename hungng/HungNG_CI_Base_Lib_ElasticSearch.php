<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 21/07/2022
 * Time: 16:29
 */
if (!class_exists('HungNG_CI_Base_Lib_ElasticSearch')) {
	/**
	 * Class HungNG_CI_Base_Lib_ElasticSearch
	 *
	 * @author    713uk13m <dev@nguyenanhung.com>
	 * @copyright 713uk13m <dev@nguyenanhung.com>
	 */
	class HungNG_CI_Base_Lib_ElasticSearch
	{
		private   $client;
		protected $esHost;
		protected $CI;

		public function __construct($host = 'http://127.0.0.1:9200')
		{
			$this->CI =& get_instance();

			log_message('info', 'HungNG_CI_Base_Lib_ElasticSearch Class Initialized');

			if (defined('HOST_ELASTICSEARCH')) {
				$this->esHost = HOST_ELASTICSEARCH;
			} else {
				$this->esHost = $host;
			}
			if (!class_exists('Elastic\Elasticsearch\ClientBuilder')) {
				show_error("The elasticsearch/elasticsearch packages has not been installed or enabled", 500);
				$this->client = null;
			} else {
				$this->client = \Elastic\Elasticsearch\ClientBuilder::create()->setHosts([$this->esHost])->build();
			}
		}

		public function get_info()
		{
			return $this->client->info();
		}

		public function exists_index($index)
		{
			$status = 404;
			if ($index) {
				$params = array('index' => $index);
				$response = $this->client->indices()->exists($params);
				$status = $response->getStatusCode();
			}

			return $status;
		}

		public function create_index($index, $body)
		{
			$params = array('index' => $index, 'body' => $body);
			$response = $this->client->indices()->create($params);
		}

		public function refresh_index($index)
		{
			$params = array('index' => $index);
			$response = $this->client->indices()->refresh($params);
		}

		public function delete_index($index)
		{
			if (!$index) {
				return false;
			}
			$params = array('index' => $index);
			try {
				$response = $this->client->indices()->delete($params);
			} catch (Exception $e) {
			}

			return true;
		}

		public function get_found_document($index, $type, $id)
		{
			//db - collection - id
			$params = array(
				'index' => $index,
				'type'  => $type,
				'id'    => $id
			);
			$results = $this->client->get($params);

			return $results['found'];
		}

		public function exists_document($index, $type, $id)
		{
			$params = array(
				'index' => $index,
				'type'  => $type,
				'id'    => $id
			);

			return $this->client->exists($params);
		}

		public function create_document($index, $type, $id, $body)
		{
			$params = array(
				'index' => $index,
				'type'  => $type,
				'id'    => $id,
				'body'  => $body
			);

			return $this->client->index($params);
		}

		public function update_document($index, $type, $id, $body)
		{
			$params = array(
				'index' => $index,
				'type'  => $type,
				'id'    => $id,
				'body'  => $body
			);

			return $this->client->update($params);
		}

		public function delete_document($index, $type, $id)
		{
			$params = array(
				'index'   => $index,
				'type'    => $type,
				'refresh' => 'wait_for', //or true
				'id'      => $id
			);

			return $this->client->delete($params);
		}

		public function search_document($index, $type, $from, $size, $query, $all)
		{
			$params = array(
				'index' => $index,
				'type'  => $type,
				'body'  => array(
					'from'  => $from,
					'size'  => $size,
					'query' => $query
				)
			);
			if ($all) {
				$params = array(
					'index' => $index,
					'type'  => $type,
					'from'  => $from,
					'size'  => $size,
					'body'  => array('query' => $query)
				);
			}

			return $this->client->search($params);
		}

		public function count_documents($index, $type, $query)
		{
			$exists_index = $this->exists_index($index);
			if ($exists_index === 200) {
				$params = array(
					'index' => $index,
					'type'  => $type,
					'body'  => array('query' => $query)
				);
				$response = $this->client->count($params);
			} else {
				$response['count'] = 0;
			}

			return $response;
		}
	}
}
