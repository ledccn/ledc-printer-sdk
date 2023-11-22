<?php

namespace Ledc\PrinterSdk;

use Closure;
use Exception;

/**
 * 单例调用打印SDK
 * - 先给$config赋值，即可用 PrinterHelper::getInstance(); 获取单例对象
 */
final class PrinterHelper
{
    /**
     * 获取配置的回调
     * @var Closure|callable
     */
    protected static $config = null;

    /**
     * @var array<string, Printer>
     */
    protected static $instances = [];

    /**
     * 设置获取配置的回调函数
     * @param Closure|callable $callable 可以是函数、匿名函数、箭头函数、对象方法、静态方法等
     * @return void
     */
    public static function setConfig($callable)
    {
        self::$config = $callable;
    }

    /**
     * 单例调用
     * @return Printer
     * @throws Exception
     */
    public static function getInstance(): Printer
    {
        $config = call_user_func(self::$config);
        $app_id = (new Config($config))->getAppId();
        if (!isset(self::$instances[$app_id])) {
            self::$instances[$app_id] = new Printer($config);
        }
        return self::$instances[$app_id];
    }
}
