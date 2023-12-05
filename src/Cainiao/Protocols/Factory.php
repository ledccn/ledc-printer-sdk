<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Exception;
use Ledc\PrinterSdk\Cainiao\CmdEnum;
use Ledc\PrinterSdk\Cainiao\ResponseProtocols;

/**
 * 工厂协议
 */
class Factory
{
    /**
     * 创建响应
     * @param string $cmd
     * @param array $buffer
     * @return ResponseProtocols
     * @throws Exception
     */
    public static function createResponse(string $cmd, array $buffer): ResponseProtocols
    {
        $maps = [
            CmdEnum::getPrinters => GetPrintersResponse::class,
            CmdEnum::getAgentInfo => GetAgentInfoResponse::class,
            CmdEnum::ledcPrintProxy => PrintProxyResponse::class,
            CmdEnum::print => PrintResponse::class,
            CmdEnum::notifyTaskResult => NotifyTaskResultResponse::class,
            CmdEnum::notifyDocResult => NotifyDocResultResponse::class,
            CmdEnum::notifyPrintResult => NotifyPrintResultResponse::class,
        ];
        $response = $maps[$cmd] ?? NotSupportResponse::class;

        if (!is_a($response, ResponseProtocols::class, true)) {
            throw new Exception($response . ' 响应协议处理类应继承' . ResponseProtocols::class);
        }

        return new $response($buffer);
    }
}
