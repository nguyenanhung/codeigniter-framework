# CodeIgniter v3.2.x - vendor packages build

[![Latest Stable Version](https://img.shields.io/packagist/v/nguyenanhung/codeigniter-framework.svg?style=flat-square)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/nguyenanhung/codeigniter-framework.svg?style=flat-square)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)
[![Daily Downloads](https://img.shields.io/packagist/dd/nguyenanhung/codeigniter-framework.svg?style=flat-square)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)
[![Monthly Downloads](https://img.shields.io/packagist/dm/nguyenanhung/codeigniter-framework.svg?style=flat-square)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)
[![License](https://img.shields.io/packagist/l/nguyenanhung/codeigniter-framework.svg?style=flat-square)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)
[![PHP Version Require](https://img.shields.io/packagist/dependency-v/nguyenanhung/codeigniter-framework/php)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)

Repackaged version of CodeIgniter's system framework, compatible with Composer and PHP 7, PHP 8

Since version `v3.2.0` - the framework is fully compatible with PHP 8.2

This package is constantly updated with new features from the original CodeIgniter3 branch. So it is always
updated with bug fixes and added new features
---

## Main features

Added some extension libraries, related helpers

- [x] Base Controllers with many available protected methods
- [x] Support HMVC model
- [x] Support RESTful Web Service
- [x] Support Queue Worker
- [x] Support MongoDB database
- [x] Support Elasticsearch: Use third party packages `"elasticsearch/elasticsearch": "^8.0 || ^7.0 || ^6.0 || ^5.0"`
- [x] Support Base Model class with some basic functions enough for SQL
- [x] Support ORM Model class, providing a simpler and easier method to query
- [x] Support Output Response on CLI interface via function `ResponseOutput::writeLn($message)`
- [x] Added `StatusCodes` class to declare standard HTTP codes (from Symfony framework),
  For example: `StatusCodes::HTTP_OK`. For more details, please refer to class `StatusCodes`
- [x] Add many useful helpers with the built-in package `nguyenanhung/codeigniter-basic-helper` via
  Composer

## Instructions for installing packages into the project

1. Install the package into the project with the following command

```shell
composer require nguyenanhung/codeigniter-framework
```

2. Update the `index.php` file

Find the line

```php
/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
	$system_path = 'system';
```

Edit as follows

```php
/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
	$system_path = '/your_vendor_path/nguyenanhung/codeigniter-framework/system';
```

3. Delete the `system` folder in the project root folder for neatness

## User guide

### Instructions for writing a Controller that inherits a Base Controller

In the library, there is a built-in Base Controller, inherit as follows

1. Build a new `Controller` according to the CodeIgniter 3 documentation
2. Inherit the class from `HungNG_CI_Base_Controllers` instead of `CI_Controller`, for example as follows

```php
<?php
/**
 * Class Hungna_test
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Hungna_test extends HungNG_CI_Base_Controllers
{
	public function __construct()
    {
        parent::__construct();
    }
  	
  	public function index()
    {
		echo "This is ".get_class($this); // show: This is Hungna_test
		exit();
    }
}

```

### Instructions for writing a Controller that runs a Queue Worker

In the library, there is a built-in Base Queue Worker (built by yidas), inherit as follows

1. Build a new `Controller` according to the CodeIgniter 3 documentation
2. Inherit the class from `HungNG_CI_Base_Queue_Worker` instead of `CI_Controller`, for example as follows

```php
<?php
/**
 * Class My_worker
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class My_worker extends HungNG_CI_Base_Queue_Worker
{
    // Initializer
    protected function init() {}
    
    // Worker
    protected function handleWork() {}
    
    // Listener
    protected function handleListen() {}
}

```

Learn more details in the documentation
here: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-queue-worker](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-queue-worker)

### Instructions for writing a Controller to run RESTful API Service

In the library, there is a pre-built RESTful Base (built by yidas), inherit as follows

1. Build a new `Controller` according to the CodeIgniter 3 documentation
2. Inherit the class from `HungNG_CI_Base_REST` instead of `CI_Controller`, for example as follows

```php
<?php
/**
 * Class My_rest_api
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class My_rest_api extends HungNG_CI_Base_REST
{
    public function index()
    {
        return $this->response->json(['bar'=>'foo']);
    }
    
	public function store($requestData=null) {
	
	    $this->db->insert('mytable', $requestData);
	    $id = $this->db->insert_id();
	    
	    return $this->response->json(['id'=>$id], 201);
	}
}

```

Learn more details in the documentation
here: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-rest](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-rest)

### Instructions for writing a Model that inherits Base Model

1. Build a model according to the CodeIgniter 3 documentation
2. Inherit the class from `HungNG_Custom_Based_model` instead of `CI_Model`, for example as follows

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Credentials_model
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 * @property \CI_DB_query_builder $db
 */
class Credentials_model extends HungNG_Custom_Based_model
{
    const IS_ACTIVE = 1;
    const ROLE_PUSH = 1;
    const ROLE_PULL = 2;
    const ROLE_FULL = 3;

    protected $fieldUsername;
    protected $fieldStatus;
    protected $fieldRole;

    /**
     * Credentials_model constructor.
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->db            = $this->load->database('default', true, true);
        $this->tableName     = 'credentials';
        $this->primary_key   = 'id';
        $this->fieldUsername = 'username';
        $this->fieldStatus   = 'status';
        $this->fieldRole     = 'role';
    }
}
```

### How to write a Model that inherits the Base ORM Model

1. This package adds a modern way to write models in ORM style with Elegant patterns like Laravel Eloquent ORM & Yii2
   Active Record (built by yidas)
2. Read detailed documentation on how to integrate and deploy here with visual and specific
   examples: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-orm-model](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-orm-model)

### Basic SEO Integration Guide

1. This package adds a simple SEO library and helper

2. Read detailed documentation on how to integrate and deploy here with visual and specific
   examples: [https://github.com/nguyenanhung/codeigniter-framework-sample/blob/main/codeigniter3-basic-seo/README.md](https://github.com/nguyenanhung/codeigniter-framework-sample/blob/main/codeigniter3-basic-seo/README.md)

### Instructions for using MongoDB database in the project

1. By default, CodeIgniter v3 does not support MongoDB. However, that is not a limitation, CodeIgniter is an open
   framework, so
   I have added a library to support calling, interacting, and processing with MongoDB database, which is also quite
   similar to CodeIgniter 2's Query
   Builder. Read detailed documentation on how to integrate and deploy here with intuitive and specific
   examples: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-mongodb](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-mongodb)

### Instructions for using Elasticsearch in the project

1. By default, CodeIgniter v3 does not support Elasticsearch. However, that does not limit it, CodeIgniter is an open
   framework,
   so I have added a library to support calling and interacting with Elasticsearch
2. Read detailed documentation on how to integrate and deploy here with intuitive and specific
   examples: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-elasticsearch](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-elasticsearch)

### Instructions for integrating HMVC model into the project

1. Create folder: `modules` in the `application` folder. Refer to the `modules-samples` folder structure
   at https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/modules-sample

```shell
.
└── modules
    └── startup
        ├── config
        │   ├── index.html
        │   └── routes.php
        ├── controllers
        │   ├── Startup.php
        │   └── index.html
        ├── index.html
        ├── models
        │   ├── Startup_model.php
        │   └── index.html
        └── views
            └── index.html

6 directories, 8 files
```

2. Create file `hmvc.php` with the following content

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| HMVC settings
| -------------------------------------------------------------------------
| See: https://github.com/nguyenanhung/CodeIgniter-HMVC
|
*/
$config['modules_locations'] = array(
    APPPATH . 'modules/' => '../modules/'
);

```

3. Load the `hmvc.php` file into the `config.php` file

```php
require_once __DIR__ . '/hmvc.php';
```

4. Create file `MY_Loader.php` in folder `application/core/` with following content

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class MY_Loader
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class MY_Loader extends HungNG_Loader
{

}
```

5. Create file `MY_Router.php` in folder `application/core/` with following content

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class MY_Router
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class MY_Router extends HungNG_Router
{

}

```

6. Deploy the code in the new modules folder, similar to the following

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class TestModule
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class TestModule extends HungNG_CI_Base_Module
{
	public function __construct()
    {
        parent::__construct();
    }
  	
	public function index()
    {
		echo "This is ".get_class($this); // show: This is TestModule
		exit();
    }
}

```

### How to check if the filenames in your project are up to CodeIgniter standards

1. This controller checks CodeIgniter 3.0 class filename.

2. Read detailed documentation on how to integrate and deploy here with visual and specific
   examples: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter3-filename-checker](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter3-filename-checker)

### Instructions for logging all queries in CodeIgniter and recording the Execution Time of each Queries

1. By default, CodeIgniter v3 does not support logging the Execution Time of Queries. However, you can use Hooks to do
   this

2. Read the detailed documentation on how to integrate and deploy here with visual and specific
   examples: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-log-all-queries](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-log-all-queries)

## CodeIgniter Basic Helper

- Over the years of programming with CodeIgniter, I have collected, built and written quite a few helpers, I have
  packaged
  them into the package `nguyenanhung/codeigniter-basic-helper` and integrated them into this package.
- This helper package is still being operated and developed by me every day, the number of projects integrating the
  functions in this package has reached
  thousands
- More detailed information about this helper
  set [https://github.com/nguyenanhung/codeigniter-basic-helper](https://github.com/nguyenanhung/codeigniter-basic-helper)

## Contact Information

| Name        | Email                | Skype            | Facebook      | Website                  |
|-------------|----------------------|------------------|---------------|--------------------------|
| Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 | @nguyenanhung | https://nguyenanhung.com |

