<?php

/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/03/2023
 * Time: 14:51
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class CI_Seo_onpage
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 *
 * $config['canonical_url']    = null;
 * $config['site_title']       = "Site Title";
 * $config['site_description'] = "Site Description";
 * $config['site_image']       = null;
 * $config['twitter_user']     = "@tw_username";
 * $config['fb_app_id']        = null;
 * $config['fb_page_id']       = null;
 */
class CI_Seo_onpage
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        log_message('info', 'SEO OnPage Class Initialized');

        $this->CI->load->helper('url');
    }

    public function published($title = "", $description = "", $image = "")
    {
        $this->set_tags($title, $description, $image);
    }

    public function set_tags($title = "", $description = "", $image = "")
    {
        $current_url = current_url();
        echo "<meta property='og:url' content='$current_url' />\n";

        $this->set_title_tags($title);
        $this->set_description_tags($description);
        $this->set_image_tags($image);
        $this->set_twitter_tags();
        $this->set_facebook_tags();
        $this->set_canonical();
    }

    protected function set_title_tags($title)
    {
        if ($title !== "") {
            echo "<title>$title</title>\n";
            echo "<meta property='og:title' content='$title' />\n";
            echo "<meta name='twitter:title' content='$title' />\n";
        } elseif ($this->CI->config->item('site_title') !== "") {
            echo "<title>" . $this->CI->config->item('site_title') . "</title>\n";
            echo "<meta property='og:title' content='" . $this->CI->config->item('site_title') . "' />\n";
            echo "<meta property='og:site_name' content='" . $this->CI->config->item('site_title') . "' />\n";
            echo "<meta name='twitter:title' content='" . $this->CI->config->item('site_title') . "' />\n";
        }
    }

    protected function set_description_tags($description)
    {
        if ($description !== "") {
            echo "<meta name='description' content='$description'/>\n";
            echo "<meta property='og:description' content='$description' />\n";
            echo "<meta name='twitter:description' content='$description' />\n";
        } elseif ($this->CI->config->item('site_description') !== "") {
            echo "<meta name='description' content='" . $this->CI->config->item('site_description') . "'/>\n";
            echo "<meta property='og:description' content='" . $this->CI->config->item('site_description') . "' />\n";
            echo "<meta name='twitter:description' content='" . $this->CI->config->item('site_description') . "' />\n";
        }
    }

    protected function set_image_tags($image)
    {
        $image_path = null;

        if ($image !== "") {
            $image_path = $this->format_image_tags($image);
        } elseif ($this->CI->config->item('site_image') !== "") {
            $image_path = $this->format_image_tags($this->CI->config->item('site_image'));
        }

        if ($image_path) {
            list($width, $height) = getimagesize($image_path);
            echo "<meta property='og:image' content='$image_path' />\n";
            echo "<meta property='og:image:secure_url' content='$image_path' />\n";
            echo "<meta name='twitter:image' content='$image_path' />\n";
            echo "<meta name='twitter:card' content='summary_large_image' />\n";
            echo "<meta property='og:image:width' content='$width' />\n<meta property='og:image:height' content='$height' />\n";
        }
    }

    protected function set_twitter_tags()
    {
        if ($this->CI->config->item('twitter_user') !== "") {
            echo "<meta name='twitter:site' content='" . $this->CI->config->item('twitter_user') . "' />\n";
        }
    }

    protected function set_facebook_tags()
    {
        if ($this->CI->config->item('fb_page_id') !== "") {
            echo "<meta property='fb:pages' content='" . $this->CI->config->item('fb_page_id') . "' />\n";
        }

        if ($this->CI->config->item('fb_app_id') !== "") {
            echo "<meta property='fb:app_id' content='" . $this->CI->config->item('fb_app_id') . "' />\n";
        }
    }

    protected function set_canonical()
    {
        if ($this->CI->config->item('canonical_url') !== "") {
            echo "<link rel='canonical' href='" . $this->CI->config->item('canonical_url') . "' />\n";
        }
    }

    protected function format_image_tags($image_path)
    {
        $path = parse_url($image_path);

        if ($path['scheme'] === "http" || $path['scheme'] === "https") {
            return $image_path;
        }

        return base_url($image_path);
    }
}
