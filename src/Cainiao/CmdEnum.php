<?php

namespace Ledc\PrinterSdk\Cainiao;

/**
 * 请求命令
 * @link https://support-cnkuaidi.taobao.com/doc.htm?spm=a219a.7629140.0.0.180d75fepcAdKQ#?docId=107014&docType=1
 */
class CmdEnum
{
    /**
     * 打印代理组件调度响应（自定义协议）
     */
    const ledcPrintProxy = 'ledcPrintProxy';
    /**
     * 获取打印机列表(getPrinters)
     */
    const getPrinters = 'getPrinters';

    /**
     * 获取打印机配置(getPrinterConfig)
     */
    const getPrinterConfig = 'getPrinterConfig';

    /**
     * 设置打印机配置(setPrinterConfig)
     */
    const setPrinterConfig = 'setPrinterConfig';

    /**
     * 发送打印/预览数据协议(print)
     * - 注：因为打印机质量乘次不齐，建议 1 个 task 使用 一个 document，可以有效避免重打问题；
     */
    const print = 'print';

    /**
     * 打印通知(notifyTaskResult)
     */
    const notifyTaskResult = 'notifyTaskResult';

    /**
     * 打印通知(notifyDocResult)
     */
    const notifyDocResult = 'notifyDocResult';

    /**
     * 打印通知(notifyPrintResult)
     */
    const notifyPrintResult = 'notifyPrintResult';

    /**
     * 获取任务打印任务状态(getTaskStatus)
     */
    const getTaskStatus = 'getTaskStatus';

    /**
     * 获取全局配置(getGlobalConfig)
     */
    const getGlobalConfig = 'getGlobalConfig';

    /**
     * 设置全局配置(setGlobalConfig)
     */
    const setGlobalConfig = 'setGlobalConfig';

    /**
     * 获取客户端版本信息(getAgentInfo)
     */
    const getAgentInfo = 'getAgentInfo';
}
