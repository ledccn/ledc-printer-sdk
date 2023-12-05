<?php

namespace Ledc\PrinterSdk\Cainiao\Protocols;

use Ledc\PrinterSdk\Cainiao\CmdEnum;
use Ledc\PrinterSdk\Cainiao\RequestProtocols;

/**
 * 【请求】发送打印/预览数据协议(print)
 * - 注：因为打印机质量乘次不齐，建议 1 个 task 使用 一个 document，可以有效避免重打问题；
 */
class Prints extends RequestProtocols
{
    /**
     * @var array
     */
    protected $task = [];

    /**
     * @param string $requestID
     */
    public function __construct(string $requestID)
    {
        $this->cmd = CmdEnum::print;
        $this->requestID = $requestID;
    }

    /**
     * @param PrintsTask $task
     * @return Prints
     */
    public function setTask(PrintsTask $task): self
    {
        $this->task = $task->jsonSerialize();
        return $this;
    }

    /**
     * @return array
     */
    public function getTask(): array
    {
        //	"task": {
        //		"taskID": "7293666",
        //		"preview": false,
        //		"printer": "",
        //		"previewType": "pdf",
        //		"firstDocumentNumber": 10,
        //		"totalDocumentCount": 100,
        //		"documents": [{
        //			"documentID": "0123456789",
        //			"contents": [{
        //				"data": {
        //					"nick": "张三"
        //				},
        //				"templateURL": "http://cloudprint.cainiao.com/template/standard/278250/1"
        //			},
        //			{
        //				"data": {
        //					"value": "测试字段值需要配合自定义区变量名"
        //				},
        //				"templateURL": "http://cloudprint.cainiao.com/template/customArea/440439"
        //			}]
        //		}]
        //	}
        return $this->task;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        //{
        //	"cmd": "print",
        //	"requestID": "123458976",
        //	"version": "1.0",
        //	"task": {
        //		"taskID": "7293666",
        //		"preview": false,
        //		"printer": "",
        //		"previewType": "pdf",
        //		"firstDocumentNumber": 10,
        //		"totalDocumentCount": 100,
        //		"documents": [{
        //			"documentID": "0123456789",
        //			"contents": [{
        //				"data": {
        //					"nick": "张三"
        //				},
        //				"templateURL": "http://cloudprint.cainiao.com/template/standard/278250/1"
        //			},
        //			{
        //				"data": {
        //					"value": "测试字段值需要配合自定义区变量名"
        //				},
        //				"templateURL": "http://cloudprint.cainiao.com/template/customArea/440439"
        //			}]
        //		}]
        //	}
        //}

        return parent::jsonSerialize();
    }
}