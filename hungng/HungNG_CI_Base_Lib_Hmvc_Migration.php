<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 18/01/2023
 * Time: 00:28
 */
if (!class_exists('HungNG_CI_Base_Lib_Hmvc_Migration')) {
	/**
	 * Migration Class for HMVC application
	 *
	 * All migrations should implement this, forces up() and down() and gives
	 * access to the CI super-global.
	 *
	 * Usage :
	 *        $this->load->library('migration');
	 *        $this->migration->migrate_all_modules();
	 *
	 *        if ($this->migration->init_module($module_name))
	 *            $this->migration->current();
	 *
	 *        if ($this->migration->init_module($module_name))
	 *            $this->migration->version($module_version);
	 *
	 *
	 * @author        Michel Roca
	 *
	 * @property CI_Benchmark                                                          $benchmark                           This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
	 * @property CI_Calendar                                                           $calendar                            This class enables the creation of calendars
	 * @property CI_Cache                                                              $cache                               Caching Class
	 * @property CI_Cart                                                               $cart                                Shopping Cart Class
	 * @property CI_Config                                                             $config                              This class contains functions that enable config files to be managed
	 * @property CI_Controller                                                         $controller                          This class object is the super class that every library in CodeIgniter will be assigned to
	 * @property CI_DB_forge                                                           $dbforge                             Database Forge Class
	 * @property CI_DB_pdo_driver|CI_DB_mysqli_driver|CI_DB_query_builder|CI_DB_driver $db                                  This is the platform-independent base Query Builder implementation class
	 * @property CI_DB_utility                                                         $dbutil                              Database Utility Class
	 * @property CI_Driver_Library                                                     $driver                              Driver Library Class
	 * @property CI_Email                                                              $email                               Permits email to be sent using Mail, Sendmail, or SMTP
	 * @property CI_Encrypt                                                            $encrypt                             Provides two-way keyed encoding using Mcrypt
	 * @property CI_Encryption                                                         $encryption                          Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions
	 * @property CI_Exceptions                                                         $exceptions                          Exceptions Class
	 * @property CI_Form_validation                                                    $form_validation                     Form Validation Class
	 * @property CI_FTP                                                                $ftp                                 FTP Class
	 * @property CI_Hooks                                                              $hooks                               Provides a mechanism to extend the base system without hacking
	 * @property CI_Image_lib                                                          $image_lib                           Image Manipulation class
	 * @property CI_Input                                                              $input                               Pre-processes global input data for security
	 * @property CI_Javascript                                                         $javascript                          Javascript Class
	 * @property CI_Jquery                                                             $jquery                              Jquery Class
	 * @property CI_Lang                                                               $lang                                Language Class
	 * @property CI_Loader                                                             $load                                Loads framework components
	 * @property CI_Log                                                                $log                                 Logging Class
	 * @property CI_Migration                                                          $migration                           All migrations should implement this, forces up() and down() and gives access to the CI super-global
	 * @property CI_Model                                                              $model                               CodeIgniter Model Class
	 * @property CI_Output                                                             $output                              Responsible for sending final output to the browser
	 * @property CI_Pagination                                                         $pagination                          Pagination Class
	 * @property CI_Parser                                                             $parser                              Parser Class
	 * @property CI_Profiler                                                           $profiler                            This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
	 * @property CI_Router                                                             $router                              Parses URIs and determines routing
	 * @property CI_Security                                                           $security                            Security Class
	 * @property CI_Session                                                            $session                             Session Class
	 * @property CI_Table                                                              $table                               Lets you create tables manually or from database result objects, or arrays
	 * @property CI_Trackback                                                          $trackback                           Trackback Sending/Receiving Class
	 * @property CI_Typography                                                         $typography                          Typography Class
	 * @property CI_Unit_test                                                          $unit                                Simple testing class
	 * @property CI_Upload                                                             $upload                              File Uploading Class
	 * @property CI_URI                                                                $uri                                 Parses URIs and determines routing
	 * @property CI_User_agent                                                         $agent                               Identifies the platform, browser, robot, or mobile device of the browsing agent
	 * @property CI_Xmlrpc                                                             $xmlrpc                              XML-RPC request handler class
	 * @property CI_Xmlrpcs                                                            $xmlrpcs                             XML-RPC server class
	 * @property CI_Zip                                                                $zip                                 Zip Compression Class
	 * @property CI_Utf8                                                               $utf8                                Provides support for UTF-8 environments
	 */
	class HungNG_CI_Base_Lib_Hmvc_Migration
	{
		protected $_migration_enabled = false;
		protected $_migration_path = null;
		protected $_migration_version = 0;

		protected $_current_module = '';

		protected $_core_config = array();

		protected $_error_string = '';

		public function __construct($config = array())
		{
			# Only run this constructor on main library load
			if (get_parent_class($this) !== false) {
				return;
			}

			$this->_core_config = $config;

			$this->init_module();

			log_message('debug', 'Migrations class initialized');

			// Are they trying to use migrations while it is disabled?
			if ($this->_migration_enabled !== true) {
				show_error('Migrations has been loaded but is disabled or set up incorrectly.');
			}

			// Load migration language
			$this->lang->load('migration');

			// They'll probably be using dbforge
			$this->load->dbforge();

			// If the migrations table is missing, make it
			if (!$this->db->table_exists('migrations')) {
				$this->dbforge->add_field(array(
											  'module'  => array('type' => 'VARCHAR', 'constraint' => 20),
											  'version' => array('type' => 'INT', 'constraint' => 3),
										  ));

				$this->dbforge->create_table('migrations', true);

				$this->db->insert('migrations', array('module' => 'CI_core', 'version' => 0));
			}
		}

		public function display_current_migrations()
		{
			$modules = $this->list_all_modules_with_migrations();

			$migrations = array();
			foreach ($modules as $module) {
				$this->init_module($module[1]);
				$migrations[$module[1]] = $this->_get_version($module[1]);
			}

			return $migrations;
		}

		public function display_all_migrations()
		{
			$modules = $this->list_all_modules_with_migrations();

			$migrations = array();
			foreach ($modules as $module) {
				$this->init_module($module[1]);
				$migrations[$module[1]] = $this->find_migrations();
			}

			return $migrations;
		}

		public function migrate_all_modules()
		{
			$modules = $this->list_all_modules_with_migrations();
			foreach ($modules as $module) {
				$this->init_module($module[1]);
				$this->current();
			}

			return true;

		}

		public function list_all_modules_with_migrations()
		{
			$modules = $this->list_all_modules();

			foreach ($modules as $i => $module) {
				list($location, $name) = $module;

				if ($this->init_module($name) !== true)
					unset($modules[$i]);
			}

			return array_merge(array(array('', 'CI_core')), $modules);
		}

		public function list_all_modules()
		{
			return codeigniter_hmvc_modules_list();
		}

		public function init_module($module = 'CI_core')
		{
			if ($module === 'CI_core') {

				$config = $this->_core_config;
				$config['migration_path'] == '' and $config['migration_path'] = APPPATH . 'migrations/';

			} else {

				list($path, $file) = Modules::find('migration', $module, 'config/');

				if ($path === false)
					return false;

				if (!$config = Modules::load_file($file, $path, 'config'))
					return false;

				!$config['migration_path'] and $config['migration_path'] = '../migrations';

				$config['migration_path'] = $this->normalizePath($path . $config['migration_path']);

			}

			foreach ($config as $key => $val) {
				$this->{'_' . $key} = $val;
			}

			if ($this->_migration_enabled !== true)
				return false;

			$this->_migration_path = rtrim($this->_migration_path, '/') . '/';

			if (!file_exists($this->_migration_path))
				return false;

			$this->_current_module = $module;

			return true;
		}

		/**
		 * Migrate to a schema version
		 *
		 * Calls each migration step required to get to the schema version of
		 * choice
		 *
		 * @param int $target_version Target schema version
		 *
		 * @return    mixed    TRUE if already latest, FALSE if failed, int if upgraded
		 */
		public function version($target_version)
		{
			$start = $current_version = $this->_get_version();
			$stop = $target_version;

			if ($target_version > $current_version) {
				// Moving Up
				++$start;
				++$stop;
				$step = 1;
			} else {
				// Moving Down
				$step = -1;
			}

			$method = ($step === 1) ? 'up' : 'down';
			$migrations = array();

			// We now prepare to actually DO the migrations
			// But first let's make sure that everything is the way it should be
			for ($i = $start; $i != $stop; $i += $step) {
				$f = glob(sprintf($this->_migration_path . '%03d_*.php', $i));

				// Only one migration per step is permitted
				if (count($f) > 1) {
					$this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $i);

					return false;
				}

				// Migration step not found
				if (count($f) == 0) {
					// If trying to migrate up to a version greater than the last
					// existing one, migrate to the last one.
					if ($step == 1) {
						break;
					}

					// If trying to migrate down but we're missing a step,
					// something must definitely be wrong.
					$this->_error_string = sprintf($this->lang->line('migration_not_found'), $i);

					return false;
				}

				$file = basename($f[0]);
				$name = basename($f[0], '.php');

				// Filename validations
				if (preg_match('/^\d{3}_(\w+)$/', $name, $match)) {
					$match[1] = strtolower($match[1]);

					// Cannot repeat a migration at different steps
					if (in_array($match[1], $migrations)) {
						$this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $match[1]);

						return false;
					}

					include $f[0];
					$class = 'Migration_' . ucfirst($match[1]);

					if (!class_exists($class)) {
						$this->_error_string = sprintf($this->lang->line('migration_class_doesnt_exist'), $class);

						return false;
					}

					if (!is_callable(array($class, $method))) {
						$this->_error_string = sprintf($this->lang->line('migration_missing_' . $method . '_method'), $class);

						return false;
					}

					$migrations[] = $match[1];
				} else {
					$this->_error_string = sprintf($this->lang->line('migration_invalid_filename'), $file);

					return false;
				}
			}

			log_message('debug', 'Current migration: ' . $current_version);

			$version = $i + ($step == 1 ? -1 : 0);

			// If there is nothing to do so quit
			if ($migrations === array()) {
				return true;
			}

			log_message('debug', 'Migrating from ' . $method . ' to version ' . $version);

			// Loop through the migrations
			foreach ($migrations as $migration) {
				// Run the migration class
				$class = 'Migration_' . ucfirst(strtolower($migration));
				call_user_func(array(new $class, $method));

				$current_version += $step;
				$this->_update_version($current_version);
			}

			log_message('debug', 'Finished migrating to ' . $current_version);

			return $current_version;
		}

		// --------------------------------------------------------------------

		/**
		 * Set's the schema to the latest migration
		 *
		 * @return    mixed    true if already latest, false if failed, int if upgraded
		 */
		public function latest()
		{
			if (!$migrations = $this->find_migrations()) {
				$this->_error_string = $this->lang->line('migration_none_found');

				return false;
			}

			$last_migration = basename(end($migrations));

			// Calculate the last migration step from existing migration
			// filenames and procceed to the standard version migration
			return $this->version((int) substr($last_migration, 0, 3));
		}

		// --------------------------------------------------------------------

		/**
		 * Set's the schema to the migration version set in config
		 *
		 * @return    mixed    true if already current, false if failed, int if upgraded
		 */
		public function current()
		{
			return $this->version($this->_migration_version);
		}

		// --------------------------------------------------------------------

		/**
		 * Error string
		 *
		 * @return    string    Error message returned as a string
		 */
		public function error_string()
		{
			return $this->_error_string;
		}

		// --------------------------------------------------------------------

		/**
		 * Set's the schema to the latest migration
		 *
		 * @return    mixed    true if already latest, false if failed, int if upgraded
		 */
		protected function find_migrations()
		{
			// Load all *_*.php files in the migrations path
			$files = glob($this->_migration_path . '*_*.php');
			$file_count = count($files);

			for ($i = 0; $i < $file_count; $i++) {
				// Mark wrongly formatted files as false for later filtering
				$name = basename($files[$i], '.php');
				if (!preg_match('/^\d{3}_(\w+)$/', $name)) {
					$files[$i] = false;
				}
			}

			sort($files);

			return $files;
		}

		// --------------------------------------------------------------------

		/**
		 * Retrieves current schema version
		 *
		 * @param string $module
		 *
		 * @return    int    Current Migration
		 */
		protected function _get_version($module = '')
		{
			!$module and $module = $this->_current_module;
			$row = $this->db->get_where('migrations', array('module' => $module))->row();

			return $row ? $row->version : 0;
		}

		// --------------------------------------------------------------------

		/**
		 * Stores the current schema version
		 *
		 * @param int    $migrations Migration reached
		 * @param string $module
		 *
		 * @return    bool
		 */
		protected function _update_version($migrations, $module = '')
		{
			!$module and $module = $this->_current_module;
			$row = $this->db->get_where('migrations', array('module' => $module));
			$ob = $row->row();
			if ($ob != null) {
				return $this->db->where(array('module' => $module))->update('migrations', array('version' => $migrations));
			} else {
				return $this->db->insert('migrations', array('module' => $module, 'version' => $migrations));
			}
		}

		// --------------------------------------------------------------------
		/**
		 * Remove the ".." from the middle of a path string
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		protected function normalizePath($path)
		{
			$parts = array(); // Array to build a new path from the good parts
			$path = str_replace('\\', '/', $path); // Replace backslashes with forwardslashes
			$path = preg_replace('/\/+/', '/', $path); // Combine multiple slashes into a single slash
			$segments = explode('/', $path); // Collect path segments
			foreach ($segments as $segment) {
				if ($segment != '.') {
					$test = array_pop($parts);
					if (is_null($test))
						$parts[] = $segment; elseif ($segment == '..') {
						if ($test == '..')
							$parts[] = $test;

						if ($test == '..' || $test == '')
							$parts[] = $segment;
					} else {
						$parts[] = $test;
						$parts[] = $segment;
					}
				}
			}

			return implode('/', $parts);
		}
		// --------------------------------------------------------------------

		/**
		 * Enable the use of CI super-global
		 *
		 * @param mixed $var
		 *
		 * @return    mixed
		 */
		public function __get($var)
		{
			return get_instance()->$var;
		}
	}
}
