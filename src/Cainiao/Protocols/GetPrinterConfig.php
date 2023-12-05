<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\CmdEnum;
use Ledc\PrinterSdk\Cainiao\RequestProtocols;

/**
 * 获取打印机配置(getPrinterConfig)
 */
class GetPrinterConfig extends RequestProtocols
{
    /**
     * @param string $requestID
     */
    public function __construct(string $requestID)
    {
        $this->cmd = CmdEnum::getPrinterConfig;
        $this->requestID = $requestID;
    }
}
