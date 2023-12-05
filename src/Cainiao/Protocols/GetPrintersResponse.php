<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\ResponseProtocols;
use Ledc\PrinterSdk\Cainiao\StatusResponseInterface;

/**
 * 【响应】获取打印机列表(getPrinters)
 */
class GetPrintersResponse extends ResponseProtocols implements StatusResponseInterface
{
    /**
     * 默认打印机
     * @var string
     */
    public $defaultPrinter = '';
    /**
     * @var string
     */
    public $status = '';
    /**
     * @var string
     */
    public $msg = '';
    /**
     * @var int|string
     */
    public $errorCode = 0;
    /**
     * @var array string printers.name 打印机的名字
     * @var array
     */
    public $printers = [];

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return 'success' === $this->status;
    }
}