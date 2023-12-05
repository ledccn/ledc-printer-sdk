<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\ResponseProtocols;

/**
 * 不支持的协议
 */
class NotSupportResponse extends ResponseProtocols
{
    /**
     * @var string|array
     */
    protected $data;

    /**
     * @param array|string $data
     */
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->data = $data;
    }
}
