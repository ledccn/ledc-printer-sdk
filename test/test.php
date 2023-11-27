<?php

use Ledc\PrinterSdk\PrinterHelper;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = [
    'domain' => 'http://hnshengzhong.cn',
    'app_id' => 1,
    'app_secret' => '',
];
$api = PrinterHelper::getInstance($config);
var_dump($api->config());
$origin_id = 1;
$task_id = 1;
$total = 1;
do {
    var_dump($api->print($origin_id, $task_id, true, '[{"documentID":"0123456789","contents":[{"data":{"recipient":{"address":{"city":"杭州市","detail":"良睦路999号乐佳国际大厦2号楼小邮局","district":"余杭区","province":"浙江省","town":""},"mobile":"13012345678","name":"菜鸟网络","phone":"057112345678"},"routingInfo":{"consolidation":{"name":"杭州","code":"hangzhou"},"origin":{"name":"杭州","code":"POSTB"},"sortation":{"name":"杭州"},"routeCode":"123A-456-789"},"sender":{"address":{"city":"杭州市","detail":"文一西路1001号阿里巴巴淘宝城5号小邮局","district":"余杭区","province":"浙江省","town":""},"mobile":"13012345678","name":"阿里巴巴","phone":"057112345678"},"shippingOption":{"code":"COD","services":{"SVC-COD":{"value":"200"},"TIMED-DELIVERY":{"value":"SEVERAL-DAYS"},"PAYMENT-TYPE":{"value":"ON-DELIVERY"},"SVC-INSURE":{"value":"1000000"},"SVC-PROMISE-DELIVERY":{"promise-type":"SAMEDAY_DELIVERY"}},"title":"代收货款"},"waybillCode":"0123456789"},"signature":"19d6f7759487e556ddcdd3d499af087080403277b7deed1a951cc3d9a93c42a7e22ccba94ff609976c5d3ceb069b641f541bc9906098438d362cae002dfd823a8654b2b4f655e96317d7f60eef1372bb983a4e3174cc8d321668c49068071eaea873071ed683dd24810e51afc0bc925b7a2445fdbc2034cdffb12cb4719ca6b7","templateURL":"http://cloudprint.cainiao.com/cloudprint/template/getStandardTemplate.json?template_id=101&version=4"}]}]'));
    if ($task_id >= $total) {
        return;
    }
} while ($task_id++);
