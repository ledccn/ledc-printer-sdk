<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\ResponseProtocols;

/**
 * 【响应】打印通知
 */
class PrintResponse extends ResponseProtocols
{
    /**
     * @var string
     */
    public $taskID = '';
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
}
