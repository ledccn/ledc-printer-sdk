<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\ResponseProtocols;

/**
 * 【响应】打印通知(notifyPrintResult)
 */
class NotifyPrintResultResponse extends ResponseProtocols
{
    /**
     * @var string
     */
    public $taskID = '';
    /**
     * @var int|string
     */
    public $status = 0;
    /**
     * @var string
     */
    public $msg = '';
    /**
     * @var string
     */
    public $taskStatus = '';
    /**
     * @var string
     */
    public $printer = '';
    /**
     * @var int|string
     */
    public $evaluationSpendTime = 0;
    /**
     * @var int|string
     */
    public $pendingSpendTime = 0;
    /**
     * @var int|string
     */
    public $downloadingSpendTime = 0;
    /**
     * @var int|string
     */
    public $totalSpendTime = 0;
    /**
     * @var array
     */
    protected $printStatus = [];

    /**
     * @param string|null $field
     * @param mixed|null $default
     * @return mixed
     */
    public function getPrintStatus(string $field = null, $default = null)
    {
        return static::get($this->printStatus, $field, $default);
    }
}
