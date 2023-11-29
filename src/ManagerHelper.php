<?php

namespace Ledc\PrinterSdk;

use RuntimeException;

/**
 * 云打印管理器助手
 */
class ManagerHelper
{
    /**
     * @var array<string, Manager>
     */
    protected static $instances = [];

    /**
     * 单例调用
     * @param array $config
     * @return Manager
     */
    public static function getInstance(array $config): Manager
    {
        $id_number = $config['id_number'] ?? null;
        if (empty($id_number)) {
            throw new RuntimeException('管理者身份ID不能为空');
        }

        if (!isset(self::$instances[$id_number])) {
            self::$instances[$id_number] = new Manager($config);
        }
        return self::$instances[$id_number];
    }
}
