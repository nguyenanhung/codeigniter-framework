# CodeIgniter v3.1.11 - vendor packages build

[![Latest Stable Version](http://poser.pugx.org/nguyenanhung/codeigniter-framework/v)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![Total Downloads](http://poser.pugx.org/nguyenanhung/codeigniter-framework/downloads)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![Latest Unstable Version](http://poser.pugx.org/nguyenanhung/codeigniter-framework/v/unstable)](https://packagist.org/packages/nguyenanhung/codeigniter-framework) [![License](http://poser.pugx.org/nguyenanhung/codeigniter-framework/license)](https://packagist.org/packages/nguyenanhung/codeigniter-framework)

Bản đóng gói lại thư mục system framework của CodeIgniter, sử dụng tương thích với Composer và PHP7

Bổ sung thêm 1 số thư viện mở rộng, helpers liên quan

Support mô hình HMVC

## Hướng dẫn tích hợp mô hình HMVC vào dự án

1. Create folder: `modules` trong thư mục `application`. Tham khảo cấu trúc thư mục `modules` tại `sample/modules/` trong thư viện này

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

4. Triển khai viết code trong thư mục modules mới

## Liên hệ

| Name        | Email                | Skype            | Facebook      |
| ----------- | -------------------- | ---------------- | ------------- |
| Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 | @nguyenanhung |

