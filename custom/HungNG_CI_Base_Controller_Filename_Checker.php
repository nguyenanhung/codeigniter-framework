<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 18/01/2023
 * Time: 00:58
 */
if (!class_exists('HungNG_CI_Base_Controller_Filename_Checker')) {
    class HungNG_CI_Base_Controller_Filename_Checker extends HungNG_CI_Base_Controllers
    {
        protected $dir;
        protected $output_ = array();
        protected $fix = false;

        public function __construct()
        {
            parent::__construct();

            log_message('info', 'HungNG_CI_Base_Controller_Filename_Checker Class Initialized');

            $this->dir = array(
                'controllers',
                'libraries',
                'models',
                'core',
            );
        }

        public function filename($fix = 'no')
        {
            if ($fix === 'fix') {
                $this->fix = true;
            }

            foreach ($this->dir as $dir) {
                $this->recursiveCheckFilename($dir);
            }

            $this->display();
        }

        private function recursiveCheckFilename($dir)
        {
            $iterator = new RecursiveRegexIterator(
                new RecursiveDirectoryIterator(APPPATH . $dir),
                '/\A.+\.php\z/i',
                RecursiveRegexIterator::GET_MATCH
            );

            foreach (new RecursiveIteratorIterator($iterator) as $file) {
                $filename = $file[0];

                $filename_show = preg_replace('/' . preg_quote(APPPATH, '/') . '/', 'APPPATH/', $file[0]);

                if (!$this->checkFilename($filename, $dir)) {
                    $this->output('Error: ' . $filename_show);
                } else {
                    $this->output('Okay: ' . $filename_show);
                }
            }
        }

        private function output($line)
        {
            $this->output_[] = $line . PHP_EOL;
        }

        private function display()
        {
            sort($this->output_);

            if (!is_cli()) {
                echo "<pre>\n";
            }

            foreach ($this->output_ as $line) {
                echo $line;
            }

            if (!is_cli()) {
                echo "</pre>\n";
            }
        }

        private function checkFilename($filepath, $dir)
        {
            $filename = basename($filepath);

            if ($dir === 'libraries' || $dir === 'core') {
                $prefix = config_item('subclass_prefix');

                if ($this->hasPrefix($filename, $prefix)) {
                    $filename = substr($filename, bear_str_length($prefix));
                }
            }

            if (!$this->checkUcFirst($filename)) {
                if ($this->fix) {
                    $newName = dirname($filepath) . '/' . ucfirst($filename);
                    if (rename($filepath, $newName)) {
                        $this->output('Rename: ' . $filepath . PHP_EOL . '     -> ' . $newName);
                    }
                }

                return false;
            }

            return true;
        }

        private function checkUcFirst($filename)
        {
            return ucfirst($filename) === $filename;
        }

        private function hasPrefix($filename, $prefix)
        {
            return strncmp($prefix, $filename, bear_str_length($prefix)) === 0;
        }
    }
}
