<?php

namespace Ledc\PrinterSdk\Cainiao;

/**
 * 【响应】状态响应契约
 */
interface StatusResponseInterface
{
    /**
     * 契约方法
     * @return bool
     */
    public function isSuccess(): bool;
}
