<?php

/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/03/2023
 * Time: 23:00
 */
if (!function_exists('codeigniter_hmvc_module_exists')) {
    /**
     * Check if a CodeIgniter module with the given name exists
     *
     * @param $module_name
     *
     * @return bool
     */
    function codeigniter_hmvc_module_exists($module_name)
    {
        return in_array($module_name, codeigniter_hmvc_modules_list(false));
    }
}
if (!function_exists('codeigniter_hmvc_modules_list')) {
    /**
     * Return the CodeIgniter modules list
     *
     * @param bool $with_location
     *
     * @return array
     */
    function codeigniter_hmvc_modules_list($with_location = true)
    {
        if (!function_exists('directory_map')) {
            get_instance()->load->helper('directory');
        }

        $modules = array();

        foreach (Modules::$locations as $location => $offset) {
            $files = directory_map($location, 1);
            if (is_array($files)) {
                foreach ($files as $name) {
                    if (is_dir($location . $name)) {
                        $modules[] = $with_location ? array($location, $name) : $name;
                    }
                }
            }
        }

        return $modules;
    }
}
if (!function_exists('bear_str_to_lower')) {
    function bear_str_to_lower($str)
    {
        if ($str === null) {
            return null;
        }
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($str, 'UTF-8');
        }

        return strtolower($str);
    }
}
if (!function_exists('bear_str_to_upper')) {
    function bear_str_to_upper($str)
    {
        if ($str === null) {
            return null;
        }
        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($str, 'UTF-8');
        }

        return strtoupper($str);
    }
}
if (!function_exists('bear_str_length')) {
    function bear_str_length($str)
    {
        if ($str === null) {
            return null;
        }
        if (function_exists('mb_strlen')) {
            return mb_strlen($str);
        }

        return strlen($str);
    }
}
if (!function_exists('__get_error_message__')) {
    /**
     * Function __get_error_message__
     *
     * @param \Exception|\Throwable $e
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 29/03/2023 53:17
     */
    function __get_error_message__($e)
    {
        return "Error Code: " . $e->getCode() . " - File: " . $e->getFile() . " - Line: " . $e->getLine(
            ) . " - Message: " . $e->getMessage();
    }
}
if (!function_exists('__get_error_trace__')) {
    /**
     * Function __get_error_trace__
     *
     * @param \Exception|\Throwable $e
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 29/03/2023 53:48
     */
    function __get_error_trace__($e)
    {
        return "Error Trace: " . $e->getTraceAsString();
    }
}
if (!function_exists('current_ip')) {
    /**
     * @param $int
     * @return false|int|string
     */
    function current_ip($int = false)
    {
        $ipKeys = array(
            0 => 'HTTP_CF_CONNECTING_IP',
            1 => 'HTTP_X_FORWARDED_FOR',
            2 => 'HTTP_X_FORWARDED',
            3 => 'HTTP_X_IPADDRESS',
            4 => 'HTTP_X_CLUSTER_CLIENT_IP',
            5 => 'HTTP_FORWARDED_FOR',
            6 => 'HTTP_FORWARDED',
            7 => 'HTTP_CLIENT_IP',
            8 => 'HTTP_IP',
            9 => 'REMOTE_ADDR'
        );

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($int === true) {
                        return ip2long($ip);
                    }

                    return $ip;
                }
            }
        }

        if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === 'localhost') {
            return '127.0.0.1';
        }

        return false;
    }
}