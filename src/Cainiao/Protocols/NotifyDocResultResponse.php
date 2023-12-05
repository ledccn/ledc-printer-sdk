<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\ResponseProtocols;
use Ledc\PrinterSdk\Cainiao\StatusResponseInterface;

/**
 * 【响应】打印通知-文档纬度
 */
class NotifyDocResultResponse extends ResponseProtocols implements StatusResponseInterface
{
    /**
     * @var string
     */
    public $status = '';
    /**
     * 进⾏处理的打印机名称
     * @var string
     */
    public $printer = '';
    /**
     * @var string
     */
    public $taskID = '';
    /**
     * 描述信息
     * @var string
     */
    public $detail = '';
    /**
     * 该数据对应的 doc
     * @var string|int
     */
    public $documentId = '';
    /**
     * 0 为成功,其他为失
     * @var int|string
     */
    public $code = 0;

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return 0 === (int)$this->code;
    }
}
