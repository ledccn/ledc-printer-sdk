<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\CmdEnum;
use Ledc\PrinterSdk\Cainiao\RequestProtocols;

/**
 * 获取打印机列表
 */
class GetPrinters extends RequestProtocols
{
    /**
     * @param string $requestID
     */
    public function __construct(string $requestID)
    {
        $this->cmd = CmdEnum::getPrinters;
        $this->requestID = $requestID;
    }
}
