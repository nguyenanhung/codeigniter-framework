# CodeIgniter v3.1.13 - vendor packages build

[![Latest Stable Version](http://poser.pugx.org/nguyenanhung/codeigniter-framework/v)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![Total Downloads](http://poser.pugx.org/nguyenanhung/codeigniter-framework/downloads)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![Latest Unstable Version](http://poser.pugx.org/nguyenanhung/codeigniter-framework/v/unstable)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![License](http://poser.pugx.org/nguyenanhung/codeigniter-framework/license)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![PHP Version Require](http://poser.pugx.org/nguyenanhung/codeigniter-framework/require/php)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)

Bản đóng gói lại thư mục system framework của CodeIgniter, sử dụng tương thích với Composer và PHP 7, PHP 8

Bản đóng gói `v3.1.13` bổ sung thêm 1 số tính năng mới, tương thích với phiên bản PHP 8.1


Mục lục
-------

- [Tính năng](#bổ-sung-thêm-1-số-thư-viện-mở-rộng-helpers-liên-quan)
- [Hướng dẫn cài đặt](#hướng-dẫn-cài-đặt-gói-vào-trong-dự-án)
- [Hướng dẫn sử dụng](#hướng-dẫn-sử-dụng)
	- [Hướng dẫn viết Controller kế thừa Base Controller](#hướng-dẫn-viết-controller-kế-thừa-base-controller)
	- [Hướng dẫn viết Controller chạy Queue Worker](#hướng-dẫn-viết-controller-chạy-queue-worker)
	- [Hướng dẫn viết Controller chạy RESTful API Service](#hướng-dẫn-viết-controller-chạy-restful-api-service)
	- [Hướng dẫn viết Model kế thừa Base Model](#hướng-dẫn-viết-model-kế-thừa-base-model)
	- [Hướng dẫn viết Model kế thừa Base ORM Model](#hướng-dẫn-viết-model-kế-thừa-base-orm-model)
	- [Hướng dẫn tích hợp mô hình HMVC vào dự án](#hướng-dẫn-tích-hợp-mô-hình-hmvc-vào-dự-án)
	- [Hướng dẫn sử dụng CSDL MongoDB trong dự án](#hướng-dẫn-sử-dụng-csdl-mongodb-trong-dự-án)
	- [Hướng dẫn sử dụng Elasticsearch trong dự án](#hướng-dẫn-sử-dụng-elasticsearch-trong-dự-án)
- [Liên hệ & Hỗ trợ](#liên-hệ)

---

## Bổ sung thêm 1 số thư viện mở rộng, helpers liên quan

- [x] Support mô hình HMVC
- [x] Support RESTful Web Service
- [x] Support Queue Worker
- [x] Support CSDL MongoDB
- [x] Support Elasticsearch: Use third party packages `"elasticsearch/elasticsearch": "^8.0 || ^7.0 || ^6.0 || ^5.0"`
- [x] Support class Base Model với 1 số hàm cơ bản
- [x] Hỗ trợ Output Response trên giao diện CLI thông qua hàm `ResponseOutput::writeLn($message)`
- [x] Bổ sung class `StatusCodes` khai báo sẵn các HTTP code tuân chuẩn (from Symfony framework), VD: `StatusCodes::HTTP_OK`. Chi tiết tham khảo thêm tại class `StatusCodes`

## Hướng dẫn cài đặt gói vào trong dự án

1. Cài đặt gói vào trong dự án với lệnh sau

```shell
composer require nguyenanhung/codeigniter-framework
```

2. Cập nhật file `index.php`

Tìm dòng

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

Sửa thành như sau

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

3. Xoá thư mục `system` trong thư mục gốc dự án đi cho gọn

## Hướng dẫn sử dụng

### Hướng dẫn viết Controller kế thừa Base Controller

Trong thư viện đã xây dựng sẵn 1 Base Controller, kế thừa như sau

1. Xây dựng 1 `Controller` mới theo tài liệu CodeIgniter 3
2. Kế thừa class từ `HungNG_CI_Base_Controllers` thay vì `CI_Controller`, ví dụ như sau

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

### Hướng dẫn viết Controller chạy Queue Worker

Trong thư viện đã xây dựng sẵn 1 Base Queue Worker (được xây dựng bởi yidas), kế thừa như sau

1. Xây dựng 1 `Controller` mới theo tài liệu CodeIgniter 3
2. Kế thừa class từ `HungNG_CI_Base_Queue_Worker ` thay vì `CI_Controller`, ví dụ như sau

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

Tìm hiểu thêm chi tiết tài liệu tại đây: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-queue-worker](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-queue-worker)

### Hướng dẫn viết Controller chạy RESTful API Service

Trong thư viện đã xây dựng sẵn 1 Base RESTful (được xây dựng bởi yidas), kế thừa như sau

1. Xây dựng 1 `Controller` mới theo tài liệu CodeIgniter 3
2. Kế thừa class từ `HungNG_CI_Base_REST ` thay vì `CI_Controller`, ví dụ như sau

```php
<?php
/**
 * Class My_worker
 *
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class My_worker extends HungNG_CI_Base_REST
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

Tìm hiểu thêm chi tiết tài liệu tại đây: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-rest](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-rest)

### Hướng dẫn viết Model kế thừa Base Model

1. Xây dựng 1 model theo tài liệu CodeIgniter 3
2. Kế thừa class từ `HungNG_Custom_Based_model` thay vì `CI_Model`, ví dụ như sau

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

### Hướng dẫn viết Model kế thừa Base ORM Model

1. Package này bổ sung thêm 1 phương án viết model hiện đại theo phong cách ORM với Elegant patterns giống như Laravel Eloquent ORM & Yii2 Active Record (được xây dựng bởi yidas)
2. Đọc tài liệu chi tiết về cách tích hợp và triển khai tại đây với những ví dụ trực quan và cụ
   thể: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-orm-model](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-orm-model)

### Hướng dẫn sử dụng CSDL MongoDB trong dự án

1. Mặc định, CodeIgniter v3 không hỗ trợ MongoDB. Tuy nhiên không vì thế mà hạn chế, CodeIgniter là framework mở, vì vậy tôi đã bổ sung thêm 1 thư viện hỗ trợ việc gọi, tương tác, xử lý với CSDL MongoDB mà cách sử dụng cũng tương đối giống với Query
   Builder của CodeIgniter
2. Đọc tài liệu chi tiết về cách tích hợp và triển khai tại đây với những ví dụ trực quan và cụ
   thể: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-mongodb](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-mongodb)

### Hướng dẫn sử dụng Elasticsearch trong dự án

1. Mặc định, CodeIgniter v3 không hỗ trợ Elasticsearch. Tuy nhiên không vì thế mà hạn chế, CodeIgniter là framework mở, vì vậy tôi đã bổ sung thêm 1 thư viện hỗ trợ việc gọi, tác với Elasticsearch
2. Đọc tài liệu chi tiết về cách tích hợp và triển khai tại đây với những ví dụ trực quan và cụ
   thể: [https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-elasticsearch](https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/codeigniter-elasticsearch)

### Hướng dẫn tích hợp mô hình HMVC vào dự án

1. Create folder: `modules` trong thư mục `application`. Tham khảo cấu trúc thư mục `modules-samples` tại https://github.com/nguyenanhung/codeigniter-framework-sample/tree/main/modules-sample

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

2. Create file `hmvc.php` với nội dung như sau

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

3. Nạp file `hmvc.php` vào file `config.php`

```php
require_once __DIR__ . '/hmvc.php';
```

4. Create file `MY_Loader.php` trong thư mục `application/core/` có nội dung như sau

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

5. Create file `MY_Router.php` trong thư mục `application/core/` có nội dung như sau

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

6. Triển khai viết code trong thư mục modules mới, tương tự như sau

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

## Liên hệ

| Name        | Email                | Skype            | Facebook      |
|-------------|----------------------|------------------|---------------|
| Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 | @nguyenanhung |

