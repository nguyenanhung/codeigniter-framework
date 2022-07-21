<?php
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
			if (defined('HOST_ELASTICSEARCH')) {
				$this->esHost = HOST_ELASTICSEARCH;
			} else {
				$this->esHost = $host;
			}
			$this->client = \Elastic\Elasticsearch\ClientBuilder::create()->setHosts([$this->esHost])->build();
		}

		public function get_info()
		{
			return $this->client->info();
		}

		public function exists_index($index)
		{
			$status = 404;
			if ($index) {
				$params   = ['index' => $index];
				$response = $this->client->indices()->exists($params);
				$status   = $response->getStatusCode();
			}

			return $status;
		}

		public function create_index($index, $body)
		{
			$params   = ['index' => $index, 'body' => $body];
			$response = $this->client->indices()->create($params);
		}

		public function refresh_index($index)
		{
			$params   = ['index' => $index];
			$response = $this->client->indices()->refresh($params);
		}

		public function delete_index($index)
		{
			if (!$index) {
				return false;
			}
			$params = ['index' => $index];
			try {
				$response = $this->client->indices()->delete($params);
			} catch (Exception $e) {
			}

			return true;
		}

		public function get_found_document($index, $type, $id)
		{
			//db - collection - id
			$params  = ['index' => $index, 'type' => $type, 'id' => $id];
			$results = $this->client->get($params);

			return $results['found'];
		}

		public function exists_document($index, $type, $id)
		{
			$params = ['index' => $index, 'type' => $type, 'id' => $id];

			return $this->client->exists($params);
		}

		public function create_document($index, $type, $id, $body)
		{
			$params = [
				'index' => $index,
				'type'  => $type,
				'id'    => $id,
				'body'  => $body];

			return $this->client->index($params);
		}

		public function update_document($index, $type, $id, $body)
		{
			$params = [
				'index' => $index,
				'type'  => $type,
				'id'    => $id,
				'body'  => $body];

			return $this->client->update($params);
		}

		public function delete_document($index, $type, $id)
		{
			$params = [
				'index'   => $index,
				'type'    => $type,
				'refresh' => 'wait_for', //or true
				'id'      => $id];

			return $this->client->delete($params);
		}

		public function search_document($index, $type, $from, $size, $query, $all)
		{
			$params = [
				'index' => $index,
				'type'  => $type,
				'body'  => [
					'from'  => $from,
					'size'  => $size,
					'query' => $query]];
			if ($all) {
				$params = [
					'index' => $index,
					'type'  => $type,
					'from'  => $from,
					'size'  => $size,
					'body'  => ['query' => $query]];
			}

			return $this->client->search($params);
		}

		public function count_documents($index, $type, $query)
		{
			$exists_index = $this->exists_index($index);
			if ($exists_index === 200) {
				$params   = [
					'index' => $index,
					'type'  => $type,
					'body'  => ['query' => $query]];
				$response = $this->client->count($params);
			} else {
				$response['count'] = 0;
			}

			return $response;
		}
	}
}
