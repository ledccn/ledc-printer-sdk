<?php

namespace Ledc\PrinterSdk\Cainiao;

use JsonSerializable;

/**
 * 【响应】协议抽象类
 */
abstract class ResponseProtocols implements JsonSerializable
{
    use HasResponseHeader, HasInitialize;

    /**
     * 构造函数
     * @param string|array $buffer
     */
    public function __construct($buffer)
    {
        if (is_string($buffer)) {
            $buffer = json_decode($buffer, true);
        }

        $this->initialize($buffer);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this), function ($v) {
            return (null !== $v && '' !== $v);
        });
    }

    /**
     * 获取
     * - 支持 . 分割符
     * @param array $origin
     * @param int|string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    protected static function get(array $origin, $key = null, $default = null)
    {
        if (null === $key) {
            return $origin;
        }
        $keys = explode('.', $key);
        $value = $origin;
        foreach ($keys as $index) {
            if (!isset($value[$index])) {
                return $default;
            }
            $value = $value[$index];
        }
        return $value;
    }
}
