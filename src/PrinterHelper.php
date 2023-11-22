<?php

namespace Ledc\PrinterSdk;

use Exception;

/**
 * 单例调用打印SDK
 * - 先给$config赋值，即可用 PrinterHelper::getInstance(); 获取单例对象
 */
final class PrinterHelper
{
    /**
     * @var array<string, Printer>
     */
    protected static $instances = [];

    /**
     * 单例调用
     * @param array $config
     * @return Printer
     * @throws Exception
     */
    public static function getInstance(array $config): Printer
    {
        $app_id = (new Config($config))->getAppId();
        if (!isset(self::$instances[$app_id])) {
            self::$instances[$app_id] = new Printer($config);
        }
        return self::$instances[$app_id];
    }
}
