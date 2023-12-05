<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\ResponseProtocols;

/**
 * 【响应】打印通知-任务纬度
 */
class NotifyTaskResultResponse extends ResponseProtocols
{
    /**
     * @var string
     */
    public $status = '';
    /**
     * 打印机名
     * @var string
     */
    public $printer = '';
    /**
     * @var string
     */
    public $taskId = '';
    /**
     * @var array
     */
    public $spendTime = [];
    /**
     * @var array
     */
    public $docs = [];
}
