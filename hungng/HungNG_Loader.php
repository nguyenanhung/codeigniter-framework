<?php

defined('BASEPATH') or exit('No direct script access allowed');
if (!class_exists('HungNG_Loader')) {
    /* load the MX_Loader class */
    require_once __DIR__ . '/../thirdParty/MX/Loader.php';

    /**
     * Class HungNG_Loader
     *
     * @author    713uk13m <dev@nguyenanhung.com>
     * @copyright 713uk13m <dev@nguyenanhung.com>
     */
    class HungNG_Loader extends MX_Loader
    {
    }
}
