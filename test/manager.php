<?php

use Ledc\PrinterSdk\Manager;

require_once dirname(__DIR__) . '/vendor/autoload.php';
$config = [
    'domain' => 'http://hnshengzhong.cn',
    'id_number' => 1,
    'passphrase' => '',
    //'debug' => true,
];
$manager = new Manager($config);
var_dump($manager->create('阿亮烧烤', 'shop.hnshengzhong.cn', 'http://shop.hnshengzhong.cn/api/printer/notify'));