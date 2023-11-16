<?php

namespace Ledc\PrinterSdk;

/**
 * 单例调用打印SDK
 * - 先给$config赋值，即可用 PrinterHelper::getInstance(); 获取单例对象
 */
final class PrinterHelper
{
    /**
     * @var array
     */
    public static $config = [];
    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @return Printer
     */
    public static function getInstance(): Printer
    {
        if (null === self::$instance) {
            self::$instance = new Printer(self::$config);
        }

        return self::$instance;
    }
}
